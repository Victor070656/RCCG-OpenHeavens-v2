<?php
/**
 * Sidebar Navigation
 * RCCG Open Heavens Parish Admin Panel
 */
$current_page = basename($_SERVER['PHP_SELF']);
$base_url = "http://localhost/oh/";
?>

<!-- ============================ Sidebar Start ============================ -->
<aside class="sidebar">
    <!-- Sidebar Close Button -->
    <button type="button"
        class="sidebar-close-btn text-gray-500 hover-text-white hover-bg-main-600 text-md w-24 h-24 border border-gray-100 hover-border-main-600 d-xl-none d-flex flex-center rounded-circle position-absolute">
        <i class="ph ph-x"></i>
    </button>
    <!-- Sidebar Close Button End -->

    <!-- Logo -->
    <a href="index.php"
        class="sidebar__logo text-center p-20 position-sticky inset-block-start-0 bg-white w-100 z-1 pb-10">
        <img src="<?= $base_url ?>images/oh/logo.png" alt="RCCG Open Heavens Parish" style="height: 45px;">
    </a>

    <div class="sidebar-menu-wrapper overflow-y-auto scroll-sm">
        <div class="p-20 pt-10">
            <ul class="sidebar-menu">

                <!-- Dashboard -->
                <li class="sidebar-menu__item <?php echo ($current_page == 'index.php') ? 'activePage' : ''; ?>">
                    <a href="index.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-house"></i></span>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <!-- Events Management -->
                <li
                    class="sidebar-menu__item <?php echo (strpos($current_page, 'event') !== false) ? 'activePage' : ''; ?>">
                    <a href="events.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-calendar-dots"></i></span>
                        <span class="text">Events</span>
                    </a>
                </li>

                <!-- Sermons Management -->
                <li
                    class="sidebar-menu__item <?php echo (strpos($current_page, 'sermon') !== false) ? 'activePage' : ''; ?>">
                    <a href="sermons.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-book-open"></i></span>
                        <span class="text">Sermons</span>
                    </a>
                </li>

                <!-- Members Management -->
                <li
                    class="sidebar-menu__item <?php echo (strpos($current_page, 'member') !== false) ? 'activePage' : ''; ?>">
                    <a href="members.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-users-three"></i></span>
                        <span class="text">Members</span>
                    </a>
                </li>

                <!-- Contact Messages -->
                <li
                    class="sidebar-menu__item <?php echo (strpos($current_page, 'message') !== false || strpos($current_page, 'contact') !== false) ? 'activePage' : ''; ?>">
                    <a href="messages.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-envelope"></i></span>
                        <span class="text">Contact Messages</span>
                    </a>
                </li>

                <!-- Newsletter Subscribers -->
                <!-- <li
                    class="sidebar-menu__item <?php echo (strpos($current_page, 'newsletter') !== false) ? 'activePage' : ''; ?>">
                    <a href="newsletter.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-newspaper"></i></span>
                        <span class="text">Newsletter</span>
                    </a>
                </li> -->

                <!-- Divider -->
                <li class="sidebar-menu__item">
                    <span
                        class="text-gray-300 text-sm px-20 pt-20 fw-semibold border-top border-gray-100 d-block text-uppercase">Settings</span>
                </li>

                <!-- Church Settings -->
                <!-- <li class="sidebar-menu__item <?php echo ($current_page == 'settings.php') ? 'activePage' : ''; ?>">
                    <a href="settings.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-gear"></i></span>
                        <span class="text">Church Settings</span>
                    </a>
                </li> -->



                <!-- Profile -->
                <li class="sidebar-menu__item <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">
                    <a href="profile.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-user-circle"></i></span>
                        <span class="text">My Profile</span>
                    </a>
                </li>

                <!-- Logout -->
                <li class="sidebar-menu__item">
                    <a href="logout.php" class="sidebar-menu__link">
                        <span class="icon"><i class="ph ph-sign-out"></i></span>
                        <span class="text">Logout</span>
                    </a>
                </li>

            </ul>
        </div>

        <!-- Promotional Card -->
        <div class="p-20 pt-80">
            <div class="bg-main-50 p-20 pt-0 rounded-16 text-center mt-74">
                <span
                    class="border border-5 bg-white mx-auto border-primary-50 w-114 h-114 rounded-circle flex-center text-success-600 text-2xl translate-n74">
                    <img src="<?= $base_url ?>images/oh/logo.png" alt="RCCG Open Heavens Parish" style="height: 60px;">
                </span>
                <div class="mt-n74">
                    <h5 class="mb-4 mt-22">RCCG Open Heavens</h5>
                    <p class="text-13">Admin Management System</p>
                </div>
            </div>
        </div>
    </div>

</aside>
<!-- ============================ Sidebar End ============================ -->