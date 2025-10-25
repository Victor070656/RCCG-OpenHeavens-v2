<?php
// Include database connection
require_once 'admin/config/db.php';

// Fetch published sermons from database
$query = "SELECT * FROM sermons WHERE status = 'published' ORDER BY sermon_date DESC LIMIT 12";
$sermons_result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sermons & Messages - RCCG Open Heavens Parish</title>
    <meta name="description"
        content="Listen to powerful sermons and messages from RCCG Open Heavens Parish. Be inspired by God's Word.">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Poppins', 'sans-serif']
                    },
                    colors: {
                        primary: '#0d47a1',
                        secondary: '#16a34a',
                        accent: '#f59e0b'
                    }
                }
            }
        };
    </script>

    <style>
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body class="bg-neutral-50">
    <!-- Navigation -->
    <?php include 'includes/nav.php'; ?>

    <!-- Page Header -->
    <section class="relative bg-gradient-to-r from-indigo-900 to-indigo-800 text-white pt-32 pb-20">
        <div class="relative z-10 container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Sermons & Messages</h1>
            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-6">
                Be inspired by powerful teachings from God's Word
            </p>
            <div class="flex items-center justify-center text-white/80">
                <a href="index.php" class="hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right mx-3 text-sm"></i>
                <span class="text-white">Sermons</span>
            </div>
        </div>
    </section>

    <!-- Sermons Grid -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <!-- <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button class="px-6 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-[#0d47a1]/90 transition">
                    All Sermons
                </button>
                <button class="px-6 py-2 bg-neutral-200 text-neutral-700 rounded-lg font-semibold hover:bg-neutral-300 transition">
                    Faith
                </button>
                <button class="px-6 py-2 bg-neutral-200 text-neutral-700 rounded-lg font-semibold hover:bg-neutral-300 transition">
                    Prayer
                </button>
                <button class="px-6 py-2 bg-neutral-200 text-neutral-700 rounded-lg font-semibold hover:bg-neutral-300 transition">
                    Worship
                </button>
                <button class="px-6 py-2 bg-neutral-200 text-neutral-700 rounded-lg font-semibold hover:bg-neutral-300 transition">
                    Family
                </button>
            </div> -->

            <!-- Sermons Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                if ($sermons_result && $sermons_result->num_rows > 0):
                    $default_images = ['images/oh/01.jpg', 'images/oh/02.jpg', 'images/oh/03.jpg', 'images/oh/04.jpg', 'images/oh/05.jpg'];
                    $image_index = 0;
                    while ($sermon = $sermons_result->fetch_assoc()):
                        ?>
                        <!-- Sermon Card -->
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover">
                            <div class="relative">
                                <img src="<?php echo htmlspecialchars("uploads/sermons/" . $sermon['thumbnail'] ?? $default_images[$image_index++ % count($default_images)]); ?>"
                                    alt="Sermon" class="w-full h-56 object-cover">
                                <?php if ($sermon['category']): ?>
                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold"><?php echo htmlspecialchars($sermon['category']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center text-neutral-500 text-sm mb-3">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span><?php echo date('F j, Y', strtotime($sermon['sermon_date'])); ?></span>
                                </div>
                                <h3
                                    class="text-xl font-bold text-neutral-900 mb-3 hover:text-[#0d47a1] transition cursor-pointer">
                                    <?php echo htmlspecialchars($sermon['title']); ?>
                                </h3>
                                <p class="text-neutral-600 mb-4 line-clamp-2">
                                    <?php echo htmlspecialchars($sermon['description']); ?>
                                </p>
                                <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                                    <div class="flex items-center text-neutral-600 text-sm">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        <span><?php echo htmlspecialchars($sermon['pastor']); ?></span>
                                    </div>
                                    <a href="sermon-details.php?id=<?php echo $sermon['id']; ?>"
                                        class="text-[#0d47a1] font-semibold hover:text-[#0d47a1]/80 transition flex items-center">
                                        Listen <i class="fas fa-play ml-2 text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                else:
                    ?>
                    <div class="col-span-full text-center py-12">
                        <p class="text-neutral-600 text-lg">No sermons available at this time. Check back soon!</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <!-- <div class="flex justify-center mt-12">
                <nav class="flex items-center space-x-2">
                    <button
                        class="px-4 py-2 bg-neutral-200 text-neutral-700 rounded-lg hover:bg-neutral-300 transition">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="px-4 py-2 bg-primary text-white rounded-lg font-semibold">1</button>
                    <button
                        class="px-4 py-2 bg-neutral-200 text-neutral-700 rounded-lg hover:bg-neutral-300 transition">2</button>
                    <button
                        class="px-4 py-2 bg-neutral-200 text-neutral-700 rounded-lg hover:bg-neutral-300 transition">3</button>
                    <button
                        class="px-4 py-2 bg-neutral-200 text-neutral-700 rounded-lg hover:bg-neutral-300 transition">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </nav>
            </div> -->
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-[#0d47a1] to-[#001845] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Never Miss a Message</h2>
            <p class="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
                Subscribe to our sermon podcast and get notified when new messages are available
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <input type="email" placeholder="Enter your email"
                    class="px-6 py-3 rounded-lg text-neutral-900 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button
                    class="bg-yellow-400 hover:bg-yellow-500 text-neutral-900 px-8 py-3 rounded-lg font-bold transition">
                    Subscribe
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- AOS Animation JS -->
    <script>
    </script>
</body>

</html>