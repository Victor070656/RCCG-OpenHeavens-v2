<?php
/**
 * Sign In Page
 * RCCG Open Heavens Parish Admin Panel
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/db.php';
require_once 'config/auth.php';


// Redirect if already logged in
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        // Query user from database
        $stmt = $conn->prepare("SELECT * FROM admin_users WHERE (username = ? OR email = ?) AND status = 'active' LIMIT 1");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password (plain text comparison)
            if ($password === $user['password']) {
                // Update last login
                $update_stmt = $conn->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
                $update_stmt->bind_param("i", $user['id']);
                $update_stmt->execute();

                // Log user in
                login_user($user);

                // Redirect to dashboard
                header('Location: index.php');
                exit();
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = 'Invalid username or password';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - RCCG Open Heavens Parish Admin</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <!--==================== Preloader End ====================-->

    <section class="auth d-flex">
        <div class="auth-left bg-main-50 flex-center p-24">
            <img src="assets/images/thumbs/auth-img1.png" alt="RCCG Open Heavens">
        </div>
        <div class="auth-right py-40 px-24 flex-center flex-column">
            <div class="auth-right__inner mx-auto w-100">
                <a href="dashboard.php" class="auth-right__logo">
                    <img src="assets/images/logo/logo.png" alt="RCCG Open Heavens Parish">
                </a>
                <h2 class="mb-8">Welcome Back! 👋</h2>
                <p class="text-gray-600 text-15 mb-32">Please sign in to your admin account</p>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ph ph-x-circle me-2"></i><?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ph ph-check-circle me-2"></i>You have been logged out successfully
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="sign-in.php" method="POST">
                    <div class="mb-24">
                        <label for="username" class="form-label mb-8 h6">Email or Username</label>
                        <div class="position-relative">
                            <input type="text" class="form-control py-11 ps-40" id="username" name="username"
                                placeholder="Type your username" required>
                            <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i
                                    class="ph ph-user"></i></span>
                        </div>
                    </div>
                    <div class="mb-24">
                        <label for="password" class="form-label mb-8 h6">Password</label>
                        <div class="position-relative">
                            <input type="password" class="form-control py-11 ps-40" id="password" name="password"
                                placeholder="Enter Password" required>
                            <span
                                class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y ph ph-eye-slash"
                                id="#password"></span>
                            <span class="position-absolute top-50 translate-middle-y ms-16 text-gray-600 d-flex"><i
                                    class="ph ph-lock"></i></span>
                        </div>
                    </div>
                    <div class="mb-32 flex-between flex-wrap gap-8">
                        <div class="form-check mb-0 flex-shrink-0">
                            <input class="form-check-input flex-shrink-0 rounded-4" type="checkbox" value=""
                                id="remember">
                            <label class="form-check-label text-15 flex-grow-1" for="remember">Remember Me </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-main rounded-pill w-100">Sign In</button>

                    <div class="mt-32 text-center">
                        <p class="text-gray-600 text-13 mb-2">Default Credentials:</p>
                        <p class="text-gray-500 text-12 mb-0">Username: <strong>admin</strong> | Password:
                            <strong>Admin@123</strong>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Jquery js -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap Bundle Js -->
    <script src="assets/js/boostrap.bundle.min.js"></script>
    <!-- Phosphor Js -->
    <script src="assets/js/phosphor-icon.js"></script>
    <!-- main js -->
    <script src="assets/js/main.js"></script>

</body>

</html>