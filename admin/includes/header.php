<?php
/**
 * Header Include File
 * RCCG Open Heavens Parish Admin Panel
 * Common header with meta tags, CSS links, and authentication check
 */

// Ensure authentication is checked
if (!defined('AUTH_REQUIRED') || AUTH_REQUIRED === true) {
    require_auth();
}

// Get current admin user
$current_admin = get_current_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>RCCG Open Heavens Parish Admin</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- DataTables (Optional - include only on pages that need it) -->
    <?php if (isset($include_datatables) && $include_datatables === true): ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <?php endif; ?>

    <!-- File Upload (Optional - include only on pages that need it) -->
    <?php if (isset($include_file_upload) && $include_file_upload === true): ?>
    <link rel="stylesheet" href="assets/css/file-upload.css">
    <?php endif; ?>

    <!-- Editor Quill (Optional - include only on pages that need it) -->
    <?php if (isset($include_editor) && $include_editor === true): ?>
    <link rel="stylesheet" href="assets/css/editor-quill.css">
    <?php endif; ?>

    <!-- Calendar (Optional - include only on pages that need it) -->
    <?php if (isset($include_calendar) && $include_calendar === true): ?>
    <link rel="stylesheet" href="assets/css/calendar.css">
    <link rel="stylesheet" href="assets/css/full-calendar.css">
    <?php endif; ?>

    <!-- Apex Charts (Optional - include only on pages that need it) -->
    <?php if (isset($include_charts) && $include_charts === true): ?>
    <link rel="stylesheet" href="assets/css/apexcharts.css">
    <?php endif; ?>

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/main.css">

    <!-- Custom CSS (Optional - for page-specific styles) -->
    <?php if (isset($custom_css)): ?>
    <style>
        <?php echo $custom_css; ?>
    </style>
    <?php endif; ?>
</head>
<body>

    <!--==================== Preloader Start ====================-->
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Sidebar Overlay ====================-->
    <div class="side-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->
