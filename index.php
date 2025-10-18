<?php
// Include database connection
require_once 'admin/config/db.php';

// Fetch recent sermons (limit to 3 for home page)
$sermons_query = "SELECT * FROM sermons WHERE status = 'published' ORDER BY sermon_date DESC LIMIT 3";
$sermons_result = $conn->query($sermons_query);

// Fetch upcoming events (limit to 3 for home page)
$events_query = "SELECT * FROM events WHERE status = 'upcoming' ORDER BY start_date ASC LIMIT 3";
$events_result = $conn->query($events_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RCCG Open Heavens Parish - Welcome Home</title>
    <meta name="description"
        content="Experience the presence of God at RCCG Open Heavens Parish. Join our vibrant community of believers in worship, fellowship, and service.">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Smooth transitions */
        * {
            transition: all 0.3s ease;
        }

        /* Card hover effects */
        .card-overlay:hover {
            transform: scale(1.02);
        }

        .card-overlay::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0.1) 100%);
            transition: all 0.3s ease;
        }

        .card-overlay:hover::before {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.5) 50%, rgba(0, 0, 0, 0.2) 100%);
        }

        /* Button animations */
        .btn-hover {
            position: relative;
            overflow: hidden;
        }

        .btn-hover::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-hover:hover::before {
            width: 300px;
            height: 300px;
        }
    </style>
</head>

