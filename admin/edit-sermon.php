<?php
/**
 * Edit Sermon Page
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Edit Sermon";
$include_editor = true; // Include rich text editor

// Authentication check
define('AUTH_REQUIRED', true);

$error = '';
$success = '';

// Get sermon ID
$sermon_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($sermon_id <= 0) {
    header('Location: index.php?error=' . urlencode('Invalid sermon ID'));
    exit();
}

// Fetch sermon data
$stmt = $conn->prepare("SELECT * FROM sermons WHERE id = ?");
$stmt->bind_param("i", $sermon_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: index.php?error=' . urlencode('Sermon not found'));
    exit();
}

$sermon = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $title = sanitize_input($_POST['title'] ?? '');
    $description = $_POST['description'] ?? ''; // Don't sanitize HTML content from editor
    $pastor = sanitize_input($_POST['pastor'] ?? '');
    $sermon_date = sanitize_input($_POST['sermon_date'] ?? '');
    $category = sanitize_input($_POST['category'] ?? '');
    $scripture_reference = sanitize_input($_POST['scripture_reference'] ?? '');
    $video_url = sanitize_input($_POST['video_url'] ?? '');
    $audio_url = sanitize_input($_POST['audio_url'] ?? '');
    $status = sanitize_input($_POST['status'] ?? 'draft');
    $thumbnail_url = $sermon['thumbnail_url']; // Keep existing thumbnail by default

    // Validation
    if (empty($title)) {
        $error = 'Sermon title is required';
    } elseif (empty($pastor)) {
        $error = 'Pastor name is required';
    } elseif (empty($sermon_date)) {
        $error = 'Sermon date is required';
    } else {
        // Handle thumbnail upload
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/sermons/';

            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_name = $_FILES['thumbnail']['name'];
            $file_tmp = $_FILES['thumbnail']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Validate file type
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($file_ext, $allowed_extensions)) {
                $error = 'Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.';
            } elseif ($_FILES['thumbnail']['size'] > 5 * 1024 * 1024) { // 5MB max
                $error = 'File size too large. Maximum 5MB allowed.';
            } else {
                // Delete old thumbnail if exists
                if (!empty($sermon['thumbnail_url']) && file_exists('' . $sermon['thumbnail'])) {
                    unlink($upload_dir . $sermon['thumbnail']);
                }

                // Generate unique filename
                $new_file_name = 'sermon_' . time() . '_' . uniqid() . '.' . $file_ext;
                $destination = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $destination)) {
                    $thumbnail_url = $new_file_name;
                } else {
                    $error = 'Failed to upload thumbnail';
                }
            }
        }

        // If no validation errors, update database
        if (empty($error)) {
            $stmt = $conn->prepare("UPDATE sermons SET title = ?, description = ?, pastor = ?, sermon_date = ?, category = ?, scripture_reference = ?, video_url = ?, audio_url = ?, thumbnail = ?, status = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bind_param("ssssssssssi", $title, $description, $pastor, $sermon_date, $category, $scripture_reference, $video_url, $audio_url, $thumbnail_url, $status, $sermon_id);

            if ($stmt->execute()) {
                $success = 'Sermon updated successfully!';
                // Redirect to sermons list
                header('Location: index.php?success=' . urlencode($success));
                exit();
            } else {
                $error = 'Failed to update sermon: ' . $conn->error;
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
            <li><a href="index.php" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><a href="index.php" class="text-gray-200 fw-normal text-15 hover-text-main-600">Sermons</a></li>
            <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><span class="text-main-600 fw-normal text-15">Edit Sermon</span></li>
        </ul>
    </div>

    <!-- Error/Success Messages -->
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ph ph-x-circle me-2"></i><?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="card mb-24">
        <div class="card-body">
            <div class="flex-between flex-wrap gap-8">
                <div>
                    <h4 class="mb-0">Edit Sermon</h4>
                    <p class="text-gray-600 text-15 mt-4">Update sermon information</p>
                </div>
                <div>
                    <a href="sermons.php" class="btn btn-outline-gray rounded-pill py-9">
                        <i class="ph ph-arrow-left me-8"></i>
                        Back to Sermons
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sermon Form -->
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <!-- Main Information -->
            <div class="col-lg-8">
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Sermon Information</h5>
                    </div>
                    <div class="card-body">
                        <!-- Sermon Title -->
                        <div class="mb-20">
                            <label for="title" class="form-label fw-semibold">Sermon Title <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required
                                placeholder="e.g., Walking in Faith, The Power of Prayer"
                                value="<?php echo htmlspecialchars($sermon['title']); ?>">
                        </div>

                        <!-- Sermon Description -->
                        <div class="mb-20">
                            <label for="description" class="form-label fw-semibold">Sermon Description</label>

                            <textarea name="description" class="form-control" style="height: 250px;">
                                <?php echo $sermon['description']; ?>
                            </textarea>
                        </div>

                        <!-- Pastor Name -->
                        <div class="row g-3 mb-20">
                            <div class="col-md-6">
                                <label for="pastor" class="form-label fw-semibold">Pastor/Speaker <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pastor" name="pastor" required
                                    placeholder="e.g., Pastor John Doe"
                                    value="<?php echo htmlspecialchars($sermon['pastor']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="sermon_date" class="form-label fw-semibold">Sermon Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="sermon_date" name="sermon_date" required
                                    value="<?php echo date('Y-m-d', strtotime($sermon['sermon_date'])); ?>">
                            </div>
                        </div>

                        <!-- Category and Scripture -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-semibold">Category</label>
                                <input type="text" class="form-control" id="category" name="category"
                                    placeholder="e.g., Sunday Service, Midweek, Special"
                                    value="<?php echo htmlspecialchars($sermon['category']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="scripture_reference" class="form-label fw-semibold">Scripture
                                    Reference</label>
                                <input type="text" class="form-control" id="scripture_reference"
                                    name="scripture_reference" placeholder="e.g., John 3:16, Romans 8:28"
                                    value="<?php echo htmlspecialchars($sermon['scripture_reference']); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media URLs -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Media Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-20">
                            <label for="video_url" class="form-label fw-semibold">
                                <i class="ph ph-video-camera text-danger-600 me-8"></i>
                                Video URL
                            </label>
                            <input type="url" class="form-control" id="video_url" name="video_url"
                                placeholder="https://youtube.com/watch?v=..."
                                value="<?php echo htmlspecialchars($sermon['video_url']); ?>">
                            <small class="text-gray-500 mt-4 d-block">YouTube, Vimeo, or direct video link</small>
                        </div>

                        <div class="mb-0">
                            <label for="audio_url" class="form-label fw-semibold">
                                <i class="ph ph-microphone text-success-600 me-8"></i>
                                Audio URL
                            </label>
                            <input type="url" class="form-control" id="audio_url" name="audio_url"
                                placeholder="https://example.com/audio.mp3"
                                value="<?php echo htmlspecialchars($sermon['audio_url']); ?>">
                            <small class="text-gray-500 mt-4 d-block">Direct link to audio file (MP3, M4A, etc.)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Status -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Publishing</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-0">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="draft" <?php echo $sermon['status'] == 'draft' ? 'selected' : ''; ?>>Draft
                                </option>
                                <option value="published" <?php echo $sermon['status'] == 'published' ? 'selected' : ''; ?>>Published</option>
                                <option value="archived" <?php echo $sermon['status'] == 'archived' ? 'selected' : ''; ?>>
                                    Archived</option>
                            </select>
                            <small class="text-gray-500 mt-4 d-block">Only published sermons appear on the
                                website</small>
                        </div>
                    </div>
                </div>

                <!-- Thumbnail -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Sermon Thumbnail</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($sermon['thumbnail'])): ?>
                            <div class="mb-16 text-center">
                                <img src="<?php echo htmlspecialchars($sermon['thumbnail']); ?>" alt="Current Thumbnail"
                                    class="img-fluid rounded-8 mb-8" style="max-height: 200px;">
                                <p class="text-13 text-gray-600">Current Thumbnail</p>
                            </div>
                        <?php endif; ?>

                        <div class="mb-20">
                            <label for="thumbnail" class="form-label fw-semibold">
                                <?php echo !empty($sermon['thumbnail']) ? 'Replace Thumbnail' : 'Upload Thumbnail'; ?>
                            </label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                            <small class="text-gray-500 mt-8 d-block">Max size: 5MB. Formats: JPG, PNG, GIF,
                                WEBP</small>
                        </div>

                        <div id="image-preview" class="text-center" style="display: none;">
                            <img src="" alt="Preview" class="img-fluid rounded-8 mb-8" style="max-height: 200px;">
                            <p class="text-13 text-gray-600">New Thumbnail Preview</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-main w-100 mb-12">
                            <i class="ph ph-check-circle me-8"></i>
                            Update Sermon
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
    // Image preview
    document.getElementById('thumbnail').addEventListener('change', function(e) {
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