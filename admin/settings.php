<?php
/**
 * Church Settings Page
 * RCCG Open Heavens Parish Admin Panel
 */

// Include configuration files
require_once 'config/db.php';
require_once 'config/auth.php';

// Page configuration
$page_title = "Church Settings";

// Authentication check - require admin or super_admin role
require_role('admin');

$error = '';
$success = '';

// Fetch current settings
$settings_query = "SELECT * FROM church_settings LIMIT 1";
$settings_result = $conn->query($settings_query);

if ($settings_result && $settings_result->num_rows > 0) {
    $settings = $settings_result->fetch_assoc();
} else {
    // Create default settings if none exist
    $conn->query("INSERT INTO church_settings (church_name) VALUES ('RCCG Open Heavens Parish')");
    $settings = [
        'id' => $conn->insert_id,
        'church_name' => 'RCCG Open Heavens Parish',
        'church_address' => '',
        'church_phone' => '',
        'church_email' => '',
        'bank_name' => '',
        'account_name' => '',
        'account_number' => '',
        'facebook_url' => '',
        'twitter_url' => '',
        'instagram_url' => '',
        'youtube_url' => '',
        'logo_url' => '',
        'favicon_url' => ''
    ];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $church_name = sanitize_input($_POST['church_name'] ?? '');
    $church_address = sanitize_input($_POST['church_address'] ?? '');
    $church_phone = sanitize_input($_POST['church_phone'] ?? '');
    $church_email = sanitize_input($_POST['church_email'] ?? '');
    $bank_name = sanitize_input($_POST['bank_name'] ?? '');
    $account_name = sanitize_input($_POST['account_name'] ?? '');
    $account_number = sanitize_input($_POST['account_number'] ?? '');
    $facebook_url = sanitize_input($_POST['facebook_url'] ?? '');
    $twitter_url = sanitize_input($_POST['twitter_url'] ?? '');
    $instagram_url = sanitize_input($_POST['instagram_url'] ?? '');
    $youtube_url = sanitize_input($_POST['youtube_url'] ?? '');
    $logo_url = $settings['logo_url'];
    $favicon_url = $settings['favicon_url'];

    // Validation
    if (empty($church_name)) {
        $error = 'Church name is required';
    } elseif (!empty($church_email) && !filter_var($church_email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address';
    } else {
        // Handle logo upload
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../uploads/settings/';

            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

            if (!in_array($file_ext, $allowed)) {
                $error = 'Invalid logo file type.';
            } elseif ($_FILES['logo']['size'] > 2 * 1024 * 1024) {
                $error = 'Logo file too large. Max 2MB.';
            } else {
                if (!empty($settings['logo_url']) && file_exists('../../' . $settings['logo_url'])) {
                    unlink('../../' . $settings['logo_url']);
                }

                $new_name = 'logo_' . time() . '.' . $file_ext;
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $upload_dir . $new_name)) {
                    $logo_url = '../uploads/settings/' . $new_name;
                }
            }
        }

        // Handle favicon upload
        if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../uploads/settings/';

            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_ext = strtolower(pathinfo($_FILES['favicon']['name'], PATHINFO_EXTENSION));
            $allowed = ['ico', 'png', 'jpg', 'jpeg', 'svg'];

            if (!in_array($file_ext, $allowed)) {
                $error = 'Invalid favicon file type.';
            } elseif ($_FILES['favicon']['size'] > 1 * 1024 * 1024) {
                $error = 'Favicon file too large. Max 1MB.';
            } else {
                if (!empty($settings['favicon_url']) && file_exists('../../' . $settings['favicon_url'])) {
                    unlink('../../' . $settings['favicon_url']);
                }

                $new_name = 'favicon_' . time() . '.' . $file_ext;
                if (move_uploaded_file($_FILES['favicon']['tmp_name'], $upload_dir . $new_name)) {
                    $favicon_url = '../uploads/settings/' . $new_name;
                }
            }
        }

        // Update settings
        if (empty($error)) {
            $stmt = $conn->prepare("UPDATE church_settings SET church_name = ?, church_address = ?, church_phone = ?, church_email = ?, bank_name = ?, account_name = ?, account_number = ?, facebook_url = ?, twitter_url = ?, instagram_url = ?, youtube_url = ?, logo_url = ?, favicon_url = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bind_param("sssssssssssssi", $church_name, $church_address, $church_phone, $church_email, $bank_name, $account_name, $account_number, $facebook_url, $twitter_url, $instagram_url, $youtube_url, $logo_url, $favicon_url, $settings['id']);

            if ($stmt->execute()) {
                $success = 'Settings updated successfully!';
                // Refresh settings
                header('Location: settings.php?success=' . urlencode($success));
                exit();
            } else {
                $error = 'Failed to update settings: ' . $conn->error;
            }
            $stmt->close();
        }
    }
}

