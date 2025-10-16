<?php
$current_page = basename($_SERVER['PHP_SELF']);

function isActivePage($page_name, $current_page) {
    return $current_page === $page_name ? 'text-white font-bold border-b-2 border-yellow-400 pb-1' : 'text-white/90 hover:text-white font-semibold transition';
}
?>

<!-- Modern Navigation with Glass Effect -->
<nav class="fixed top-0 w-full z-50 glass-effect shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo and Title -->
            <div class="flex items-center space-x-3">
                <a href="index.php" class="flex items-center space-x-3">
                    <img src="images/oh/logo.png" alt="RCCG Open Heavens Parish" class="h-14 w-auto">
                    <div>
                        <h1 class="text-xl font-bold text-white">RCCG Open Heavens Parish</h1>
                        <p class="text-xs text-white/80">Where Heaven Touches Earth</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="index.php" class="<?php echo isActivePage('index.php', $current_page); ?>">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="events.php" class="<?php echo isActivePage('events.php', $current_page); ?>">
                    <i class="fas fa-calendar mr-2"></i>Events
                </a>
                <a href="sermons.php" class="<?php echo isActivePage('sermons.php', $current_page); ?>">
                    <i class="fas fa-bible mr-2"></i>Sermons
                </a>
                <a href="contact-us.php" class="<?php echo isActivePage('contact-us.php', $current_page); ?>">
                    <i class="fas fa-envelope mr-2"></i>Contact
                </a>
                <a href="giving.php"
                   class="bg-yellow-500 hover:bg-yellow-600 text-neutral-900 px-6 py-2.5 rounded-lg font-bold transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-hand-holding-heart mr-2"></i>Give
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="lg:hidden text-white hover:text-yellow-400 transition">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-gradient-to-br from-[#0d47a1] to-[#001845] border-t border-white/20">
        <div class="px-4 py-4 space-y-3">
            <a href="index.php" class="block <?php echo isActivePage('index.php', $current_page); ?> py-2">
                <i class="fas fa-home mr-2"></i>Home
            </a>
            <a href="events.php" class="block <?php echo isActivePage('events.php', $current_page); ?> py-2">
                <i class="fas fa-calendar mr-2"></i>Events
            </a>
            <a href="sermons.php" class="block <?php echo isActivePage('sermons.php', $current_page); ?> py-2">
                <i class="fas fa-bible mr-2"></i>Sermons
            </a>
            <a href="contact-us.php" class="block <?php echo isActivePage('contact-us.php', $current_page); ?> py-2">
                <i class="fas fa-envelope mr-2"></i>Contact
            </a>
            <a href="giving.php"
               class="block bg-yellow-500 hover:bg-yellow-600 text-neutral-900 px-6 py-3 rounded-lg font-bold text-center mt-4">
                <i class="fas fa-hand-holding-heart mr-2"></i>Give
            </a>
        </div>
    </div>
</nav>

<style>
    .glass-effect {
        background: linear-gradient(135deg, rgba(13, 71, 161, 0.95), rgba(0, 24, 69, 0.95));
        backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mobileMenu && !mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    });
</script>
