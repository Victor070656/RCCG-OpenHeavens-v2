<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RCCG Open Heavens Parish - Welcome Home</title>
    <meta name="description" content="Experience the presence of God at RCCG Open Heavens Parish. Join our vibrant community of believers in worship, fellowship, and service.">

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
        .hero-gradient {
            background: linear-gradient(135deg, rgba(13, 71, 161, 0.5) 0%, rgba(0, 24, 69, 0.6) 100%);
        }

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

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center overflow-hidden pt-20">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
            <img src="images/oh/02.jpg" alt="Church Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 hero-gradient"></div>
        </div>

        <!-- Floating Elements -->
        <div class="absolute top-32 left-16 w-16 h-16 bg-white/10 rounded-full animate-bounce" style="animation-duration: 3s;"></div>
        <div class="absolute bottom-32 left-24 w-20 h-20 bg-white/10 rounded-full animate-pulse"></div>

        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center max-w-5xl mx-auto">
                <h5 class="text-xl md:text-2xl text-yellow-400 font-semibold mb-4">
                    Welcome to Our Church
                </h5>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
                    Worship Under <span class="text-yellow-400">Open Heavens</span>
                </h1>
                <p class="text-lg md:text-xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Experience the presence of God through heartfelt worship and powerful teachings that transform lives. Join us this Sunday and encounter heaven on earth.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="contact-us.php" class="group bg-white text-[#0d47a1] px-8 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 flex items-center">
                        <i class="fas fa-church mr-3 group-hover:animate-bounce"></i>
                        Join Us in Worship
                        <i class="fas fa-arrow-right ml-3 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="contact-us.php" class="bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-xl font-bold text-lg border-2 border-white/30 hover:bg-white/20 transition-all duration-300 flex items-center">
                        <i class="fas fa-users mr-3"></i>
                        Get Connected
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center card-hover bg-neutral-50 rounded-2xl p-8">
                    <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-alt text-4xl text-[#0d47a1]"></i>
                    </div>
                    <h3 class="text-5xl font-bold text-[#0d47a1] mb-2">15+</h3>
                    <p class="text-neutral-600 font-semibold text-lg">Years of Ministry</p>
                </div>
                <div class="text-center card-hover bg-neutral-50 rounded-2xl p-8">
                    <div class="bg-secondary/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-4xl text-secondary"></i>
                    </div>
                    <h3 class="text-5xl font-bold text-secondary mb-2">500+</h3>
                    <p class="text-neutral-600 font-semibold text-lg">Active Members</p>
                </div>
                <div class="text-center card-hover bg-neutral-50 rounded-2xl p-8">
                    <div class="bg-accent/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-4xl text-accent"></i>
                    </div>
                    <h3 class="text-5xl font-bold text-accent mb-2">2000+</h3>
                    <p class="text-neutral-600 font-semibold text-lg">Lives Transformed</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Statement -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h4 class="text-[#0d47a1] font-semibold text-lg mb-4">Mission Statement</h4>
                    <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 mb-6">
                        Raising Disciples Under Open Heavens
                    </h2>
                    <p class="text-lg text-neutral-600 leading-relaxed mb-6">
                        To raise disciples of Christ through the Word, Prayer, and Fellowship, preparing believers to live victoriously and fulfill God's purpose under Open Heavens.
                    </p>
                    <p class="text-neutral-600 leading-relaxed mb-6">
                        In the spirit of love, hospitality and social justice, we serve our community. We believe that through faith we become family to one another in Jesus.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-check text-[#0d47a1] text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-neutral-900">Bible-Based Teaching</h4>
                                <p class="text-neutral-600 text-sm">Solid foundation in God's Word</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-check text-secondary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-neutral-900">Powerful Worship</h4>
                                <p class="text-neutral-600 text-sm">Spirit-filled worship experience</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-accent/10 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-check text-accent text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-neutral-900">Strong Community</h4>
                                <p class="text-neutral-600 text-sm">Loving and supportive fellowship</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="images/oh/03.jpg" alt="Church Community" class="rounded-2xl shadow-lg w-full h-64 object-cover">
                        <img src="images/oh/05.jpg" alt="Worship" class="rounded-2xl shadow-lg w-full h-64 object-cover mt-8">
                    </div>
                    <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-gradient-to-br from-[#0d47a1] to-[#0a3d91] rounded-2xl opacity-20 -z-10"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h4 class="text-[#0d47a1] font-semibold text-lg mb-4">Our Services</h4>
                <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 mb-4">
                    Loving God, Helping Others <br class="hidden sm:block">and Serving the World
                </h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    Join us in our mission to spread God's love through various ministries and services
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Service Card 1 -->
                <div class="bg-neutral-50 rounded-2xl p-8 card-hover">
                    <div class="bg-gradient-to-br from-[#0d47a1] to-[#0a3d91] w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Our Community</h3>
                    <p class="text-neutral-600 mb-4">
                        Join a welcoming community of believers dedicated to fellowship, growth, and service.
                    </p>
                    <a href="sermons.php" class="text-[#0d47a1] font-semibold hover:text-[#0d47a1]/80 transition flex items-center">
                        Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
                </div>

                <!-- Service Card 2 -->
                <div class="bg-neutral-50 rounded-2xl p-8 card-hover">
                    <div class="bg-gradient-to-br from-secondary to-green-700 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-handshake text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Outreach Programs</h3>
                    <p class="text-neutral-600 mb-4">
                        Engage in impactful outreach initiatives, bringing Christ's love to our community.
                    </p>
                    <a href="sermons.php" class="text-secondary font-semibold hover:text-secondary/80 transition flex items-center">
                        Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
                </div>

                <!-- Service Card 3 -->
                <div class="bg-neutral-50 rounded-2xl p-8 card-hover">
                    <div class="bg-gradient-to-br from-accent to-yellow-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-calendar text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Weekly Activities</h3>
                    <p class="text-neutral-600 mb-4">
                        Participate in Bible studies, prayer meetings, and fellowship gatherings for spiritual enrichment.
                    </p>
                    <a href="events.php" class="text-accent font-semibold hover:text-accent/80 transition flex items-center">
                        Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
                </div>

                <!-- Service Card 4 -->
                <div class="bg-neutral-50 rounded-2xl p-8 card-hover">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-800 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-bible text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Online Sermons</h3>
                    <p class="text-neutral-600 mb-4">
                        Access our library of sermons and teachings, providing spiritual nourishment wherever you are.
                    </p>
                    <a href="sermons.php" class="text-blue-600 font-semibold hover:text-blue-600/80 transition flex items-center">
                        Learn More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
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
                <!-- Sermon Card 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover">
                    <div class="relative">
                        <img src="images/oh/09.jpg" alt="Sermon" class="w-full h-48 object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-[#0d47a1] text-white px-3 py-1 rounded-full text-sm font-semibold">Faith</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-neutral-500 text-sm mb-3">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>October 13, 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3 hover:text-[#0d47a1] transition cursor-pointer">
                            The Power of Faith in God
                        </h3>
                        <p class="text-neutral-600 mb-4 text-sm line-clamp-2">
                            Discover how faith can move mountains and transform your life through the power of believing in God's promises.
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-user-tie mr-2"></i>
                                <span>Pastor John</span>
                            </div>
                            <a href="sermons.php" class="text-[#0d47a1] font-semibold hover:text-[#0d47a1]/80 transition flex items-center">
                                Listen <i class="fas fa-play ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sermon Card 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover">
                    <div class="relative">
                        <img src="images/oh/10.jpg" alt="Sermon" class="w-full h-48 object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-secondary text-white px-3 py-1 rounded-full text-sm font-semibold">Prayer</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-neutral-500 text-sm mb-3">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>October 10, 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3 hover:text-[#0d47a1] transition cursor-pointer">
                            Effective Prayer Life
                        </h3>
                        <p class="text-neutral-600 mb-4 text-sm line-clamp-2">
                            Learn the secrets of a powerful prayer life and how to communicate effectively with God.
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-user-tie mr-2"></i>
                                <span>Pastor Sarah</span>
                            </div>
                            <a href="sermons.php" class="text-[#0d47a1] font-semibold hover:text-[#0d47a1]/80 transition flex items-center">
                                Listen <i class="fas fa-play ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sermon Card 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm card-hover">
                    <div class="relative">
                        <img src="images/oh/01.jpg" alt="Sermon" class="w-full h-48 object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-accent text-white px-3 py-1 rounded-full text-sm font-semibold">Worship</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-neutral-500 text-sm mb-3">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>October 6, 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3 hover:text-[#0d47a1] transition cursor-pointer">
                            True Worship in Spirit
                        </h3>
                        <p class="text-neutral-600 mb-4 text-sm line-clamp-2">
                            Understanding what it means to worship God in spirit and in truth, beyond just songs.
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-user-tie mr-2"></i>
                                <span>Pastor David</span>
                            </div>
                            <a href="sermons.php" class="text-[#0d47a1] font-semibold hover:text-[#0d47a1]/80 transition flex items-center">
                                Listen <i class="fas fa-play ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="sermons.php" class="inline-flex items-center bg-[#0d47a1] hover:bg-[#0a3d91] text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg">
                    <i class="fas fa-podcast mr-3"></i>
                    View All Sermons
                    <i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
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
                <!-- Event Card 1 -->
                <div class="bg-neutral-50 rounded-2xl overflow-hidden shadow-sm card-hover">
                    <div class="relative">
                        <img src="images/oh/08.jpg" alt="Event" class="w-full h-48 object-cover">
                        <div class="absolute top-4 right-4 bg-white text-[#0d47a1] px-4 py-2 rounded-xl shadow-lg text-center">
                            <div class="text-2xl font-bold">15</div>
                            <div class="text-xs uppercase">Dec</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-white bg-[#0d47a1] px-3 py-1 rounded-full w-fit mb-3">
                            <i class="fas fa-tag mr-2"></i>
                            <span>Worship</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">
                            Annual Revival Service 2024
                        </h3>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-clock text-[#0d47a1] mr-3 w-5"></i>
                                <span>6:00 PM - 9:00 PM</span>
                            </div>
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-map-marker-alt text-[#0d47a1] mr-3 w-5"></i>
                                <span>RCCG Open Heavens Parish</span>
                            </div>
                        </div>
                        <a href="events.php" class="block w-full text-center bg-[#0d47a1] hover:bg-[#0a3d91] text-white py-3 rounded-lg font-semibold transition">
                            View Details
                        </a>
                    </div>
                </div>

                <!-- Event Card 2 -->
                <div class="bg-neutral-50 rounded-2xl overflow-hidden shadow-sm card-hover">
                    <div class="relative">
                        <img src="images/oh/04.jpg" alt="Event" class="w-full h-48 object-cover">
                        <div class="absolute top-4 right-4 bg-white text-[#0d47a1] px-4 py-2 rounded-xl shadow-lg text-center">
                            <div class="text-2xl font-bold">22</div>
                            <div class="text-xs uppercase">Dec</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-white bg-secondary px-3 py-1 rounded-full w-fit mb-3">
                            <i class="fas fa-tag mr-2"></i>
                            <span>Outreach</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">
                            Community Outreach & Food Drive
                        </h3>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-clock text-secondary mr-3 w-5"></i>
                                <span>10:00 AM - 2:00 PM</span>
                            </div>
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-map-marker-alt text-secondary mr-3 w-5"></i>
                                <span>Community Center</span>
                            </div>
                        </div>
                        <a href="events.php" class="block w-full text-center bg-secondary hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                            View Details
                        </a>
                    </div>
                </div>

                <!-- Event Card 3 -->
                <div class="bg-neutral-50 rounded-2xl overflow-hidden shadow-sm card-hover">
                    <div class="relative">
                        <img src="images/oh/07.jpg" alt="Event" class="w-full h-48 object-cover">
                        <div class="absolute top-4 right-4 bg-white text-[#0d47a1] px-4 py-2 rounded-xl shadow-lg text-center">
                            <div class="text-2xl font-bold">25</div>
                            <div class="text-xs uppercase">Dec</div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-white bg-accent px-3 py-1 rounded-full w-fit mb-3">
                            <i class="fas fa-tag mr-2"></i>
                            <span>Youth</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">
                            Youth Conference: Next Generation
                        </h3>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-clock text-accent mr-3 w-5"></i>
                                <span>3:00 PM - 7:00 PM</span>
                            </div>
                            <div class="flex items-center text-neutral-600 text-sm">
                                <i class="fas fa-map-marker-alt text-accent mr-3 w-5"></i>
                                <span>Youth Center</span>
                            </div>
                        </div>
                        <a href="events.php" class="block w-full text-center bg-accent hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold transition">
                            View Details
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="events.php" class="inline-flex items-center bg-[#0d47a1] hover:bg-[#0a3d91] text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg">
                    <i class="fas fa-calendar mr-3"></i>
                    View All Events
                    <i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-br from-[#0d47a1] to-[#001845] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Experience God?</h2>
                <p class="text-xl mb-12 text-white/90 max-w-3xl mx-auto">
                    Join us this Sunday and become part of a community that celebrates Jesus Christ
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="contact-us.php" class="bg-white text-[#0d47a1] hover:bg-neutral-100 px-8 py-4 rounded-xl font-bold text-lg transition shadow-xl inline-flex items-center justify-center">
                        <i class="fas fa-church mr-2"></i>Plan Your Visit
                    </a>
                    <a href="giving.php" class="bg-yellow-400 hover:bg-yellow-500 text-neutral-900 px-8 py-4 rounded-xl font-bold text-lg transition shadow-xl inline-flex items-center justify-center">
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
