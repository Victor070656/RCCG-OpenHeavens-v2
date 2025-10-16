<?php
/**
 * Logout Handler
 * RCCG Open Heavens Parish Admin Panel
 */

require_once 'config/auth.php';

// Logout the user
logout_user();

// Redirect to login page with success message
header('Location: sign-in.php?logout=success');
exit();
?>
