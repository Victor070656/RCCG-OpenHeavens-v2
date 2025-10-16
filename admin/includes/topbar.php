<?php
/**
 * Top Navigation Bar
 * RCCG Open Heavens Parish Admin Panel
 */

// Get current admin user
$current_admin = get_current_admin();

// Get unread messages count (placeholder - will be implemented later)
$unread_messages = 0;
// You can implement this by querying the database
// $result = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE status = 'new'");
// $unread_messages = $result->fetch_assoc()['count'] ?? 0;
?>

<div class="dashboard-main-wrapper">
    <div class="top-navbar flex-between gap-16">

        <div class="flex-align gap-16">
            <!-- Toggle Button Start -->
            <button type="button" class="toggle-btn d-xl-none d-flex text-26 text-gray-500">
                <i class="ph ph-list"></i>
            </button>
            <!-- Toggle Button End -->

            <!-- Search Bar -->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" class="w-350 d-sm-block d-none">
                <div class="position-relative">
                    <button type="submit" class="input-icon text-xl d-flex text-gray-100 pointer-event-none">
                        <i class="ph ph-magnifying-glass"></i>
                    </button>
                    <input type="text" name="search" class="form-control ps-40 h-40 border-transparent focus-border-main-600 bg-main-50 rounded-pill placeholder-15" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </div>
            </form>
        </div>

        <div class="flex-align gap-16">
            <div class="flex-align gap-8">

                <!-- Notification Bell Start -->
                <div class="dropdown">
                    <button class="dropdown-btn shaking-animation text-gray-500 w-40 h-40 bg-main-50 hover-bg-main-100 transition-2 rounded-circle text-xl flex-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="position-relative">
                            <i class="ph ph-bell"></i>
                            <?php if ($unread_messages > 0): ?>
                                <span class="alarm-notify position-absolute end-0"></span>
                            <?php endif; ?>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                        <div class="card border border-gray-100 rounded-12 box-shadow-custom p-0 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="py-8 px-24 bg-main-600">
                                    <div class="flex-between">
                                        <h5 class="text-xl fw-semibold text-white mb-0">Notifications</h5>
                                        <button type="button" class="close-dropdown hover-scale-1 text-xl text-white">
                                            <i class="ph ph-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="p-24 max-h-270 overflow-y-auto scroll-sm">
                                    <?php if ($unread_messages > 0): ?>
                                        <div class="d-flex align-items-start gap-12 mb-20">
                                            <i class="ph ph-envelope text-main-600 text-2xl"></i>
                                            <div class="">
                                                <a href="messages/index.php" class="fw-medium text-15 mb-0 text-gray-300 hover-text-main-600">
                                                    You have <?php echo $unread_messages; ?> new contact message<?php echo $unread_messages > 1 ? 's' : ''; ?>
                                                </a>
                                                <span class="text-gray-200 text-13">Just now</span>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-20">
                                            <i class="ph ph-bell-slash text-gray-300 text-4xl mb-8"></i>
                                            <p class="text-gray-400">No new notifications</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <a href="messages/index.php" class="py-13 px-24 fw-bold text-center d-block text-primary-600 border-top border-gray-100 hover-text-decoration-underline">
                                    View All Messages
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notification Bell End -->

            </div>

            <!-- User Profile Dropdown Start -->
            <div class="dropdown">
                <button class="users arrow-down-icon border border-gray-200 rounded-pill p-4 d-inline-block pe-40 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="position-relative">
                        <img src="assets/images/thumbs/user-img.png" alt="<?php echo htmlspecialchars($current_admin['full_name']); ?>" class="h-32 w-32 rounded-circle">
                        <span class="activation-badge w-8 h-8 position-absolute inset-block-end-0 inset-inline-end-0"></span>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu--lg border-0 bg-transparent p-0">
                    <div class="card border border-gray-100 rounded-12 box-shadow-custom">
                        <div class="card-body">
                            <div class="flex-align gap-8 mb-20 pb-20 border-bottom border-gray-100">
                                <img src="assets/images/thumbs/user-img.png" alt="" class="w-54 h-54 rounded-circle">
                                <div class="">
                                    <h4 class="mb-0"><?php echo htmlspecialchars($current_admin['full_name']); ?></h4>
                                    <p class="fw-medium text-13 text-gray-200"><?php echo htmlspecialchars($current_admin['email']); ?></p>
                                    <span class="badge bg-main-600 text-white text-xs px-8 py-2">
                                        <?php echo ucfirst(str_replace('_', ' ', $current_admin['role'])); ?>
                                    </span>
                                </div>
                            </div>
                            <ul class="max-h-270 overflow-y-auto scroll-sm pe-4">
                                <li class="mb-4">
                                    <a href="profile.php" class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                        <span class="text-2xl text-primary-600 d-flex"><i class="ph ph-user-circle"></i></span>
                                        <span class="text">My Profile</span>
                                    </a>
                                </li>
                                <li class="mb-4">
                                    <a href="settings/index.php" class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                        <span class="text-2xl text-primary-600 d-flex"><i class="ph ph-gear"></i></span>
                                        <span class="text">Church Settings</span>
                                    </a>
                                </li>
                                <li class="mb-4">
                                    <a href="dashboard.php" class="py-12 text-15 px-20 hover-bg-gray-50 text-gray-300 rounded-8 flex-align gap-8 fw-medium text-15">
                                        <span class="text-2xl text-primary-600 d-flex"><i class="ph ph-house"></i></span>
                                        <span class="text">Dashboard</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="pt-20 border-top border-gray-100">
                                <a href="logout.php" class="py-12 text-15 px-20 bg-danger-50 hover-bg-danger-100 text-danger-600 rounded-8 flex-align gap-8 fw-medium text-15">
                                    <span class="text-2xl d-flex"><i class="ph ph-sign-out"></i></span>
                                    <span class="text">Log Out</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- User Profile Dropdown End -->

        </div>
    </div>
