<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - RCCG Open Heavens Parish</title>
    <meta name="description" content="Get in touch with RCCG Open Heavens Parish. We'd love to hear from you and answer any questions you may have.">

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
            transform: translateY(-4px);
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
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Get In Touch</h1>
            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-6">
                We'd love to hear from you. Reach out to us anytime.
            </p>
            <div class="flex items-center justify-center text-white/80">
                <a href="index.php" class="hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right mx-3 text-sm"></i>
                <span class="text-yellow-400">Contact Us</span>
            </div>
        </div>
    </section>

    <!-- Contact Information Cards -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <!-- Phone -->
                <div class="text-center card-hover bg-neutral-50 rounded-2xl p-8">
                    <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-phone text-3xl text-[#0d47a1]"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Call Us</h3>
                    <p class="text-neutral-600 mb-4">Mon - Fri: 9AM - 5PM</p>
                    <a href="tel:+2348012345678" class="text-[#0d47a1] font-semibold hover:text-[#0d47a1]/80 transition">
                        +234 801 234 5678
                    </a>
                </div>

                <!-- Email -->
                <div class="text-center card-hover bg-neutral-50 rounded-2xl p-8">
                    <div class="bg-secondary/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-envelope text-3xl text-secondary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Email Us</h3>
                    <p class="text-neutral-600 mb-4">We'll respond within 24 hours</p>
                    <a href="mailto:info@rccgopenheavens.org" class="text-secondary font-semibold hover:text-secondary/80 transition">
                        info@rccgopenheavens.org
                    </a>
                </div>

                <!-- Location -->
                <div class="text-center card-hover bg-neutral-50 rounded-2xl p-8">
                    <div class="bg-accent/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marker-alt text-3xl text-accent"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Visit Us</h3>
                    <p class="text-neutral-600 mb-4">Sunday Service: 9AM</p>
                    <p class="text-accent font-semibold">
                        Port Harcourt<br>Rivers State, Nigeria
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-start">
                <!-- Form -->
                <div class="bg-white rounded-2xl shadow-sm p-8 lg:p-12">
                    <h2 class="text-3xl font-bold text-neutral-900 mb-6">Send Us a Message</h2>
                    <form class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-neutral-700 font-semibold mb-2">First Name *</label>
                                <input type="text" required
                                       class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#0d47a1] focus:ring-2 focus:ring-primary/20 transition outline-none"
                                       placeholder="John">
                            </div>
                            <div>
                                <label class="block text-neutral-700 font-semibold mb-2">Last Name *</label>
                                <input type="text" required
                                       class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#0d47a1] focus:ring-2 focus:ring-primary/20 transition outline-none"
                                       placeholder="Doe">
                            </div>
                        </div>

                        <div>
                            <label class="block text-neutral-700 font-semibold mb-2">Email Address *</label>
                            <input type="email" required
                                   class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#0d47a1] focus:ring-2 focus:ring-primary/20 transition outline-none"
                                   placeholder="john.doe@example.com">
                        </div>

                        <div>
                            <label class="block text-neutral-700 font-semibold mb-2">Phone Number</label>
                            <input type="tel"
                                   class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#0d47a1] focus:ring-2 focus:ring-primary/20 transition outline-none"
                                   placeholder="+234 800 000 0000">
                        </div>

                        <div>
                            <label class="block text-neutral-700 font-semibold mb-2">Subject *</label>
                            <select required
                                    class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#0d47a1] focus:ring-2 focus:ring-primary/20 transition outline-none">
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="prayer">Prayer Request</option>
                                <option value="visit">Planning a Visit</option>
                                <option value="partnership">Partnership</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-neutral-700 font-semibold mb-2">Message *</label>
                            <textarea required rows="6"
                                      class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-[#0d47a1] focus:ring-2 focus:ring-primary/20 transition outline-none resize-none"
                                      placeholder="Tell us how we can help you..."></textarea>
                        </div>

                        <button type="submit"
                                class="w-full bg-gradient-to-r from-[#0d47a1] to-[#001845] hover:from-[#001845] hover:to-[#0d47a1] text-white py-4 rounded-lg font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i>Send Message
                        </button>
                    </form>
                </div>

                <!-- Info -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-3xl font-bold text-neutral-900 mb-6">Visit Us This Sunday</h2>
                        <p class="text-lg text-neutral-600 leading-relaxed mb-6">
                            We'd love to meet you in person! Join us for worship this Sunday and experience the warmth of our community.
                        </p>
                    </div>

                    <!-- Service Times -->
                    <div class="bg-white rounded-2xl p-8 shadow-sm">
                        <h3 class="text-xl font-bold text-neutral-900 mb-6 flex items-center">
                            <i class="fas fa-clock text-[#0d47a1] mr-3"></i>
                            Service Times
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-4 border-b border-neutral-100">
                                <div>
                                    <p class="font-semibold text-neutral-900">Sunday Service</p>
                                    <p class="text-sm text-neutral-600">Main Worship Service</p>
                                </div>
                                <p class="text-[#0d47a1] font-bold">9:00 AM</p>
                            </div>
                            <div class="flex justify-between items-center pb-4 border-b border-neutral-100">
                                <div>
                                    <p class="font-semibold text-neutral-900">Midweek Service</p>
                                    <p class="text-sm text-neutral-600">Bible Study & Prayer</p>
                                </div>
                                <p class="text-[#0d47a1] font-bold">6:00 PM</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-neutral-900">Friday Prayer</p>
                                    <p class="text-sm text-neutral-600">Power Hour</p>
                                </div>
                                <p class="text-[#0d47a1] font-bold">7:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm">
                        <div class="aspect-video bg-neutral-200 relative">
                            <img src="images/oh/03.jpg" alt="Church Location" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <a href="#" class="bg-white text-[#0d47a1] px-6 py-3 rounded-lg font-bold hover:bg-neutral-100 transition">
                                    <i class="fas fa-map-marked-alt mr-2"></i>Get Directions
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-gradient-to-br from-[#0d47a1] to-[#001845] rounded-2xl p-8 text-white">
                        <h3 class="text-xl font-bold mb-4">Connect With Us</h3>
                        <p class="text-white/90 mb-6">Follow us on social media to stay updated with our latest news and events</p>
                        <div class="flex gap-4">
                            <a href="#" class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition">
                                <i class="fab fa-youtube text-lg"></i>
                            </a>
                        </div>
                    </div>
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
