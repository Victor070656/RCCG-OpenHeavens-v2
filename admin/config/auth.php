<?php
/**
 * Authentication and Session Management
 * RCCG Open Heavens Parish Admin Panel
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Get current logged-in admin user
function get_current_admin() {
    if (is_logged_in()) {
        return [
            'id' => $_SESSION['admin_id'] ?? null,
            'username' => $_SESSION['admin_username'] ?? '',
            'email' => $_SESSION['admin_email'] ?? '',
            'full_name' => $_SESSION['admin_full_name'] ?? '',
            'role' => $_SESSION['admin_role'] ?? ''
        ];
    }
    return null;
}

// Login user
function login_user($user_data) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $user_data['id'];
    $_SESSION['admin_username'] = $user_data['username'];
    $_SESSION['admin_email'] = $user_data['email'];
    $_SESSION['admin_full_name'] = $user_data['full_name'];
    $_SESSION['admin_role'] = $user_data['role'];
}

// Logout user
function logout_user() {
    session_unset();
    session_destroy();
}

// Require authentication - redirect to login if not logged in
function require_auth() {
    if (!is_logged_in()) {
        header('Location: sign-in.php');
        exit();
    }
}

// Check user role
function has_role($required_role) {
    $user = get_current_admin();
    if (!$user) return false;

    $roles = ['editor' => 1, 'admin' => 2, 'super_admin' => 3];
    $user_level = $roles[$user['role']] ?? 0;
    $required_level = $roles[$required_role] ?? 0;

    return $user_level >= $required_level;
}

// Require specific role
function require_role($required_role) {
    require_auth();
    if (!has_role($required_role)) {
        header('Location: dashboard.php?error=unauthorized');
        exit();
    }
}
?>
