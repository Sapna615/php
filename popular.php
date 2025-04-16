<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popular Places - TravelEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #e74c3c;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #000;
            color: white;
            overflow-x: hidden;
        }

        .dynamic-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3;
        }

        .place-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            transform-style: preserve-3d;
            transition: all 0.5s;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .place-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .place-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .place-card:hover::before {
            left: 100%;
        }

        .season-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .features-list {
            list-style: none;
            padding-left: 0;
        }

        .features-list li {
            margin-bottom: 1rem;
            padding-left: 2rem;
            position: relative;
            transition: transform 0.3s;
        }

        .features-list li:hover {
            transform: translateX(10px);
        }

        .features-list li::before {
            content: "✔️";
            position: absolute;
            left: 0;
        }

        .section-title {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 2rem;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: titleGlow 2s infinite;
        }

        @keyframes titleGlow {
            0% { text-shadow: 0 0 10px rgba(255, 107, 107, 0.5); }
            50% { text-shadow: 0 0 20px rgba(78, 205, 196, 0.5); }
            100% { text-shadow: 0 0 10px rgba(255, 107, 107, 0.5); }
        }

        .navbar {
            background: rgba(0, 0, 0, 0.8) !important;
            backdrop-filter: blur(10px);
        }

        .seasonal-guide {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 3rem;
        }

        .season-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .booking-cta {
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            border: none;
            font-size: 1.2rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .booking-cta:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255, 107, 107, 0.5);
        }

        .booking-cta::after {
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
    </style>
</head>
<body>
    <div class="dynamic-bg" id="dynamicBg"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">TravelEase</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="destinations.php">Destinations</a></li>
                    <li class="nav-item"><a class="nav-link" href="popular.php">Popular Places</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5 mt-5">
        <h1 class="section-title">Popular Places – Discover the World's Must-Visit Destinations! 🌟</h1>
        <p class="lead text-center mb-5">Looking for breathtaking landscapes, vibrant cultures, and unforgettable experiences? Our Popular Places section features the world's most iconic destinations—handpicked for travelers who seek beauty, adventure, and inspiration. ✈️🌏</p>

        <!-- Timeless Wonders -->
        <div class="place-card" data-tilt>
            <span class="season-badge">Year-round</span>
            <h2>🏛️ Timeless Wonders – Step Into History!</h2>
            <p class="lead">Perfect for: Culture lovers, history buffs, and heritage explorers.</p>
            <ul class="features-list mb-4">
                <li>Machu Picchu, Peru – Hike to the ancient Incan city hidden in the Andes.</li>
                <li>The Great Wall of China – Walk along a marvel that spans over 13,000 miles.</li>
                <li>The Pyramids of Giza, Egypt – Witness the last standing wonder of the ancient world.</li>
                <li>Petra, Jordan – Explore the 'Rose City' carved into cliffs.</li>
                <li>Rome, Italy – From the Colosseum to the Vatican, history breathes here.</li>
            </ul>
        </div>

        <!-- Tropical Paradises -->
        <div class="place-card" data-tilt>
            <span class="season-badge">Best in Winter</span>
            <h2>🏝️ Tropical Paradises – Escape to Heaven!</h2>
            <p class="lead">Perfect for: Beach lovers, honeymooners, and sun-seekers.</p>
            <ul class="features-list mb-4">
                <li>Maldives – Overwater bungalows, crystal-clear waters, and endless serenity.</li>
                <li>Bora Bora, French Polynesia – A dreamy island with turquoise lagoons.</li>
                <li>Bali, Indonesia – From lush jungles to pristine beaches.</li>
                <li>Santorini, Greece – White-washed houses overlooking the Aegean Sea.</li>
                <li>Maui, Hawaii – Stunning waterfalls, golden beaches, and epic volcano hikes.</li>
            </ul>
        </div>

        <!-- Seasonal Travel Guide -->
        <div class="seasonal-guide">
            <h2 class="text-center mb-4">📅 Seasonal Travel Guide</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="season-icon">🌸</div>
                        <h4>Spring</h4>
                        <p>Cherry blossoms in Japan<br>Tulip fields in Netherlands</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="season-icon">☀️</div>
                        <h4>Summer</h4>
                        <p>Greek Islands<br>Mediterranean Coast</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="season-icon">🍁</div>
                        <h4>Autumn</h4>
                        <p>New England, USA<br>Scottish Highlands</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="season-icon">❄️</div>
                        <h4>Winter</h4>
                        <p>Northern Lights<br>Alpine Skiing</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-5">
            <button class="booking-cta">
                Start Your Journey Today! 🌍✈️
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>
    <script>
        // Dynamic Background Animation
        const colors = [
            ['#2c3e50', '#3498db'],
            ['#8e44ad', '#9b59b6'],
            ['#27ae60', '#2ecc71'],
            ['#c0392b', '#e74c3c'],
            ['#2980b9', '#3498db']
        ];

        let currentColorIndex = 0;
        const bg = document.getElementById('dynamicBg');

        function updateBackground() {
            const [color1, color2] = colors[currentColorIndex];
            bg.style.background = `
                linear-gradient(45deg, 
                    ${color1} 0%, 
                    ${color2} 100%
                )
            `;
            currentColorIndex = (currentColorIndex + 1) % colors.length;
        }

        // Initial background
        updateBackground();
        // Change background every 5 seconds
        setInterval(updateBackground, 5000);

        // Initialize tilt effect
        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
            max: 5,
            speed: 400,
            glare: true,
            "max-glare": 0.2
        });

        // Add parallax effect on mouse move
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.place-card');
            const mouseX = e.clientX / window.innerWidth - 0.5;
            const mouseY = e.clientY / window.innerHeight - 0.5;

            cards.forEach(card => {
                const cardRect = card.getBoundingClientRect();
                const cardCenterX = cardRect.left + cardRect.width / 2;
                const cardCenterY = cardRect.top + cardRect.height / 2;
                
                const angleX = (cardCenterY - e.clientY) * 0.01;
                const angleY = (cardCenterX - e.clientX) * -0.01;
                
                card.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg)`;
            });
        });
    </script>
</body>
</html>
