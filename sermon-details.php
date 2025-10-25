<?php
// Include database connection
require_once 'admin/config/db.php';

// Get sermon ID from URL
$sermon_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch sermon details
$query = "SELECT * FROM sermons WHERE id = ? AND status = 'published'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $sermon_id);
$stmt->execute();
$result = $stmt->get_result();
$sermon = $result->fetch_assoc();

// If sermon not found, redirect to sermons page
if (!$sermon) {
    header('Location: sermons.php');
    exit;
}

// Increment view count
$update_query = "UPDATE sermons SET views = views + 1 WHERE id = ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param("i", $sermon_id);
$update_stmt->execute();

// Fetch related sermons (same category or recent)
$related_query = "SELECT * FROM sermons WHERE id != ? AND status = 'published' AND (category = ? OR category IS NULL) ORDER BY sermon_date DESC LIMIT 3";
$related_stmt = $conn->prepare($related_query);
$related_stmt->bind_param("is", $sermon_id, $sermon['category']);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($sermon['title']); ?> - RCCG Open Heavens Parish</title>
    <meta name="description" content="<?php echo htmlspecialchars(substr($sermon['description'], 0, 150)); ?>">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
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
    <section class="relative bg-gradient-to-br from-[#0d47a1] to-[#001845] text-white pt-32 pb-20">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.5) 1px, transparent 0); background-size: 50px 50px;"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center text-white/80 mb-6">
                <a href="index.php" class="hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right mx-3 text-sm"></i>
                <a href="sermons.php" class="hover:text-white transition">Sermons</a>
                <i class="fas fa-chevron-right mx-3 text-sm"></i>
                <span class="text-yellow-400">Sermon Details</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 text-center"><?php echo htmlspecialchars($sermon['title']); ?></h1>
            <div class="flex flex-wrap items-center justify-center gap-6 text-white/90">
                <div class="flex items-center">
                    <i class="fas fa-user-tie mr-2"></i>
                    <span><?php echo htmlspecialchars($sermon['pastor']); ?></span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-calendar mr-2"></i>
                    <span><?php echo date('F j, Y', strtotime($sermon['sermon_date'])); ?></span>
                </div>
                <?php if ($sermon['category']): ?>
                <div class="flex items-center">
                    <i class="fas fa-tag mr-2"></i>
                    <span><?php echo htmlspecialchars($sermon['category']); ?></span>
                </div>
                <?php endif; ?>
                <div class="flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    <span><?php echo number_format($sermon['views'] + 1); ?> views</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Sermon Content -->
    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Featured Image -->
            <?php if ($sermon['thumbnail']): ?>
            <div class="mb-8 rounded-2xl overflow-hidden shadow-lg">
                <img src="<?php echo htmlspecialchars("uploads/sermons".$sermon['thumbnail']); ?>" alt="<?php echo htmlspecialchars($sermon['title']); ?>" class="w-full h-96 object-cover">
            </div>
            <?php endif; ?>

            <!-- Scripture Reference -->
            <?php if ($sermon['scripture_reference']): ?>
            <div class="bg-blue-50 border-l-4 border-primary rounded-r-xl p-6 mb-8">
                <div class="flex items-start">
                    <i class="fas fa-bible text-primary text-2xl mr-4 mt-1"></i>
                    <div>
                        <h3 class="font-bold text-neutral-900 mb-2">Scripture Reference</h3>
                        <p class="text-neutral-700 text-lg"><?php echo htmlspecialchars($sermon['scripture_reference']); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Sermon Description -->
            <div class="prose prose-lg max-w-none mb-8">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">About This Message</h2>
                <p class="text-neutral-700 leading-relaxed whitespace-pre-line"><?php echo htmlspecialchars($sermon['description']); ?></p>
            </div>

            <!-- Media Players -->
            <div class="bg-neutral-50 rounded-2xl p-8 mb-8">
                <h2 class="text-2xl font-bold text-neutral-900 mb-6">Listen or Watch</h2>

                <!-- Video Player -->
                <?php if ($sermon['video_url']): ?>
                <div class="mb-6">
                    <h3 class="font-semibold text-neutral-900 mb-3 flex items-center">
                        <i class="fas fa-video text-primary mr-2"></i>
                        Watch Video
                    </h3>
                    <div class="aspect-video bg-neutral-900 rounded-xl overflow-hidden">
                        <?php
                        // Check if YouTube URL
                        if (strpos($sermon['video_url'], 'youtube.com') !== false || strpos($sermon['video_url'], 'youtu.be') !== false) {
                            // Extract YouTube video ID
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $sermon['video_url'], $match);
                            $youtube_id = $match[1] ?? '';
                            if ($youtube_id) {
                                echo '<iframe class="w-full h-full" src="https://www.youtube.com/embed/' . htmlspecialchars($youtube_id) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                            }
                        } else {
                            echo '<video class="w-full h-full" controls><source src="' . htmlspecialchars($sermon['video_url']) . '" type="video/mp4">Your browser does not support the video tag.</video>';
                        }
                        ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Audio Player -->
                <?php if ($sermon['audio_url']): ?>
                <div>
                    <h3 class="font-semibold text-neutral-900 mb-3 flex items-center">
                        <i class="fas fa-headphones text-primary mr-2"></i>
                        Listen to Audio
                    </h3>
                    <audio class="w-full" controls>
                        <source src="<?php echo htmlspecialchars($sermon['audio_url']); ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <a href="<?php echo htmlspecialchars($sermon['audio_url']); ?>" download class="inline-flex items-center text-primary hover:text-primary/80 font-semibold mt-3 transition">
                        <i class="fas fa-download mr-2"></i>
                        Download Audio
                    </a>
                </div>
                <?php endif; ?>

                <?php if (!$sermon['video_url'] && !$sermon['audio_url']): ?>
                <p class="text-neutral-600">Audio and video for this sermon will be available soon.</p>
                <?php endif; ?>
            </div>

            <!-- Share Section -->
            <div class="bg-white border border-neutral-200 rounded-2xl p-6">
                <h3 class="font-bold text-neutral-900 mb-4">Share This Sermon</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center">
                        <i class="fab fa-facebook-f mr-2"></i>
                        Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($sermon['title']); ?>&url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="bg-sky-500 hover:bg-sky-600 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center">
                        <i class="fab fa-twitter mr-2"></i>
                        Twitter
                    </a>
                    <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($sermon['title'] . ' - ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center">
                        <i class="fab fa-whatsapp mr-2"></i>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Sermons -->
    <?php if ($related_result->num_rows > 0): ?>
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-neutral-900 mb-8 text-center">Related Sermons</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php
                $default_images = ['images/oh/01.jpg', 'images/oh/02.jpg', 'images/oh/03.jpg'];
                $img_index = 0;
                while ($related = $related_result->fetch_assoc()):
                ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover">
                    <div class="relative">
                        <img src="<?php echo htmlspecialchars($related['thumbnail'] ?? $default_images[$img_index++ % count($default_images)]); ?>" alt="Sermon" class="w-full h-48 object-cover">
                        <?php if ($related['category']): ?>
                        <div class="absolute top-4 left-4">
                            <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold"><?php echo htmlspecialchars($related['category']); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-neutral-500 text-sm mb-2">
                            <i class="fas fa-calendar mr-2"></i>
                            <span><?php echo date('F j, Y', strtotime($related['sermon_date'])); ?></span>
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900 mb-2 hover:text-[#0d47a1] transition">
                            <a href="sermon-details.php?id=<?php echo $related['id']; ?>"><?php echo htmlspecialchars($related['title']); ?></a>
                        </h3>
                        <p class="text-neutral-600 text-sm mb-4 line-clamp-2"><?php echo htmlspecialchars($related['description']); ?></p>
                        <a href="sermon-details.php?id=<?php echo $related['id']; ?>" class="text-primary font-semibold hover:text-primary/80 transition flex items-center">
                            Listen <i class="fas fa-play ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>
