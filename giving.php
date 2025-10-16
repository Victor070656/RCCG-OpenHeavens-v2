<?php
// Include database connection
require_once 'admin/config/db.php';

// Fetch bank account details from church_settings
$bank_name = 'Access Bank';
$account_name = 'RCCG Open Heavens';
$account_number = '0123456789';

$query = "SELECT setting_key, setting_value FROM church_settings WHERE setting_key IN ('bank_name', 'account_name', 'account_number')";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['setting_key'] == 'bank_name') {
            $bank_name = $row['setting_value'];
        } elseif ($row['setting_key'] == 'account_name') {
            $account_name = $row['setting_value'];
        } elseif ($row['setting_key'] == 'account_number') {
            $account_number = $row['setting_value'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give - RCCG Open Heavens Parish</title>
    <meta name="description"
        content="Support the mission and ministry of RCCG Open Heavens Parish through your generous giving.">

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
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.5) 1px, transparent 0); background-size: 50px 50px;">
            </div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">Give</h1>
            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-6">
                Partner with us to spread the Gospel and impact lives
            </p>
            <div class="flex items-center justify-center text-white/80">
                <a href="index.php" class="hover:text-white transition">Home</a>
                <i class="fas fa-chevron-right mx-3 text-sm"></i>
                <span class="text-yellow-400">Give</span>
            </div>
        </div>
    </section>

    <!-- Bible Verse Section -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-neutral-50 rounded-2xl p-8 md:p-12 border-l-4 border-[#0d47a1]">
                <i class="fas fa-quote-left text-4xl text-[#0d47a1]/20 mb-4"></i>
                <p class="text-2xl md:text-3xl font-serif text-neutral-800 italic mb-6 leading-relaxed">
                    "Each of you should give what you have decided in your heart to give, not reluctantly or under
                    compulsion, for God loves a cheerful giver."
                </p>
                <p class="text-[#0d47a1] font-bold text-lg">2 Corinthians 9:7</p>
            </div>
        </div>
    </section>

    <!-- Why Give Section -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 mb-4">Why We Give</h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    Your generosity helps us fulfill the Great Commission and serve our community
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 card-hover">
                    <div class="bg-blue-100 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-hands-praying text-[#0d47a1] text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Worship & Gratitude</h3>
                    <p class="text-neutral-600 leading-relaxed">
                        Giving is an act of worship that honors God and expresses gratitude for His blessings in our
                        lives.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 card-hover">
                    <div class="bg-secondary/10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-globe-americas text-secondary text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Kingdom Expansion</h3>
                    <p class="text-neutral-600 leading-relaxed">
                        Your giving supports missions, church planting, and spreading the gospel to unreached
                        communities.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 card-hover">
                    <div class="bg-accent/10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-heart text-accent text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-3">Community Impact</h3>
                    <p class="text-neutral-600 leading-relaxed">
                        Funds support outreach programs, feeding the hungry, and meeting needs in our local community.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Giving Options -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 mb-4">Ways to Give</h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    Choose the giving method that works best for you
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 mb-12">
                <!-- Online Giving -->
                <div
                    class="bg-gradient-to-br from-[#0d47a1] to-[#001845] rounded-2xl p-8 md:p-12 text-white card-hover">
                    <div class="flex items-center mb-6">
                        <div class="bg-white/20 w-16 h-16 rounded-2xl flex items-center justify-center mr-4">
                            <i class="fas fa-credit-card text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">Online Giving</h3>
                            <p class="text-white/90">Quick, secure, and convenient</p>
                        </div>
                    </div>
                    <p class="text-white/90 mb-6 leading-relaxed">
                        Give securely online using your credit card, debit card, or bank account. You can set up
                        one-time or recurring donations.
                    </p>
                    <button
                        class="bg-white text-[#0d47a1] hover:bg-neutral-100 px-8 py-4 rounded-xl font-bold text-lg transition w-full">
                        <i class="fas fa-hand-holding-heart mr-2"></i>Give Online Now
                    </button>
                </div>

                <!-- Bank Transfer -->
                <div
                    class="bg-gradient-to-br from-secondary to-green-700 rounded-2xl p-8 md:p-12 text-white card-hover">
                    <div class="flex items-center mb-6">
                        <div class="bg-white/20 w-16 h-16 rounded-2xl flex items-center justify-center mr-4">
                            <i class="fas fa-university text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">Bank Transfer</h3>
                            <p class="text-white/90">Direct bank deposit</p>
                        </div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-6 mb-6 backdrop-blur-sm">
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-white/80">Bank Name:</span>
                                <span class="font-semibold"><?php echo htmlspecialchars($bank_name); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-white/80">Account Name:</span>
                                <span class="font-semibold"><?php echo htmlspecialchars($account_name); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-white/80">Account Number:</span>
                                <span class="font-bold text-lg"><?php echo htmlspecialchars($account_number); ?></span>
                            </div>
                        </div>
                    </div>
                    <button
                        class="bg-white/20 hover:bg-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg transition w-full border border-white/30">
                        <i class="fas fa-copy mr-2"></i>Copy Account Details
                    </button>
                </div>
            </div>

            <!-- Other Methods -->
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-neutral-50 rounded-xl p-6 text-center card-hover">
                    <div class="bg-accent/10 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-accent text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-neutral-900 mb-2">Mobile Money</h4>
                    <p class="text-neutral-600 text-sm mb-3">Use your mobile wallet to give</p>
                    <p class="text-accent font-bold">Coming Soon</p>
                </div>

                <div class="bg-neutral-50 rounded-xl p-6 text-center card-hover">
                    <div class="bg-purple-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-church text-purple-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-neutral-900 mb-2">In-Person</h4>
                    <p class="text-neutral-600 text-sm mb-3">Give during our services</p>
                    <p class="text-purple-600 font-bold">Sundays, Tuesdays & Thursdays</p>
                </div>

                <div class="bg-neutral-50 rounded-xl p-6 text-center card-hover">
                    <div class="bg-blue-100 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-neutral-900 mb-2">Mail</h4>
                    <p class="text-neutral-600 text-sm mb-3">Send checks via postal mail</p>
                    <p class="text-blue-600 font-bold">Available</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Section -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 mb-4">Your Impact</h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    See how your giving is making a difference in lives
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-6 text-center card-hover">
                    <div class="text-4xl font-bold text-[#0d47a1] mb-2">150+</div>
                    <p class="text-neutral-600">Souls Won to Christ</p>
                </div>

                <div class="bg-white rounded-xl p-6 text-center card-hover">
                    <div class="text-4xl font-bold text-secondary mb-2">500+</div>
                    <p class="text-neutral-600">Families Supported</p>
                </div>

                <div class="bg-white rounded-xl p-6 text-center card-hover">
                    <div class="text-4xl font-bold text-accent mb-2">25+</div>
                    <p class="text-neutral-600">Community Programs</p>
                </div>

                <div class="bg-white rounded-xl p-6 text-center card-hover">
                    <div class="text-4xl font-bold text-purple-600 mb-2">10+</div>
                    <p class="text-neutral-600">Mission Projects</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <!-- <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-neutral-900 mb-4">Frequently Asked Questions</h2>
            </div>

            <div class="space-y-4">
                <div class="bg-neutral-50 rounded-xl p-6 card-hover">
                    <h4 class="font-bold text-neutral-900 mb-2 flex items-center">
                        <i class="fas fa-question-circle text-[#0d47a1] mr-3"></i>
                        Is my giving tax-deductible?
                    </h4>
                    <p class="text-neutral-600 pl-9">
                        Yes, RCCG Open Heavens Parish is a registered religious organization. You will receive a receipt for tax purposes.
                    </p>
                </div>

                <div class="bg-neutral-50 rounded-xl p-6 card-hover">
                    <h4 class="font-bold text-neutral-900 mb-2 flex items-center">
                        <i class="fas fa-question-circle text-[#0d47a1] mr-3"></i>
                        Is online giving secure?
                    </h4>
                    <p class="text-neutral-600 pl-9">
                        Absolutely. We use industry-standard encryption and security measures to protect your information.
                    </p>
                </div>

                <div class="bg-neutral-50 rounded-xl p-6 card-hover">
                    <h4 class="font-bold text-neutral-900 mb-2 flex items-center">
                        <i class="fas fa-question-circle text-[#0d47a1] mr-3"></i>
                        Can I set up recurring donations?
                    </h4>
                    <p class="text-neutral-600 pl-9">
                        Yes, you can set up automatic recurring donations on a weekly, monthly, or custom schedule.
                    </p>
                </div>

                <div class="bg-neutral-50 rounded-xl p-6 card-hover">
                    <h4 class="font-bold text-neutral-900 mb-2 flex items-center">
                        <i class="fas fa-question-circle text-[#0d47a1] mr-3"></i>
                        How is my donation used?
                    </h4>
                    <p class="text-neutral-600 pl-9">
                        Your donations support ministry operations, outreach programs, missions, and community services. We maintain financial transparency and accountability.
                    </p>
                </div>
            </div>
        </div>
    </section> -->

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-[#0d47a1] to-[#001845] text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Thank You for Your Generosity</h2>
            <p class="text-lg text-white/90 mb-8">
                Your faithful giving enables us to continue our mission of making disciples and transforming lives
            </p>
            <button
                class="bg-yellow-400 hover:bg-yellow-500 text-neutral-900 px-10 py-4 rounded-xl font-bold text-xl transition shadow-xl">
                <i class="fas fa-hand-holding-heart mr-2"></i>Give Now
            </button>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- AOS Animation JS -->
    <script>
    </script>
</body>

</html>