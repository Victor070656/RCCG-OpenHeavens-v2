<?php
/**
 * Add Member Page
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once '../config/db.php';
require_once '../config/auth.php';

// Page configuration
$page_title = "Add New Member";

// Authentication check
define('AUTH_REQUIRED', true);

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $first_name = sanitize_input($_POST['first_name'] ?? '');
    $last_name = sanitize_input($_POST['last_name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $address = sanitize_input($_POST['address'] ?? '');
    $date_of_birth = sanitize_input($_POST['date_of_birth'] ?? '');
    $gender = sanitize_input($_POST['gender'] ?? '');
    $membership_date = sanitize_input($_POST['membership_date'] ?? '');
    $membership_type = sanitize_input($_POST['membership_type'] ?? 'visitor');
    $department = sanitize_input($_POST['department'] ?? '');
    $status = sanitize_input($_POST['status'] ?? 'active');
    $photo_url = '';

    // Validation
    if (empty($first_name)) {
        $error = 'First name is required';
    } elseif (empty($last_name)) {
        $error = 'Last name is required';
    } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address';
    } else {
        // Handle photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../uploads/members/';

            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_name = $_FILES['photo']['name'];
            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Validate file type
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($file_ext, $allowed_extensions)) {
                $error = 'Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.';
            } elseif ($_FILES['photo']['size'] > 5 * 1024 * 1024) { // 5MB max
                $error = 'File size too large. Maximum 5MB allowed.';
            } else {
                // Generate unique filename
                $new_file_name = 'member_' . time() . '_' . uniqid() . '.' . $file_ext;
                $destination = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $destination)) {
                    $photo_url = '../uploads/members/' . $new_file_name;
                } else {
                    $error = 'Failed to upload photo';
                }
            }
        }

        // If no validation errors, insert into database
        if (empty($error)) {
            $stmt = $conn->prepare("INSERT INTO members (first_name, last_name, email, phone, address, date_of_birth, gender, membership_date, membership_type, department, photo_url, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssssssssss", $first_name, $last_name, $email, $phone, $address, $date_of_birth, $gender, $membership_date, $membership_type, $department, $photo_url, $status);

            if ($stmt->execute()) {
                $success = 'Member added successfully!';
                // Redirect to members list
                header('Location: index.php?success=' . urlencode($success));
                exit();
            } else {
                $error = 'Failed to add member: ' . $conn->error;
            }

            $stmt->close();
        }
    }
}

// Include header
include '../includes/header.php';
?>

<!-- Include Sidebar -->
<?php include '../includes/sidebar.php'; ?>

<!-- Include Topbar -->
<?php include '../includes/topbar.php'; ?>

<!-- Main Content Start -->
<div class="dashboard-body">

    <!-- Breadcrumb -->
    <div class="breadcrumb mb-24">
        <ul class="flex-align gap-4">
            <li><a href="../dashboard.php" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><a href="index.php" class="text-gray-200 fw-normal text-15 hover-text-main-600">Members</a></li>
            <li><span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span></li>
            <li><span class="text-main-600 fw-normal text-15">Add New Member</span></li>
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
                    <h4 class="mb-0">Add New Member</h4>
                    <p class="text-gray-600 text-15 mt-4">Add a new church member to the database</p>
                </div>
                <div>
                    <a href="index.php" class="btn btn-outline-gray rounded-pill py-9">
                        <i class="ph ph-arrow-left me-8"></i>
                        Back to Members
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Form -->
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <!-- Main Information -->
            <div class="col-lg-8">
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <!-- Name -->
                        <div class="row g-3 mb-20">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required
                                       placeholder="John"
                                       value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required
                                       placeholder="Doe"
                                       value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>">
                            </div>
                        </div>

                        <!-- Contact -->
                        <div class="row g-3 mb-20">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="john.doe@example.com"
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                       placeholder="+234 800 000 0000"
                                       value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-20">
                            <label for="address" class="form-label fw-semibold">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"
                                      placeholder="Enter full address"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                        </div>

                        <!-- Personal Details -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                       value="<?php echo isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : ''; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label fw-semibold">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Membership Information -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Membership Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="membership_type" class="form-label fw-semibold">Membership Type</label>
                                <select class="form-select" id="membership_type" name="membership_type">
                                    <option value="visitor" <?php echo (isset($_POST['membership_type']) && $_POST['membership_type'] == 'visitor') ? 'selected' : 'selected'; ?>>Visitor</option>
                                    <option value="associate" <?php echo (isset($_POST['membership_type']) && $_POST['membership_type'] == 'associate') ? 'selected' : ''; ?>>Associate Member</option>
                                    <option value="full_member" <?php echo (isset($_POST['membership_type']) && $_POST['membership_type'] == 'full_member') ? 'selected' : ''; ?>>Full Member</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="membership_date" class="form-label fw-semibold">Membership Date</label>
                                <input type="date" class="form-control" id="membership_date" name="membership_date"
                                       value="<?php echo isset($_POST['membership_date']) ? $_POST['membership_date'] : date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-12">
                                <label for="department" class="form-label fw-semibold">Department/Unit</label>
                                <input type="text" class="form-control" id="department" name="department"
                                       placeholder="e.g., Choir, Ushering, Youth, Children"
                                       value="<?php echo isset($_POST['department']) ? htmlspecialchars($_POST['department']) : ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Status -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-0">
                            <label for="status" class="form-label fw-semibold">Member Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" <?php echo (isset($_POST['status']) && $_POST['status'] == 'active') ? 'selected' : 'selected'; ?>>Active</option>
                                <option value="inactive" <?php echo (isset($_POST['status']) && $_POST['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Photo -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Member Photo</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-20">
                            <label for="photo" class="form-label fw-semibold">Upload Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <small class="text-gray-500 mt-8 d-block">Max size: 5MB. Formats: JPG, PNG, GIF, WEBP</small>
                        </div>
                        <div id="image-preview" class="text-center" style="display: none;">
                            <img src="" alt="Preview" class="img-fluid rounded-circle mb-8" style="max-height: 200px; max-width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-main w-100 mb-12">
                            <i class="ph ph-check-circle me-8"></i>
                            Add Member
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
    document.getElementById('photo').addEventListener('change', function(e) {
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
";

// Include footer
include '../includes/footer.php';
?>
