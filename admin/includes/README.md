# Admin Panel Includes

This directory contains reusable PHP include files for the RCCG Open Heavens Parish Admin Panel.

## Files Overview

### 1. `header.php`
Common header file with HTML head tags, meta information, CSS links, and authentication check.

**Usage:**
```php
<?php
// At the top of your page
require_once 'config/db.php';
require_once 'config/auth.php';

// Set page configuration
$page_title = "Your Page Title";
$include_datatables = true; // Optional: Include DataTables
$include_editor = true;     // Optional: Include Quill Editor
$include_charts = true;     // Optional: Include Apex Charts
$include_calendar = true;   // Optional: Include Calendar
$include_file_upload = true; // Optional: Include File Upload

// Include header
include 'includes/header.php';
?>
```

### 2. `sidebar.php`
Left sidebar navigation menu with all admin panel sections.

**Features:**
- Automatic active page highlighting
- Role-based menu items (e.g., Admin Users only for super_admin)
- Church branding section at bottom
- Responsive mobile menu

**Usage:**
```php
<?php include 'includes/sidebar.php'; ?>
```

### 3. `topbar.php`
Top navigation bar with search, notifications, and user profile dropdown.

**Features:**
- Global search bar
- Notification bell with unread count
- User profile dropdown with quick links
- Responsive design

**Usage:**
```php
<?php include 'includes/topbar.php'; ?>
```

### 4. `footer.php`
Common footer with copyright information and JavaScript includes.

**Features:**
- Conditional script loading based on header configuration
- Auto-hide alerts after 5 seconds
- Delete confirmation function
- Common JavaScript utilities

**Usage:**
```php
<?php
// Optional: Add custom JavaScript
$custom_js = "
    console.log('Custom JS code here');
";

include 'includes/footer.php';
?>
```

## Complete Page Template

Here's a complete example of using all includes together:

```php
<?php
/**
 * Example Page
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Example Page";
$include_datatables = true; // If you need data tables

// Authentication check (set to false if page doesn't require auth)
define('AUTH_REQUIRED', true);

// Your PHP logic here...
$data = [];

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
            <li><span class="text-main-600 fw-normal text-15">Example Page</span></li>
        </ul>
    </div>

    <!-- Your page content goes here -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Page Title</h5>
        </div>
        <div class="card-body">
            <p>Your content here...</p>
        </div>
    </div>

</div>
<!-- Main Content End -->

<?php
// Optional: Custom JavaScript
$custom_js = "
    // Your custom JS here
    console.log('Page loaded');
";

// Include footer
include 'includes/footer.php';
?>
```

## Important Notes

1. **Authentication**: All pages automatically require authentication unless you set `define('AUTH_REQUIRED', false);` before including header.php

2. **Database Connection**: Make sure to include `config/db.php` and `config/auth.php` at the top of every page.

3. **Active Page Highlighting**: The sidebar automatically highlights the current page based on the filename.

4. **Role-Based Access**: Use `has_role('role_name')` to check user permissions:
   - `editor` - Basic access
   - `admin` - Standard admin access
   - `super_admin` - Full access

5. **Optional Libraries**: Only include libraries you need to reduce page load time:
   - `$include_datatables` - For data tables
   - `$include_editor` - For rich text editing
   - `$include_charts` - For statistics and charts
   - `$include_calendar` - For calendar/date picker
   - `$include_file_upload` - For file uploads

6. **Icons**: Use Phosphor Icons with class `ph ph-icon-name` (e.g., `<i class="ph ph-user"></i>`)

## Common CSS Classes

- Cards: `card`, `card-header`, `card-body`
- Buttons: `btn btn-main`, `btn btn-outline-main`, `btn btn-danger`
- Badges: `badge bg-main-600 text-white`
- Alerts: `alert alert-success`, `alert alert-danger`, `alert alert-warning`
- Forms: `form-control`, `form-label`, `form-select`
- Spacing: `mb-24` (margin-bottom), `p-20` (padding), `gap-8` (gap)
- Flex: `flex-align`, `flex-between`, `flex-center`

## Directory Structure

```
admin/
├── includes/
│   ├── header.php      # HTML head and auth check
│   ├── sidebar.php     # Left navigation menu
│   ├── topbar.php      # Top navigation bar
│   ├── footer.php      # Footer and scripts
│   └── README.md       # This file
├── config/
│   ├── db.php          # Database connection
│   └── auth.php        # Authentication functions
├── dashboard.php       # Main dashboard page
└── ...other pages
```

## Getting Started

1. Copy the complete page template above
2. Update the page title and configuration
3. Add your page-specific PHP logic
4. Add your HTML content in the main content area
5. Add any custom JavaScript before including footer.php

## Support

For questions or issues with the includes, please refer to:
- Main documentation: `/admin/SETUP_INSTRUCTIONS.md`
- TODO list: `/admin/TODO.md`
- Authentication guide: `/admin/config/auth.php`
