<?php
/**
 * Edit Event Page
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Edit Event";
$include_editor = true; // Include rich text editor

// Authentication check
define('AUTH_REQUIRED', true);

$error = '';
$success = '';

// Get event ID
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($event_id <= 0) {
    header('Location: index.php?error=' . urlencode('Invalid event ID'));
    exit();
}

// Fetch event data
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: index.php?error=' . urlencode('Event not found'));
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $title = sanitize_input($_POST['title'] ?? '');
    $description = $_POST['description'] ?? ''; // Don't sanitize HTML content from editor
    $location = sanitize_input($_POST['location'] ?? '');
    $start_datetime = sanitize_input($_POST['start_datetime'] ?? '');
    $end_datetime = sanitize_input($_POST['end_datetime'] ?? '');
    $entry_type = sanitize_input($_POST['entry_type'] ?? 'free');
    $entry_fee = isset($_POST['entry_fee']) ? floatval($_POST['entry_fee']) : 0;
    $status = sanitize_input($_POST['status'] ?? 'upcoming');
    $image_url = $event['image']; // Keep existing image by default

    // var_dump($description);
    // die();

    // Validation
    if (empty($title)) {
        $error = 'Event title is required';
    } elseif (empty($location)) {
        $error = 'Location is required';
    } elseif (empty($start_datetime)) {
        $error = 'Start date and time is required';
    } elseif (empty($end_datetime)) {
        $error = 'End date and time is required';
    } elseif (strtotime($end_datetime) < strtotime($start_datetime)) {
        $error = 'End date must be after start date';
    } else {
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/events/';

            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Validate file type
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($file_ext, $allowed_extensions)) {
                $error = 'Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.';
            } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) { // 5MB max
                $error = 'File size too large. Maximum 5MB allowed.';
            } else {
                // Delete old image if exists
                if (!empty($event['image']) && file_exists($upload_dir . $event['image'])) {
                    unlink($upload_dir . $event['image']);
                }

                // Generate unique filename
                $new_file_name = 'event_' . time() . '_' . uniqid() . '.' . $file_ext;
                $destination = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $destination)) {
                    $image_url = $new_file_name;
                } else {
                    $error = 'Failed to upload image';
                }
            }
        }

        // If no validation errors, update database
        if (empty($error)) {
            $stmt = $conn->prepare("UPDATE events SET title = ?, description = ?, location = ?, start_date = ?, end_date = ?, entry_type = ?, entry_fee = ?, status = ?, image = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bind_param("ssssssdssi", $title, $description, $location, $start_datetime, $end_datetime, $entry_type, $entry_fee, $status, $image_url, $event_id);

            if ($stmt->execute()) {
                $success = 'Event updated successfully!';
                // Redirect to events list
                header('Location: index.php?success=' . urlencode($success));
                exit();
            } else {
                $error = 'Failed to update event: ' . $conn->error;
            }

            $stmt->close();
        }
    }
}

// Include header
include 'includes/header.php';
?>

<!-- Include Sidebar -->
<?php include 'includes/sidebar.php'; ?>

<!-- Include Topbar -->
<?php include 'includes/topbar.php'; ?>

<!-- Main Content Start -->
<div class="dashboard-body">

    <!-- Breadcrumb -->
    <div class="breadcrumb mb-24">
        <ul class="flex-align gap-4">
            <li><a href="dashboard.php" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><a href="index.php" class="text-gray-200 fw-normal text-15 hover-text-main-600">Events</a></li>
            <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><span class="text-main-600 fw-normal text-15">Edit Event</span></li>
        </ul>
    </div>

    <!-- Error/Success Messages -->
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ph ph-x-circle me-2"></i><?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ph ph-check-circle me-2"></i><?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="card mb-24">
        <div class="card-body">
            <div class="flex-between flex-wrap gap-8">
                <div>
                    <h4 class="mb-0">Edit Event</h4>
                    <p class="text-gray-600 text-15 mt-4">Update event information</p>
                </div>
                <div>
                    <a href="index.php" class="btn btn-outline-gray rounded-pill py-9">
                        <i class="ph ph-arrow-left me-8"></i>
                        Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Form -->
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <!-- Main Information -->
            <div class="col-lg-8">
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Event Information</h5>
                    </div>
                    <div class="card-body">
                        <!-- Event Title -->
                        <div class="mb-20">
                            <label for="title" class="form-label fw-semibold">Event Title <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required
                                placeholder="e.g., Sunday Service, Youth Conference"
                                value="<?php echo htmlspecialchars($event['title']); ?>">
                        </div>

                        <!-- Event Description -->
                        <div class="mb-20">
                            <label for="description" class="form-label fw-semibold">Event Description</label>
                            <textarea class="form-control" name="description"
                                style="height: 250px;"><?php echo $event['description']; ?></textarea>
                        </div>

                        <!-- Location -->
                        <div class="mb-20">
                            <label for="location" class="form-label fw-semibold">Location <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="location" name="location" required
                                placeholder="e.g., Main Auditorium, Church Hall"
                                value="<?php echo htmlspecialchars($event['location']); ?>">
                        </div>

                        <!-- Date and Time -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="start_datetime" class="form-label fw-semibold">Start Date & Time <span
                                        class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="start_datetime"
                                    name="start_datetime" required
                                    value="<?php echo date('Y-m-d\TH:i', strtotime($event['start_date'])); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="end_datetime" class="form-label fw-semibold">End Date & Time <span
                                        class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime"
                                    required value="<?php echo date('Y-m-d\TH:i', strtotime($event['end_date'])); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Entry Information -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Entry Information</h5>
                    </div>
                    <div class="card-body">
                        <!-- Entry Type -->
                        <div class="mb-20">
                            <label for="entry_type" class="form-label fw-semibold">Entry Type</label>
                            <select class="form-select" id="entry_type" name="entry_type" onchange="toggleEntryFee()">
                                <option value="free" <?php echo $event['entry_type'] == 'free' ? 'selected' : ''; ?>>Free
                                    Entry</option>
                                <option value="paid" <?php echo $event['entry_type'] == 'paid' ? 'selected' : ''; ?>>Paid
                                    Entry</option>
                            </select>
                        </div>

                        <!-- Entry Fee -->
                        <div class="mb-20" id="entry_fee_group"
                            style="display: <?php echo $event['entry_type'] == 'paid' ? 'block' : 'none'; ?>;">
                            <label for="entry_fee" class="form-label fw-semibold">Entry Fee (₦)</label>
                            <input type="number" class="form-control" id="entry_fee" name="entry_fee" min="0"
                                step="0.01" placeholder="0.00" value="<?php echo $event['entry_fee']; ?>">
                        </div>

                        <!-- Status -->
                        <div class="mb-0">
                            <label for="status" class="form-label fw-semibold">Event Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="upcoming" <?php echo $event['status'] == 'upcoming' ? 'selected' : ''; ?>>
                                    Upcoming</option>
                                <option value="ongoing" <?php echo $event['status'] == 'ongoing' ? 'selected' : ''; ?>>
                                    Ongoing</option>
                                <option value="completed" <?php echo $event['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="cancelled" <?php echo $event['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Event Image -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Event Image</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($event['image'])): ?>
                            <div class="mb-16 text-center">
                                <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="Current Event Image"
                                    class="img-fluid rounded-8 mb-8" style="max-height: 200px;">
                                <p class="text-13 text-gray-600">Current Image</p>
                            </div>
                        <?php endif; ?>

                        <div class="mb-20">
                            <label for="image" class="form-label fw-semibold">
                                <?php echo !empty($event['image']) ? 'Replace Image' : 'Upload Image'; ?>
                            </label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-gray-500 mt-8 d-block">Max size: 5MB. Formats: JPG, PNG, GIF,
                                WEBP</small>
                        </div>

                        <div id="image-preview" class="text-center" style="display: none;">
                            <img src="" alt="Preview" class="img-fluid rounded-8 mb-8" style="max-height: 200px;">
                            <p class="text-13 text-gray-600">New Image Preview</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-main w-100 mb-12">
                            <i class="ph ph-check-circle me-8"></i>
                            Update Event
                        </button>
                        <a href="index.php" class="btn btn-outline-gray w-100">
                            <i class="ph ph-x me-8"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<!-- Main Content End -->

<?php
// Custom JavaScript
$custom_js = "
    // Toggle entry fee field
    function toggleEntryFee() {
        const entryType = document.getElementById('entry_type').value;
        const entryFeeGroup = document.getElementById('entry_fee_group');

        if (entryType === 'paid') {
            entryFeeGroup.style.display = 'block';
        } else {
            entryFeeGroup.style.display = 'none';
        }
    }

    // Call on page load
    toggleEntryFee();

    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                const img = preview.querySelector('img');
                img.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Save editor content to hidden field before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (typeof quill !== 'undefined') {
            document.getElementById('description').value = quill.root.innerHTML;
        }
    });
";

// Include footer
include 'includes/footer.php';
?>