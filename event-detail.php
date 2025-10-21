<?php
// Include database connection
require_once 'admin/config/db.php';

// Get event ID from URL
$event_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch event details
$query = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

// If event not found, redirect to events page
if (!$event) {
    header('Location: events.php');
    exit;
}

// Fetch related events (upcoming events, excluding current one)
$related_query = "SELECT * FROM events WHERE id != ? AND status = 'upcoming' ORDER BY start_date ASC LIMIT 3";
$related_stmt = $conn->prepare($related_query);
$related_stmt->bind_param("i", $event_id);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title']); ?> - RCCG Open Heavens Parish</title>
    <meta name="description" content="<?php echo htmlspecialchars(substr($event['description'], 0, 150)); ?>">

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
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.5) 1px, transparent 0); background-size: 50px 50px;">
            </div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center text-white/80 mb-6">
                <a href="index.php" class="hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right mx-3 text-sm"></i>
                <a href="events.php" class="hover:text-white transition">Events</a>
                <i class="fas fa-chevron-right mx-3 text-sm"></i>
                <span class="text-yellow-400">Event Details</span>
            </div>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6 text-center">
                <?php echo htmlspecialchars($event['title']); ?>
            </h1>

            <!-- Status Badge -->
            <div class="flex justify-center mb-4">
                <?php
                $status_colors = [
                    'upcoming' => 'bg-green-500',
                    'ongoing' => 'bg-blue-500',
                    'completed' => 'bg-gray-500',
                    'cancelled' => 'bg-red-500'
                ];
                $status_color = $status_colors[$event['status']] ?? 'bg-gray-500';
                ?>
                <span
                    class="<?php echo $status_color; ?> text-white px-4 py-2 rounded-full text-sm font-bold uppercase">
                    <?php echo htmlspecialchars($event['status']); ?>
                </span>
            </div>
        </div>
    </section>

    <!-- Event Details -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Featured Image -->
                    <?php if ($event['image']): ?>
                        <div class="mb-8 rounded-2xl overflow-hidden shadow-lg">
                            <img src="uploads/events/<?php echo htmlspecialchars($event['image']); ?>"
                                alt="<?php echo htmlspecialchars($event['title']); ?>" class="w-full h-96 object-cover">
                        </div>
                    <?php endif; ?>

                    <!-- Event Description -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-4">About This Event</h2>
                        <div class="prose prose-lg max-w-none">
                            <p class="text-neutral-700 leading-relaxed whitespace-pre-line">
                                <?php echo htmlspecialchars($event['description']); ?>
                            </p>
                        </div>
                    </div>

                    <!-- What to Expect -->
                    <div class="bg-blue-50 rounded-2xl p-8 mb-8">
                        <h3 class="text-xl font-bold text-neutral-900 mb-4 flex items-center">
                            <i class="fas fa-list-check text-primary mr-3"></i>
                            What to Expect
                        </h3>
                        <ul class="space-y-3 text-neutral-700">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-secondary mt-1 mr-3"></i>
                                <span>A warm and welcoming atmosphere</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-secondary mt-1 mr-3"></i>
                                <span>Powerful worship and fellowship</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-secondary mt-1 mr-3"></i>
                                <span>Life-changing ministry</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-secondary mt-1 mr-3"></i>
                                <span>Connect with other believers</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Share Section -->
                    <div class="bg-white border border-neutral-200 rounded-2xl p-6">
                        <h3 class="font-bold text-neutral-900 mb-4">Share This Event</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>"
                                target="_blank"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center">
                                <i class="fab fa-facebook-f mr-2"></i>
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($event['title']); ?>&url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>"
                                target="_blank"
                                class="bg-sky-500 hover:bg-sky-600 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center">
                                <i class="fab fa-twitter mr-2"></i>
                                Twitter
                            </a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($event['title'] . ' - ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>"
                                target="_blank"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center">
                                <i class="fab fa-whatsapp mr-2"></i>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Event Info Card -->
                    <div
                        class="bg-gradient-to-br from-[#0d47a1] to-[#001845] text-white rounded-2xl p-8 mb-6 sticky top-24">
                        <h3 class="text-2xl font-bold mb-6">Event Information</h3>

                        <div class="space-y-4">
                            <!-- Date -->
                            <div class="flex items-start">
                                <div class="bg-white/20 rounded-lg p-3 mr-4">
                                    <i class="fas fa-calendar-alt text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-white/80 text-sm">Date</p>
                                    <p class="font-bold"><?php echo date('F j, Y', strtotime($event['start_date'])); ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Time -->
                            <div class="flex items-start">
                                <div class="bg-white/20 rounded-lg p-3 mr-4">
                                    <i class="fas fa-clock text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-white/80 text-sm">Time</p>
                                    <p class="font-bold">
                                        <?php echo date('g:i A', strtotime($event['start_date'])); ?> -
                                        <?php echo date('g:i A', strtotime($event['end_date'])); ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="flex items-start">
                                <div class="bg-white/20 rounded-lg p-3 mr-4">
                                    <i class="fas fa-map-marker-alt text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-white/80 text-sm">Location</p>
                                    <p class="font-bold"><?php echo htmlspecialchars($event['location']); ?></p>
                                </div>
                            </div>

                            <!-- Entry Type -->
                            <div class="flex items-start">
                                <div class="bg-white/20 rounded-lg p-3 mr-4">
                                    <i class="fas fa-ticket-alt text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-white/80 text-sm">Entry</p>
                                    <p class="font-bold">
                                        <?php
                                        if ($event['entry_type'] == 'free') {
                                            echo 'Free Entry';
                                        } else {
                                            echo '$' . number_format($event['entry_fee'], 2);
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Register Button -->
                        <?php if ($event['status'] == 'upcoming'): ?>
                            <!-- <div class="mt-8">
                            <a href="contact-us.php" class="block w-full bg-yellow-400 hover:bg-yellow-500 text-neutral-900 text-center py-4 rounded-xl font-bold text-lg transition shadow-lg">
                                <i class="fas fa-user-plus mr-2"></i>
                                Register Now
                            </a>
                        </div> -->
                        <?php endif; ?>

                        <!-- Add to Calendar -->
                        <!-- <div class="mt-4">
                            <button class="w-full bg-white/10 hover:bg-white/20 text-white py-3 rounded-xl font-semibold transition border border-white/30 flex items-center justify-center">
                                <i class="fas fa-calendar-plus mr-2"></i>
                                Add to Calendar
                            </button>
                        </div> -->
                    </div>

                    <!-- Contact Card -->
                    <div class="bg-neutral-50 rounded-2xl p-6">
                        <h3 class="font-bold text-neutral-900 mb-4">Need More Information?</h3>
                        <p class="text-neutral-600 mb-4">Have questions about this event? We'd love to hear from you!
                        </p>
                        <a href="contact-us.php"
                            class="block w-full bg-primary hover:bg-primary/90 text-white text-center py-3 rounded-lg font-semibold transition">
                            <i class="fas fa-envelope mr-2"></i>
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Events -->
    <?php if ($related_result->num_rows > 0): ?>
        <section class="py-20 bg-neutral-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-neutral-900 mb-8 text-center">Other Upcoming Events</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <?php
                    $default_images = ['images/oh/01.jpg', 'images/oh/02.jpg', 'images/oh/03.jpg'];
                    $img_index = 0;
                    while ($related = $related_result->fetch_assoc()):
                        $related_date = new DateTime($related['start_date']);
                        ?>
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover">
                            <div class="relative">
                                <img src="<?php echo htmlspecialchars($related['image'] ?? $default_images[$img_index++ % count($default_images)]); ?>"
                                    alt="Event" class="w-full h-48 object-cover">
                                <div
                                    class="absolute top-4 right-4 bg-white text-[#0d47a1] px-4 py-2 rounded-xl shadow-lg text-center">
                                    <div class="text-2xl font-bold"><?php echo $related_date->format('d'); ?></div>
                                    <div class="text-xs"><?php echo strtoupper($related_date->format('M')); ?></div>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-neutral-900 mb-2 hover:text-[#0d47a1] transition">
                                    <a
                                        href="event-detail.php?id=<?php echo $related['id']; ?>"><?php echo htmlspecialchars($related['title']); ?></a>
                                </h3>
                                <p class="text-neutral-600 text-sm mb-4 line-clamp-2">
                                    <?php echo htmlspecialchars($related['description']); ?>
                                </p>
                                <div class="flex items-center text-neutral-600 text-sm mb-3">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span><?php echo date('g:i A', strtotime($related['start_date'])); ?></span>
                                </div>
                                <a href="event-detail.php?id=<?php echo $related['id']; ?>"
                                    class="block w-full text-center bg-primary hover:bg-primary/90 text-white py-2 rounded-lg font-semibold transition">
                                    View Details
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