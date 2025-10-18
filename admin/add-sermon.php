<?php
/**
 * Add Sermon Page
 * RCCG Open Heavens Parish Admin Panel
 */
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Add New Sermon";
$include_editor = true; // Include rich text editor

// Authentication check
define('AUTH_REQUIRED', true);

$error = '';
$success = '';

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
    $thumbnail_url = '';

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

        // If no validation errors, insert into database
        if (empty($error)) {
            $stmt = $conn->prepare("INSERT INTO sermons (title, description, pastor, sermon_date, category, scripture_reference, video_url, audio_url, thumbnail, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssssssss", $title, $description, $pastor, $sermon_date, $category, $scripture_reference, $video_url, $audio_url, $thumbnail_url, $status);

            if ($stmt->execute()) {
                $success = 'Sermon created successfully!';
                // Redirect to sermons list
                header('Location: sermons.php?success=' . urlencode($success));
                exit();
            } else {
                $error = 'Failed to create sermon: ' . $conn->error;
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
            <li><a href="index.php" class="text-gray-200 fw-normal text-15 hover-text-main-600">Sermons</a></li>
            <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><span class="text-main-600 fw-normal text-15">Add New Sermon</span></li>
        </ul>
    </div>

    <!-- Error Messages -->
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
                    <h4 class="mb-0">Add New Sermon</h4>
                    <p class="text-gray-600 text-15 mt-4">Create a new sermon, message, or teaching</p>
                </div>
                <div>
                    <a href="index.php" class="btn btn-outline-gray rounded-pill py-9">
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
                                value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
                        </div>

                        <!-- Sermon Description -->
                        <div class="mb-20">
                            <label for="description" class="form-label fw-semibold">Sermon Description</label>
                            <div id="editor" style="height: 250px;">
                                <?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?>
                            </div>
                            <input type="hidden" name="description" id="description">
                        </div>

                        <!-- Pastor Name -->
                        <div class="row g-3 mb-20">
                            <div class="col-md-6">
                                <label for="pastor" class="form-label fw-semibold">Pastor/Speaker <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pastor" name="pastor" required
                                    placeholder="e.g., Pastor John Doe"
                                    value="<?php echo isset($_POST['pastor']) ? htmlspecialchars($_POST['pastor']) : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="sermon_date" class="form-label fw-semibold">Sermon Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="sermon_date" name="sermon_date" required
                                    value="<?php echo isset($_POST['sermon_date']) ? $_POST['sermon_date'] : date('Y-m-d'); ?>">
                            </div>
                        </div>

                        <!-- Category and Scripture -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-semibold">Category</label>
                                <input type="text" class="form-control" id="category" name="category"
                                    placeholder="e.g., Sunday Service, Midweek, Special"
                                    value="<?php echo isset($_POST['category']) ? htmlspecialchars($_POST['category']) : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="scripture_reference" class="form-label fw-semibold">Scripture
                                    Reference</label>
                                <input type="text" class="form-control" id="scripture_reference"
                                    name="scripture_reference" placeholder="e.g., John 3:16, Romans 8:28"
                                    value="<?php echo isset($_POST['scripture_reference']) ? htmlspecialchars($_POST['scripture_reference']) : ''; ?>">
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
                                value="<?php echo isset($_POST['video_url']) ? htmlspecialchars($_POST['video_url']) : ''; ?>">
                            <small class="text-gray-500 mt-4 d-block">YouTube, Vimeo, or direct video link</small>
                        </div>

                        <div class="mb-0">
                            <label for="audio_url" class="form-label fw-semibold">
                                <i class="ph ph-microphone text-success-600 me-8"></i>
                                Audio URL
                            </label>
                            <input type="url" class="form-control" id="audio_url" name="audio_url"
                                placeholder="https://example.com/audio.mp3"
                                value="<?php echo isset($_POST['audio_url']) ? htmlspecialchars($_POST['audio_url']) : ''; ?>">
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
                                <option value="draft" <?php echo (isset($_POST['status']) && $_POST['status'] == 'draft') ? 'selected' : 'selected'; ?>>Draft</option>
                                <option value="published" <?php echo (isset($_POST['status']) && $_POST['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
                                <option value="archived" <?php echo (isset($_POST['status']) && $_POST['status'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
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
                        <div class="mb-20">
                            <label for="thumbnail" class="form-label fw-semibold">Upload Thumbnail</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                            <small class="text-gray-500 mt-8 d-block">Max size: 5MB. Formats: JPG, PNG, GIF,
                                WEBP</small>
                        </div>
                        <div id="image-preview" class="text-center" style="display: none;">
                            <img src="" alt="Preview" class="img-fluid rounded-8 mb-8" style="max-height: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-main w-100 mb-12">
                            <i class="ph ph-check-circle me-8"></i>
                            Create Sermon
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