<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - TravelEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-gradient {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .float {
            animation: float 6s ease-in-out infinite;
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .text-gradient {
            background: linear-gradient(to right, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            pointer-events: none;
            transform-origin: center;
        }
    </style>
</head>
<body class="animate-gradient min-h-screen text-white overflow-x-hidden">
    <!-- Particles Container -->
    <div id="particles" class="fixed inset-0 pointer-events-none"></div>

    <!-- Navigation -->
    <nav class="glass-effect fixed w-full z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="index.php" class="text-2xl font-bold text-white">TravelEase</a>
                <div class="hidden md:flex space-x-8">
                    <a href="index.php" class="hover:text-gray-300 transition">Home</a>
                    <a href="destinations.php" class="hover:text-gray-300 transition">Destinations</a>
                    <a href="about.php" class="hover:text-gray-300 transition">About</a>
                    <a href="login.php" class="hover:text-gray-300 transition">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container mx-auto px-6 pt-32 pb-20">
        <div class="text-center">
            <h1 class="text-5xl md:text-7xl font-bold mb-8 text-gradient float">
                Explore the World with Us!
            </h1>
            <p class="text-xl md:text-2xl mb-12 max-w-3xl mx-auto">
                Your Journey, Your Story, Your Adventure!
            </p>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mx-auto px-6 py-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="glass-effect rounded-xl p-8 card-hover">
                <div class="text-4xl mb-6">🔹</div>
                <h3 class="text-2xl font-bold mb-4">Handpicked Destinations</h3>
                <p>Explore the best places across the globe, carefully selected for unforgettable experiences.</p>
            </div>
            <div class="glass-effect rounded-xl p-8 card-hover">
                <div class="text-4xl mb-6">💎</div>
                <h3 class="text-2xl font-bold mb-4">Exclusive Deals</h3>
                <p>Get the best prices on flights, hotels, and tours with our special partnerships.</p>
            </div>
            <div class="glass-effect rounded-xl p-8 card-hover">
                <div class="text-4xl mb-6">✨</div>
                <h3 class="text-2xl font-bold mb-4">Personalized Plans</h3>
                <p>Tailor your journey exactly the way you like it with our custom travel planning.</p>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="container mx-auto px-6 py-20">
        <h2 class="text-4xl font-bold text-center mb-16 text-gradient">Why Choose Us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="glass-effect rounded-xl p-6 text-center hover-scale">
                <div class="text-3xl mb-4">✅</div>
                <h4 class="text-xl font-semibold mb-2">Expert Curation</h4>
                <p>We bring you only the best destinations and experiences.</p>
            </div>
            <div class="glass-effect rounded-xl p-6 text-center hover-scale">
                <div class="text-3xl mb-4">💰</div>
                <h4 class="text-xl font-semibold mb-2">Unbeatable Prices</h4>
                <p>Affordable luxury travel without compromising quality.</p>
            </div>
            <div class="glass-effect rounded-xl p-6 text-center hover-scale">
                <div class="text-3xl mb-4">🎯</div>
                <h4 class="text-xl font-semibold mb-2">24/7 Support</h4>
                <p>We're always here to assist you on your journey.</p>
            </div>
            <div class="glass-effect rounded-xl p-6 text-center hover-scale">
                <div class="text-3xl mb-4">🌱</div>
                <h4 class="text-xl font-semibold mb-2">Sustainable Tourism</h4>
                <p>Travel responsibly while supporting local communities.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="container mx-auto px-6 py-20 text-center">
        <h2 class="text-4xl font-bold mb-8 text-gradient">Ready to Start Your Adventure?</h2>
        <button class="glass-effect px-8 py-4 rounded-full text-xl font-semibold hover-scale">
            Let's Plan Your Journey! 🌟
        </button>
    </div>

    <script>
        // Create floating particles
        function createParticle() {
            const particles = document.getElementById('particles');
            const particle = document.createElement('div');
            particle.className = 'particle';
            
            const size = Math.random() * 5 + 2;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            
            const startX = Math.random() * window.innerWidth;
            const startY = window.innerHeight + 100;
            
            particle.style.left = `${startX}px`;
            particle.style.top = `${startY}px`;
            
            particles.appendChild(particle);
            
            const animation = particle.animate([
                { transform: `translate(0, 0)` },
                { transform: `translate(${Math.random() * 200 - 100}px, -${window.innerHeight + 200}px)` }
            ], {
                duration: Math.random() * 3000 + 3000,
                easing: 'linear'
            });
            
            animation.onfinish = () => {
                particle.remove();
            };
        }

        // Create particles periodically
        setInterval(createParticle, 100);

        // Add parallax effect
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.card-hover');
            const mouseX = e.clientX / window.innerWidth - 0.5;
            const mouseY = e.clientY / window.innerHeight - 0.5;

            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                const cardX = rect.left + rect.width / 2;
                const cardY = rect.top + rect.height / 2;
                
                const angleX = (cardY - e.clientY) * 0.01;
                const angleY = (cardX - e.clientX) * -0.01;
                
                card.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg)`;
            });
        });
    </script>
</body>
</html>