// Get success message from URL
if (isset($_GET['success'])) {
    $success = htmlspecialchars($_GET['success']);
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
            <li><span class="text-main-600 fw-normal text-15">Church Settings</span></li>
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
                    <h4 class="mb-0">Church Settings</h4>
                    <p class="text-gray-600 text-15 mt-4">Manage church information, bank details, and branding</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Form -->
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <!-- Main Settings -->
            <div class="col-lg-8">
                <!-- Church Information -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ph ph-church me-8"></i>Church Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-20">
                            <label for="church_name" class="form-label fw-semibold">Church Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="church_name" name="church_name" required
                                   value="<?php echo htmlspecialchars($settings['church_name']); ?>">
                        </div>

                        <div class="mb-20">
                            <label for="church_address" class="form-label fw-semibold">Church Address</label>
                            <textarea class="form-control" id="church_address" name="church_address" rows="3"><?php echo htmlspecialchars($settings['church_address']); ?></textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="church_phone" class="form-label fw-semibold">Church Phone</label>
                                <input type="tel" class="form-control" id="church_phone" name="church_phone"
                                       value="<?php echo htmlspecialchars($settings['church_phone']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="church_email" class="form-label fw-semibold">Church Email</label>
                                <input type="email" class="form-control" id="church_email" name="church_email"
                                       value="<?php echo htmlspecialchars($settings['church_email']); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Account Details -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ph ph-bank me-8"></i>Bank Account Details</h5>
                        <p class="text-13 text-gray-600 mb-0 mt-8">For displaying on giving/donation page</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-20">
                            <label for="bank_name" class="form-label fw-semibold">Bank Name</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name"
                                   placeholder="e.g., First Bank of Nigeria"
                                   value="<?php echo htmlspecialchars($settings['bank_name']); ?>">
                        </div>

                        <div class="mb-20">
                            <label for="account_name" class="form-label fw-semibold">Account Name</label>
                            <input type="text" class="form-control" id="account_name" name="account_name"
                                   placeholder="e.g., RCCG Open Heavens Parish"
                                   value="<?php echo htmlspecialchars($settings['account_name']); ?>">
                        </div>

                        <div class="mb-0">
                            <label for="account_number" class="form-label fw-semibold">Account Number</label>
                            <input type="text" class="form-control" id="account_number" name="account_number"
                                   placeholder="e.g., 0123456789"
                                   value="<?php echo htmlspecialchars($settings['account_number']); ?>">
                        </div>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="ph ph-share-network me-8"></i>Social Media Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-20">
                            <label for="facebook_url" class="form-label fw-semibold">
                                <i class="ph ph-facebook-logo text-primary me-8"></i>Facebook URL
                            </label>
                            <input type="url" class="form-control" id="facebook_url" name="facebook_url"
                                   placeholder="https://facebook.com/yourchurch"
                                   value="<?php echo htmlspecialchars($settings['facebook_url']); ?>">
                        </div>

                        <div class="mb-20">
                            <label for="twitter_url" class="form-label fw-semibold">
                                <i class="ph ph-twitter-logo text-info me-8"></i>Twitter/X URL
                            </label>
                            <input type="url" class="form-control" id="twitter_url" name="twitter_url"
                                   placeholder="https://twitter.com/yourchurch"
                                   value="<?php echo htmlspecialchars($settings['twitter_url']); ?>">
                        </div>

                        <div class="mb-20">
                            <label for="instagram_url" class="form-label fw-semibold">
                                <i class="ph ph-instagram-logo text-danger me-8"></i>Instagram URL
                            </label>
                            <input type="url" class="form-control" id="instagram_url" name="instagram_url"
                                   placeholder="https://instagram.com/yourchurch"
                                   value="<?php echo htmlspecialchars($settings['instagram_url']); ?>">
                        </div>

                        <div class="mb-0">
                            <label for="youtube_url" class="form-label fw-semibold">
                                <i class="ph ph-youtube-logo text-danger me-8"></i>YouTube URL
                            </label>
                            <input type="url" class="form-control" id="youtube_url" name="youtube_url"
                                   placeholder="https://youtube.com/@yourchurch"
                                   value="<?php echo htmlspecialchars($settings['youtube_url']); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Logo & Branding -->
            <div class="col-lg-4">
                <!-- Church Logo -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Church Logo</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($settings['logo_url'])): ?>
                            <div class="mb-16 text-center">
                                <img src="<?php echo htmlspecialchars($settings['logo_url']); ?>" alt="Church Logo"
                                     class="img-fluid rounded-8 mb-8" style="max-height: 150px;">
                                <p class="text-13 text-gray-600">Current Logo</p>
                            </div>
                        <?php endif; ?>

                        <div class="mb-0">
                            <label for="logo" class="form-label fw-semibold">
                                <?php echo !empty($settings['logo_url']) ? 'Replace Logo' : 'Upload Logo'; ?>
                            </label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            <small class="text-gray-500 mt-8 d-block">Max 2MB. Formats: JPG, PNG, SVG</small>
                        </div>
                    </div>
                </div>

                <!-- Favicon -->
                <div class="card mb-24">
                    <div class="card-header">
                        <h5 class="mb-0">Favicon</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($settings['favicon_url'])): ?>
                            <div class="mb-16 text-center">
                                <img src="<?php echo htmlspecialchars($settings['favicon_url']); ?>" alt="Favicon"
                                     class="rounded-8 mb-8" style="max-height: 64px;">
                                <p class="text-13 text-gray-600">Current Favicon</p>
                            </div>
                        <?php endif; ?>

                        <div class="mb-0">
                            <label for="favicon" class="form-label fw-semibold">
                                <?php echo !empty($settings['favicon_url']) ? 'Replace Favicon' : 'Upload Favicon'; ?>
                            </label>
                            <input type="file" class="form-control" id="favicon" name="favicon" accept=".ico,.png,.jpg,.jpeg,.svg">
                            <small class="text-gray-500 mt-8 d-block">Max 1MB. 32x32 or 64x64 recommended</small>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-main w-100">
                            <i class="ph ph-floppy-disk me-8"></i>
                            Save Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<!-- Main Content End -->

<?php
// Include footer
include 'includes/footer.php';
?>
