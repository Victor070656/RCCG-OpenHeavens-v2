<?php
$current_page = basename($_SERVER['PHP_SELF']);

function isActivePage($page_name, $current_page)
{
    return $current_page === $page_name ? 'text-white' : 'text-white hover:text-gray-200';
}
?>

<!-- Navigation -->
<nav
    class="bg-gradient-to-r from-indigo-900/80 to-indigo-800/80 backdrop-blur-md text-white px-6 py-4 fixed w-full top-0 z-50 shadow-lg">
    <div class="container mx-auto flex items-center justify-between">
        <a href="index.php" class="flex items-center space-x-3">
            <img src="images/oh/logo.png" alt="RCCG Logo" class="h-12 w-auto">
            <div class="flex flex-col">
                <span class="text-white font-bold text-lg leading-tight">RCCG Open Heavens</span>
                <span class="text-gray-300 text-xs">Parish</span>
            </div>
        </a>
        <div class="hidden md:flex space-x-8">
            <a href="index.php" class="<?php echo isActivePage('index.php', $current_page); ?>">Home</a>
            <a href="sermons.php" class="<?php echo isActivePage('sermons.php', $current_page); ?>">Sermon</a>
            <a href="events.php" class="<?php echo isActivePage('events.php', $current_page); ?>">Events</a>
            <a href="giving.php" class="<?php echo isActivePage('giving.php', $current_page); ?>">Giving</a>
            <a href="contact-us.php" class="<?php echo isActivePage('contact-us.php', $current_page); ?>">Contact</a>
        </div>
        <button id="mobile-menu-btn" class="md:hidden text-white">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
        <div class="flex flex-col space-y-3">
            <a href="index.php" class="<?php echo isActivePage('index.php', $current_page); ?>">Home</a>
            <a href="sermons.php" class="<?php echo isActivePage('sermons.php', $current_page); ?>">Sermon</a>
            <a href="events.php" class="<?php echo isActivePage('events.php', $current_page); ?>">Events</a>
            <a href="giving.php" class="<?php echo isActivePage('giving.php', $current_page); ?>">Giving</a>
            <a href="contact-us.php" class="<?php echo isActivePage('contact-us.php', $current_page); ?>">Contact</a>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>