<?php
/**
 * Admin Profile Page
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "My Profile";

// Authentication check
require_auth();

$error = '';
$success = '';

// Get current admin data
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT * FROM admin_users WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $full_name = sanitize_input($_POST['full_name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $username = sanitize_input($_POST['username'] ?? '');

    // Validation
    if (empty($full_name)) {
        $error = 'Full name is required';
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Valid email is required';
    } elseif (empty($username)) {
        $error = 'Username is required';
    } else {
        // Check if email or username already exists for another user
        $stmt = $conn->prepare("SELECT id FROM admin_users WHERE (email = ? OR username = ?) AND id != ?");
        $stmt->bind_param("ssi", $email, $username, $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = 'Email or username already exists';
        } else {
            // Update profile
            $stmt = $conn->prepare("UPDATE admin_users SET full_name = ?, email = ?, username = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bind_param("sssi", $full_name, $email, $username, $admin_id);

            if ($stmt->execute()) {
                $success = 'Profile updated successfully!';
                // Refresh admin data
                $admin['full_name'] = $full_name;
                $admin['email'] = $email;
                $admin['username'] = $username;
            } else {
                $error = 'Failed to update profile';
            }
        }
        $stmt->close();
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($current_password)) {
        $error = 'Current password is required';
    } elseif ($admin['password'] !== $current_password) {
        $error = 'Current password is incorrect';
    } elseif (empty($new_password) || strlen($new_password) < 6) {
        $error = 'New password must be at least 6 characters';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match';
    } else {
        // Update password
        $stmt = $conn->prepare("UPDATE admin_users SET password = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $new_password, $admin_id);

        if ($stmt->execute()) {
            $success = 'Password changed successfully!';
        } else {
            $error = 'Failed to change password';
        }
        $stmt->close();
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
            <li><span class="text-main-600 fw-normal text-15">My Profile</span></li>
        </ul>
    </div>

    <!-- Success/Error Messages -->
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ph ph-check-circle me-2"></i><?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

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
                    <h4 class="mb-0">My Profile</h4>
                    <p class="text-gray-600 text-15 mt-4">Manage your account settings and password</p>
                </div>
                <div>
                    <span class="badge bg-main-50 text-main-600 px-16 py-8 text-13 fw-semibold">
                        <?php echo ucfirst(str_replace('_', ' ', $admin['role'])); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Information -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ph ph-user me-8"></i>Profile Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-20">
                            <label for="full_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required
                                   value="<?php echo htmlspecialchars($admin['full_name']); ?>">
                        </div>

                        <div class="mb-20">
                            <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required
                                   value="<?php echo htmlspecialchars($admin['email']); ?>">
                        </div>

                        <div class="mb-20">
                            <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" required
                                   value="<?php echo htmlspecialchars($admin['username']); ?>">
                        </div>

                        <div class="mb-20">
                            <label class="form-label fw-semibold">Account Status</label>
                            <p class="mb-0">
                                <span class="badge <?php echo $admin['status'] == 'active' ? 'bg-success-50 text-success-600' : 'bg-gray-100 text-gray-600'; ?>">
                                    <?php echo ucfirst($admin['status']); ?>
                                </span>
                            </p>
                        </div>

                        <div class="mb-0">
                            <button type="submit" name="update_profile" class="btn btn-main">
                                <i class="ph ph-check-circle me-8"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ph ph-lock me-8"></i>Change Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-20">
                            <label for="current_password" class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>

                        <div class="mb-20">
                            <label for="new_password" class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                            <small class="text-gray-500 d-block mt-4">Minimum 6 characters</small>
                        </div>

                        <div class="mb-20">
                            <label for="confirm_password" class="form-label fw-semibold">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
                        </div>

                        <div class="mb-0">
                            <button type="submit" name="change_password" class="btn btn-main">
                                <i class="ph ph-key me-8"></i>Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ph ph-info me-8"></i>Account Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <p class="text-13 text-gray-600 mb-4">Account Created</p>
                            <p class="fw-semibold mb-0">
                                <?php echo date('F j, Y g:i A', strtotime($admin['created_at'])); ?>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-13 text-gray-600 mb-4">Last Updated</p>
                            <p class="fw-semibold mb-0">
                                <?php echo date('F j, Y g:i A', strtotime($admin['updated_at'])); ?>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p class="text-13 text-gray-600 mb-4">Last Login</p>
                            <p class="fw-semibold mb-0">
                                <?php echo $admin['last_login'] ? date('F j, Y g:i A', strtotime($admin['last_login'])) : 'Never'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Main Content End -->

<?php
// Include footer
include 'includes/footer.php';
?>