<body class="bg-white">
    <!-- Navigation -->
    <?php include 'includes/nav.php'; ?>

    <!-- Hero Section -->
    <section
        class="bg-gradient-to-br from-indigo-900 via-indigo-800 to-indigo-900 text-white pt-24 pb-16 px-6 relative overflow-hidden min-h-screen flex items-center">
        <!-- Decorative elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight tracking-tight">
                        Experience God<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-300">Just As You
                            Are</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 max-w-xl leading-relaxed">
                        Join us for a life-changing worship experience where you can encounter God's presence and be
                        transformed.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="contact-us.php"
                            class="btn-hover border-2 border-white px-8 py-4 hover:bg-white hover:text-indigo-900 font-semibold text-center rounded-lg transition-all duration-300 uppercase tracking-wider">
                            GET CONNECTED
                        </a>
                        <a href="https://www.youtube.com/@rccgriversprovince1hq820/streams"
                            class="btn-hover bg-green-600 px-8 py-4 hover:bg-green-700 font-semibold flex items-center justify-center rounded-lg shadow-xl hover:shadow-2xl transition-all duration-300 uppercase tracking-wider">
                            <i class="fas fa-play mr-3"></i> WATCH LIVE
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative">
                        <img src="images/oh/02.jpg" alt="Church Service"
                            class="rounded-2xl shadow-2xl w-full object-cover h-[500px] ring-4 ring-white/10">
                        <div
                            class="absolute -bottom-6 -right-6 w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl -z-10">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-24 px-6 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto max-w-7xl">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <div class="inline-block">
                        <span
                            class="text-sm font-bold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-4 py-2 rounded-full">About
                            Us</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        Where <span class="text-green-600">Jesus Reigns,</span> <span
                            class="text-indigo-900">Rules</span><br>
                        and <span class="text-indigo-900">Resides</span>
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        We are a family of God's people. We want to create a passionate commitment to Christ, His Cause,
                        and His Community. Welcome to RCCG Open Heavens Parish.
                    </p>
                    <div class="pt-4">
                        <a href="contact-us.php"
                            class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 group">
                            Learn More About Us
                            <i
                                class="fas fa-arrow-right ml-2 transform group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="grid grid-cols-3 gap-4">
                        <img src="images/oh/03.jpg" alt="Church member"
                            class="rounded-2xl shadow-lg w-full h-72 object-cover transform hover:scale-105 transition-transform duration-300">
                        <img src="images/oh/05.jpg" alt="Church members"
                            class="rounded-2xl shadow-lg w-full h-72 object-cover transform hover:scale-105 transition-transform duration-300 mt-8">
                        <img src="images/oh/01.jpg" alt="Church member"
                            class="rounded-2xl shadow-lg w-full h-72 object-cover transform hover:scale-105 transition-transform duration-300">
                    </div>
                    <!-- Decorative element -->
                    <div
                        class="absolute -bottom-8 -left-8 w-64 h-64 bg-indigo-100 rounded-full blur-3xl opacity-50 -z-10">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cards Section -->
    <section class="py-24 px-6 bg-gray-50">
        <div class="container mx-auto max-w-7xl">
            <div class="text-center mb-16">
                <span
                    class="text-sm font-bold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-4 py-2 rounded-full inline-block mb-4">Explore</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">Discover Our Ministry</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Events Card -->
                <a href="events.php"
                    class="relative h-96 rounded-2xl overflow-hidden shadow-xl group cursor-pointer card-overlay transform transition-all duration-500">
                    <img src="images/oh/01.jpg" alt="Events"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 z-10"></div>
                    <div class="absolute bottom-10 left-10 text-white z-20">
                        <h3 class="text-5xl font-bold mb-4">Events</h3>
                        <span class="inline-flex items-center text-lg font-semibold group-hover:gap-3 transition-all">
                            All Events <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </a>

                <!-- Giving Card -->
                <a href="giving.php"
                    class="relative h-96 rounded-2xl overflow-hidden shadow-xl group cursor-pointer card-overlay transform transition-all duration-500">
                    <img src="images/oh/04.jpg" alt="Giving"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 z-10"></div>
                    <div class="absolute bottom-10 left-10 text-white z-20">
                        <h3 class="text-5xl font-bold mb-4">Giving</h3>
                        <span class="inline-flex items-center text-lg font-semibold group-hover:gap-3 transition-all">
                            Give Here <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Sermon Card -->
                <a href="sermons.php"
                    class="relative h-96 rounded-2xl overflow-hidden shadow-xl group cursor-pointer card-overlay transform transition-all duration-500">
                    <img src="images/oh/09.jpg" alt="Sermon"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 z-10"></div>
                    <div class="absolute bottom-10 left-10 text-white z-20">
                        <h3 class="text-5xl font-bold mb-4">Sermon</h3>
                        <span class="inline-flex items-center text-lg font-semibold group-hover:gap-3 transition-all">
                            All Messages <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </a>

                <!-- Discover Card -->
                <a href="contact-us.php"
                    class="relative h-96 rounded-2xl overflow-hidden shadow-xl group cursor-pointer card-overlay transform transition-all duration-500">
                    <img src="images/oh/03.jpg" alt="Discover"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 z-10"></div>
                    <div class="absolute bottom-10 left-10 text-white z-20">
                        <h3 class="text-5xl font-bold mb-4">Discover</h3>
                        <span class="inline-flex items-center text-lg font-semibold group-hover:gap-3 transition-all">
                            Learn More <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Xpression Section -->
    <section class="bg-gradient-to-br from-black via-gray-900 to-black text-white py-24 px-6 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-20 right-20 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 left-20 w-96 h-96 bg-pink-500 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto max-w-7xl relative z-10">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <span class="text-sm font-bold text-purple-400 uppercase tracking-wider">The Xpression Church</span>
                    <h2 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">
                        Feel The<br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500">Xpression!</span>
                    </h2>
                    <p class="text-xl text-gray-300 leading-relaxed">
                        We are launching a new kind of Youth ministry. Join the experience and operation in God's
                        Presence.
                    </p>
                    <div class="pt-4">
                        <a href="contact-us.php"
                            class="btn-hover inline-block border-2 border-white px-8 py-4 hover:bg-white hover:text-black font-semibold transition-all duration-300 uppercase tracking-wider rounded-lg">
                            PLAN TO VISIT
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <img src="images/oh/08.jpg" alt="Youth Ministry"
                        class="rounded-2xl shadow-2xl w-full h-[500px] object-cover ring-4 ring-purple-500/20">
                    <div class="absolute inset-0 bg-gradient-to-tr from-purple-500/20 to-transparent rounded-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Prayer Section -->
    <section class="py-24 px-6 bg-gradient-to-b from-white to-green-50 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-40 left-20 w-96 h-96 bg-green-500 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto max-w-7xl relative z-10">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <div class="inline-block">
                        <span
                            class="text-sm font-bold text-green-600 uppercase tracking-wider bg-green-50 px-4 py-2 rounded-full">Prayer
                            Request</span>
                    </div>
                    <h2 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">
                        Let us <span class="text-green-600">Pray</span><br>
                        <span class="text-gray-900">with you</span>
                    </h2>
                    <p class="text-xl text-gray-600 leading-relaxed">
                        If you need someone to pray with you concerning specific needs, please write and send us your
                        prayer request(s). We will be glad to pray with you and pray for you.
                    </p>
                    <div class="pt-4">
                        <a href="contact-us.php"
                            class="btn-hover inline-block bg-indigo-900 text-white px-8 py-4 hover:bg-indigo-800 font-semibold transition-all duration-300 uppercase tracking-wider rounded-lg shadow-xl hover:shadow-2xl">
                            REQUEST PRAYER
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <img src="images/oh/10.jpg" alt="Person Praying"
                        class="rounded-2xl shadow-2xl w-full h-[500px] object-cover ring-4 ring-green-500/10">
                    <div
                        class="absolute -bottom-8 -right-8 w-full h-full bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl -z-10 opacity-20">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Sermons Section -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h4 class="text-[#0d47a1] font-semibold text-lg mb-4">Latest Messages</h4>
                <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 mb-4">
                    Recent Sermons
                </h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    Be inspired by God's Word through our recent teachings and messages
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <?php
                if ($sermons_result && $sermons_result->num_rows > 0):
                    $default_images = ['images/oh/09.jpg', 'images/oh/10.jpg', 'images/oh/01.jpg'];
                    $image_index = 0;
                    while ($sermon = $sermons_result->fetch_assoc()):
                        $category_colors = [
                            'Faith' => 'bg-[#0d47a1]',
                            'Prayer' => 'bg-secondary',
                            'Worship' => 'bg-accent',
                            'Purpose' => 'bg-purple-600',
                            'Family' => 'bg-green-600',
                        ];
                        $category_color = $category_colors[$sermon['category']] ?? 'bg-[#0d47a1]';
                        ?>
                        <!-- Sermon Card -->
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover">
                            <div class="relative">
                                <img src="<?php echo htmlspecialchars("uploads/sermons/" . $sermon['thumbnail'] ?? $default_images[$image_index++ % count($default_images)]); ?>"
                                    alt="<?php echo htmlspecialchars($sermon['title']); ?>" class="w-full h-48 object-cover">
                                <?php if ($sermon['category']): ?>
                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="<?php echo $category_color; ?> text-white px-3 py-1 rounded-full text-sm font-semibold">
                                            <?php echo htmlspecialchars($sermon['category']); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent">
                                </div>
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
                                <p class="text-neutral-600 mb-4 text-sm line-clamp-2">
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

            <?php if ($sermons_result && $sermons_result->num_rows > 0): ?>
                <div class="text-center">
                    <a href="sermons.php"
                        class="inline-flex items-center bg-[#0d47a1] hover:bg-[#0a3d91] text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg">
                        <i class="fas fa-podcast mr-3"></i>
                        View All Sermons
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h4 class="text-[#0d47a1] font-semibold text-lg mb-4">What's Happening</h4>
                <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 mb-4">
                    Upcoming Events
                </h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    Join us for life-changing experiences and fellowship
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <?php
                if ($events_result && $events_result->num_rows > 0):
                    $default_images = ['images/oh/08.jpg', 'images/oh/04.jpg', 'images/oh/07.jpg'];
                    $image_index = 0;
                    while ($event = $events_result->fetch_assoc()):
                        $event_date = new DateTime($event['start_date']);
                        ?>
                        <!-- Event Card -->
                        <div class="bg-neutral-50 rounded-2xl overflow-hidden shadow-sm card-hover">
                            <div class="relative">
                                <img src="<?php echo htmlspecialchars("uploads/events/" . $event['image'] ?? $default_images[$image_index++ % count($default_images)]); ?>"
                                    alt="<?php echo htmlspecialchars($event['title']); ?>" class="w-full h-48 object-cover">
                                <div
                                    class="absolute top-4 right-4 bg-white text-[#0d47a1] px-4 py-2 rounded-xl shadow-lg text-center">
                                    <div class="text-2xl font-bold"><?php echo $event_date->format('d'); ?></div>
                                    <div class="text-xs uppercase"><?php echo $event_date->format('M'); ?></div>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-neutral-900 mb-3">
                                    <?php echo htmlspecialchars($event['title']); ?>
                                </h3>
                                <p class="text-neutral-600 mb-4 text-sm line-clamp-2">
                                    <?php echo htmlspecialchars($event['description']); ?>
                                </p>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-neutral-600 text-sm">
                                        <i class="fas fa-clock text-[#0d47a1] mr-3 w-5"></i>
                                        <span><?php echo date('g:i A', strtotime($event['start_date'])) . ' - ' . date('g:i A', strtotime($event['end_date'])); ?></span>
                                    </div>
                                    <div class="flex items-center text-neutral-600 text-sm">
                                        <i class="fas fa-map-marker-alt text-[#0d47a1] mr-3 w-5"></i>
                                        <span><?php echo htmlspecialchars($event['location']); ?></span>
                                    </div>
                                    <?php if ($event['entry_type'] == 'free'): ?>
                                        <div class="flex items-center text-neutral-600 text-sm">
                                            <i class="fas fa-ticket-alt text-[#0d47a1] mr-3 w-5"></i>
                                            <span>Free Entry</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <a href="event-detail.php?id=<?php echo $event['id']; ?>"
                                    class="block w-full text-center bg-[#0d47a1] hover:bg-[#0a3d91] text-white py-3 rounded-lg font-semibold transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                        <?php
                    endwhile;
                else:
                    ?>
                    <div class="col-span-full text-center py-12">
                        <p class="text-neutral-600 text-lg">No upcoming events at this time. Check back soon!</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($events_result && $events_result->num_rows > 0): ?>
                <div class="text-center">
                    <a href="events.php"
                        class="inline-flex items-center bg-[#0d47a1] hover:bg-[#0a3d91] text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg">
                        <i class="fas fa-calendar mr-3"></i>
                        View All Events
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Call to Action - Hidden for now -->
    <section class="py-20 bg-gradient-to-br from-[#0d47a1] to-[#001845] text-white hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Experience God?</h2>
                <p class="text-xl mb-12 text-white/90 max-w-3xl mx-auto">
                    Join us this Sunday and become part of a community that celebrates Jesus Christ
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="contact-us.php"
                        class="bg-white text-[#0d47a1] hover:bg-neutral-100 px-8 py-4 rounded-xl font-bold text-lg transition shadow-xl inline-flex items-center justify-center">
                        <i class="fas fa-church mr-2"></i>Plan Your Visit
                    </a>
                    <a href="giving.php"
                        class="bg-yellow-400 hover:bg-yellow-500 text-neutral-900 px-8 py-4 rounded-xl font-bold text-lg transition shadow-xl inline-flex items-center justify-center">
                        <i class="fas fa-hand-holding-heart mr-2"></i>Give Now
                    </a>
                </div>
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