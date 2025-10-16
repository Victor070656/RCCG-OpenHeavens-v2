<?php
// Include database connection
require_once 'admin/config/db.php';

// Fetch upcoming events from database
$query = "SELECT * FROM events WHERE status = 'upcoming' ORDER BY start_date ASC LIMIT 10";
$events_result = $conn->query($query);

// Fetch featured event (first upcoming event)
$featured_query = "SELECT * FROM events WHERE status = 'upcoming' ORDER BY start_date ASC LIMIT 1";
$featured_result = $conn->query($featured_query);
$featured_event = $featured_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - RCCG Open Heavens Parish</title>
    <meta name="description" content="Join us for upcoming events and programs at RCCG Open Heavens Parish. Experience community, worship, and fellowship.">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
    <section class="relative bg-gradient-to-br from-[#0d47a1] to-[#001845] text-white pt-32 pb-20">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.5) 1px, transparent 0); background-size: 50px 50px;"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Upcoming Events</h1>
            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-6">
                Join us for life-changing experiences and fellowship
            </p>
            <div class="flex items-center justify-center text-white/80">
                <a href="index.php" class="hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right mx-3 text-sm"></i>
                <span class="text-yellow-400">Events</span>
            </div>
        </div>
    </section>

    <!-- Featured Event -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if ($featured_event): ?>
            <div class="bg-gradient-to-br from-[#0d47a1] to-[#001845] rounded-3xl overflow-hidden shadow-2xl">
                <div class="grid lg:grid-cols-2 gap-8 items-center">
                    <div class="relative h-96 lg:h-full">
                        <img src="<?php echo htmlspecialchars($featured_event['image'] ?? 'images/oh/01.jpg'); ?>" alt="Featured Event" class="w-full h-full object-cover">
                    </div>
                    <div class="p-8 lg:p-12 text-white">
                        <div class="inline-block bg-yellow-400 text-neutral-900 px-4 py-2 rounded-full text-sm font-bold mb-4">
                            Featured Event
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold mb-4"><?php echo htmlspecialchars($featured_event['title']); ?></h2>
                        <p class="text-white/90 text-lg mb-6 leading-relaxed">
                            <?php echo htmlspecialchars($featured_event['description']); ?>
                        </p>
                        <div class="space-y-3 mb-8">
                            <div class="flex items-center text-lg">
                                <i class="fas fa-calendar-alt w-8 text-yellow-400"></i>
                                <span><?php echo date('F j, Y', strtotime($featured_event['start_date'])); ?></span>
                            </div>
                            <div class="flex items-center text-lg">
                                <i class="fas fa-clock w-8 text-yellow-400"></i>
                                <span><?php echo date('g:i A', strtotime($featured_event['start_date'])) . ' - ' . date('g:i A', strtotime($featured_event['end_date'])); ?></span>
                            </div>
                            <div class="flex items-center text-lg">
                                <i class="fas fa-map-marker-alt w-8 text-yellow-400"></i>
                                <span><?php echo htmlspecialchars($featured_event['location']); ?></span>
                            </div>
                            <?php if ($featured_event['entry_type'] == 'free'): ?>
                            <div class="flex items-center text-lg">
                                <i class="fas fa-ticket-alt w-8 text-yellow-400"></i>
                                <span>Free Entry</span>
                            </div>
                            <?php else: ?>
                            <div class="flex items-center text-lg">
                                <i class="fas fa-ticket-alt w-8 text-yellow-400"></i>
                                <span>Entry Fee: $<?php echo number_format($featured_event['entry_fee'], 2); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <button class="bg-yellow-400 hover:bg-yellow-500 text-neutral-900 px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg">
                            Register Now
                        </button>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="text-center py-12">
                <p class="text-neutral-600 text-lg">No featured events at this time. Check back soon!</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 mb-4">All Upcoming Events</h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    Mark your calendars and join us for these amazing events
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                if ($events_result && $events_result->num_rows > 0):
                    $default_images = ['images/oh/01.jpg', 'images/oh/02.jpg', 'images/oh/03.jpg', 'images/oh/04.jpg', 'images/oh/05.jpg'];
                    $image_index = 0;
                    while ($event = $events_result->fetch_assoc()):
                        $event_date = new DateTime($event['start_date']);
                ?>
                <!-- Event Card -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover">
                    <div class="relative">
                        <img src="<?php echo htmlspecialchars($event['image'] ?? $default_images[$image_index++ % count($default_images)]); ?>" alt="Event" class="w-full h-56 object-cover">
                        <div class="absolute top-4 right-4 bg-white text-[#0d47a1] px-4 py-2 rounded-xl shadow-lg text-center">
                            <div class="text-3xl font-bold"><?php echo $event_date->format('d'); ?></div>
                            <div class="text-sm"><?php echo strtoupper($event_date->format('M')); ?></div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">
                            <?php echo htmlspecialchars($event['title']); ?>
                        </h3>
                        <p class="text-neutral-600 mb-4 text-sm line-clamp-2">
                            <?php echo htmlspecialchars($event['description']); ?>
                        </p>
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-clock text-[#0d47a1] mr-3 w-5"></i>
                                <span><?php echo date('g:i A', strtotime($event['start_date'])) . ' - ' . date('g:i A', strtotime($event['end_date'])); ?></span>
                            </div>
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-map-marker-alt text-[#0d47a1] mr-3 w-5"></i>
                                <span><?php echo htmlspecialchars($event['location']); ?></span>
                            </div>
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-ticket-alt text-[#0d47a1] mr-3 w-5"></i>
                                <span><?php echo $event['entry_type'] == 'free' ? 'Free Entry' : '$' . number_format($event['entry_fee'], 2); ?></span>
                            </div>
                        </div>
                        <a href="event-detail.php?id=<?php echo $event['id']; ?>" class="block w-full text-center bg-primary hover:bg-[#0d47a1]/90 text-white py-3 rounded-lg font-semibold transition">
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
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-[#0d47a1] to-[#001845] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Want to Stay Updated?</h2>
            <p class="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
                Subscribe to our newsletter and never miss an event or update from RCCG Open Heavens Parish
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-lg mx-auto">
                <input type="email" placeholder="Enter your email" class="flex-1 px-6 py-3 rounded-lg text-neutral-900 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button class="bg-yellow-400 hover:bg-yellow-500 text-neutral-900 px-8 py-3 rounded-lg font-bold transition">
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
