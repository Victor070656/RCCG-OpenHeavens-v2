<!-- Footer -->
<footer class="bg-indigo-950 text-white py-12 px-6">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <!-- Contact Info -->
            <div>
                <h3 class="text-sm font-semibold text-purple-400 mb-4">RCCG OPEN HEAVENS PARISH</h3>
                <p class="text-sm text-gray-300 mb-2">Port Harcourt, Rivers State, Nigeria</p>
                <p class="text-sm text-gray-300">info@rccgopenheavens.org</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-semibold text-purple-400 mb-4">QUICK LINKS</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="sermons.php" class="hover:text-white">Our Work</a></li>
                    <li><a href="contact-us.php" class="hover:text-white">Fellowship</a></li>
                    <li><a href="events.php" class="hover:text-white">Events</a></li>
                    <li><a href="giving.php" class="hover:text-white">Give Online</a></li>
                    <li><a href="contact-us.php" class="hover:text-white">Find Cell</a></li>
                    <li><a href="contact-us.php" class="hover:text-white">Help</a></li>
                </ul>
            </div>

            <!-- Navigation -->
            <div>
                <h3 class="text-sm font-semibold text-purple-400 mb-4">NAVIGATION</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="contact-us.php" class="hover:text-white">New Here</a></li>
                    <li><a href="events.php" class="hover:text-white">Events</a></li>
                    <li><a href="contact-us.php" class="hover:text-white">Prayer Request</a></li>
                    <li><a href="sermons.php" class="hover:text-white">Live</a></li>
                    <li><a href="sermons.php" class="hover:text-white">Sermon</a></li>
                    <li><a href="contact-us.php" class="hover:text-white">Contact Us</a></li>
                </ul>
            </div>

            <!-- Follow Us -->
            <div>
                <h3 class="text-sm font-semibold text-purple-400 mb-4">FOLLOW US</h3>
                <div class="flex space-x-4">
                    <a href="#"
                        class="w-10 h-10 bg-indigo-900 rounded-full flex items-center justify-center hover:bg-indigo-800">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 bg-indigo-900 rounded-full flex items-center justify-center hover:bg-indigo-800">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-indigo-900 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <p class="text-sm text-gray-400 mb-4 md:mb-0">&copy; <?php echo date('Y'); ?> RCCG Open Heavens Parish.
                    All rights reserved.</p>
                <div class="flex items-center space-x-2">
                    <img src="images/oh/logo.png" alt="RCCG Logo" class="h-10 w-auto">
                </div>
            </div>
            <div class="text-center pt-4 border-t border-indigo-900">
                <p class="text-xs text-gray-400">
                    Designed & Developed by <a href="https://royalsolutions.com.ng" target="_blank"
                        rel="noopener noreferrer"
                        class="text-purple-400 hover:text-purple-300 font-semibold transition-colors">Royal Solutions
                        Technologies</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="back-to-top"
    class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-br from-indigo-900 to-indigo-800 rounded-full flex items-center justify-center text-white shadow-lg hover:shadow-xl transition-all duration-300 opacity-0 invisible hover:scale-110 z-40">
    <i class="fas fa-arrow-up text-sm"></i>
</button>

<script>
    // Back to top button
    document.addEventListener('DOMContentLoaded', function () {
        const backToTopBtn = document.getElementById('back-to-top');

        if (backToTopBtn) {
            window.addEventListener('scroll', function () {
                if (window.scrollY > 300) {
                    backToTopBtn.classList.remove('opacity-0', 'invisible');
                } else {
                    backToTopBtn.classList.add('opacity-0', 'invisible');
                }
            });

            backToTopBtn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
</script>