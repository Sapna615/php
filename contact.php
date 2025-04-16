<?php
session_start();
require_once 'config/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - TravelEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-gradient {
            background: linear-gradient(-45deg, #2c3e50, #2c3e50, #34495e, #2c3e50);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        .glass-effect {
            background: rgba(44, 62, 80, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-icon {
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .form-input {
            background: rgba(44, 62, 80, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            color: white;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            background: rgba(44, 62, 80, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            outline: none;
            box-shadow: 0 0 15px rgba(44, 62, 80, 0.2);
        }

        .submit-btn {
            background: linear-gradient(45deg, #2c3e50, #34495e);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .contact-info-item {
            transition: all 0.3s ease;
        }

        .contact-info-item:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body class="animate-gradient min-h-screen text-white">
    <!-- Navigation -->
    <nav class="glass-effect fixed w-full z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="index.php" class="text-2xl font-bold">TravelEase</a>
                <div class="hidden md:flex space-x-8">
                    <a href="index.php" class="hover:text-gray-300 transition">Home</a>
                    <a href="destinations.php" class="hover:text-gray-300 transition">Destinations</a>
                    <a href="about.php" class="hover:text-gray-300 transition">About</a>
                    <a href="contact.php" class="hover:text-gray-300 transition">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 pt-32 pb-20">
        <h1 class="text-5xl md:text-6xl font-bold text-center mb-8 text-gray-100">
            Contact Us – We're Here to Help!
        </h1>
        
        <!-- Contact Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <div class="glass-effect rounded-xl p-6 text-center contact-info-item">
                <div class="text-4xl mb-4">📍</div>
                <h3 class="text-xl font-semibold mb-2">Address</h3>
                <p>123 Travel Street, Adventure City, World 56789</p>
            </div>
            <div class="glass-effect rounded-xl p-6 text-center contact-info-item">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-xl font-semibold mb-2">Phone</h3>
                <p>+1 (234) 567-8900</p>
            </div>
            <div class="glass-effect rounded-xl p-6 text-center contact-info-item">
                <div class="text-4xl mb-4">📧</div>
                <h3 class="text-xl font-semibold mb-2">Email</h3>
                <p>support@travelhub.com</p>
            </div>
            <div class="glass-effect rounded-xl p-6 text-center contact-info-item">
                <div class="text-4xl mb-4">💬</div>
                <h3 class="text-xl font-semibold mb-2">Live Chat</h3>
                <p>Available 24/7</p>
            </div>
        </div>

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'success'): ?>
            <div class="max-w-3xl mx-auto mb-8">
                <div class="glass-effect rounded-xl p-4 bg-green-100 border border-green-400 text-green-700">
                    <p class="text-center">Thank you! Your message has been sent successfully. We'll get back to you soon.</p>
                </div>
            </div>
            <?php elseif ($_GET['status'] === 'error'): ?>
            <div class="max-w-3xl mx-auto mb-8">
                <div class="glass-effect rounded-xl p-4 bg-red-100 border border-red-400 text-red-700">
                    <p class="text-center">Sorry, there was an error sending your message. Please try again later.</p>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Contact Form -->
        <div class="max-w-3xl mx-auto">
            <div class="glass-effect rounded-xl p-8">
                <h2 class="text-3xl font-bold mb-6 text-center">Send Us a Message</h2>
                <form action="process_contact.php" method="POST" class="space-y-6">
                    <div>
                        <label class="block mb-2">Name</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-3 rounded-lg form-input"
                            placeholder="Your Name">
                    </div>
                    <div>
                        <label class="block mb-2">Email</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-3 rounded-lg form-input"
                            placeholder="your@email.com">
                    </div>
                    <div>
                        <label class="block mb-2">Phone (optional)</label>
                        <input type="tel" name="phone"
                            class="w-full px-4 py-3 rounded-lg form-input"
                            placeholder="Your Phone Number">
                    </div>
                    <div>
                        <label class="block mb-2">Subject</label>
                        <input type="text" name="subject" required
                            class="w-full px-4 py-3 rounded-lg form-input"
                            placeholder="What's this about?">
                    </div>
                    <div>
                        <label class="block mb-2">Message</label>
                        <textarea name="message" required
                            class="w-full px-4 py-3 rounded-lg form-input h-32"
                            placeholder="Your message here..."></textarea>
                    </div>
                    <button type="submit"
                        class="w-full submit-btn text-white font-bold py-3 px-6 rounded-lg hover:opacity-90">
                        Send Message 📤
                    </button>
                </form>
            </div>
        </div>

        <!-- Social Media -->
        <div class="mt-16 text-center">
            <h2 class="text-3xl font-bold mb-8">Follow Us for Travel Updates!</h2>
            <div class="flex justify-center space-x-8">
                <a href="#" class="social-icon text-4xl hover:text-gray-400">📷</a>
                <a href="#" class="social-icon text-4xl hover:text-gray-400">📘</a>
                <a href="#" class="social-icon text-4xl hover:text-gray-400">🐦</a>
            </div>
        </div>
    </div>

    <script>
        // Add parallax effect to contact info items
        document.addEventListener('mousemove', (e) => {
            const items = document.querySelectorAll('.contact-info-item');
            const mouseX = e.clientX / window.innerWidth - 0.5;
            const mouseY = e.clientY / window.innerHeight - 0.5;

            items.forEach(item => {
                const rect = item.getBoundingClientRect();
                const itemX = rect.left + rect.width / 2;
                const itemY = rect.top + rect.height / 2;
                
                const angleX = (itemY - e.clientY) * 0.01;
                const angleY = (itemX - e.clientX) * -0.01;
                
                item.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg)`;
            });
        });
    </script>
</body>
</html>
