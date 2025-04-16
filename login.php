<?php
session_start();
require_once 'config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        
        // Update last login time
        $stmt = $pdo->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$user['id']]);
        
        // Create user preferences if not exists
        $stmt = $pdo->prepare("INSERT IGNORE INTO user_preferences (user_id) VALUES (?)");
        $stmt->execute([$user['id']]);
        
        header("Location: index.html");
        exit();
    } else {
        $error = "Invalid credentials";
    }
}

// Check for registration success message
if (isset($_GET['registered']) && $_GET['registered'] == 'true') {
    $success = "Registration successful! Please login.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TravelEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #34495e;
            --accent: #3498db;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: var(--primary);
            font-family: 'Arial', sans-serif;
            overflow: hidden;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .cube {
            position: absolute;
            background: rgba(52, 152, 219, 0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: cubeFloat 20s infinite linear;
        }

        @keyframes cubeFloat {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                transform: translateY(-1000px) rotate(360deg);
                opacity: 0;
            }
        }

        .login-container {
            position: relative;
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            animation: rotate 15s infinite linear;
            z-index: -1;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--accent);
            color: white;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.3);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .btn-primary {
            background: var(--accent);
            border: none;
            padding: 0.8rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .register-link {
            color: var(--accent);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .register-link:hover {
            color: #2980b9;
            text-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
        }

        .error-message {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.3);
            color: #fff;
            padding: 0.5rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .success-message {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid rgba(46, 204, 113, 0.3);
            color: #fff;
            padding: 0.5rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .forgot-password {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .forgot-password:hover {
            color: var(--accent);
            text-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
        }
    </style>
</head>
<body>
    <div class="background" id="background"></div>

    <div class="container">
        <div class="login-container">
            <h2 class="text-center mb-4">Welcome Back</h2>
            
            <?php if (isset($success)): ?>
                <div class="success-message text-center">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="error-message text-center">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="text-end mt-1">
                        <a href="reset_password.php" class="forgot-password">Forgot Password?</a>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                <div class="text-center">
                    <p>Don't have an account? <a href="register.php" class="register-link">Register now</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function createCube() {
            const cube = document.createElement('div');
            cube.className = 'cube';
            
            // Random size between 20 and 100 pixels
            const size = Math.random() * 80 + 20;
            cube.style.width = `${size}px`;
            cube.style.height = `${size}px`;
            
            // Random position
            cube.style.left = `${Math.random() * 100}%`;
            cube.style.bottom = '-100px';
            
            // Random rotation
            cube.style.transform = `rotate(${Math.random() * 360}deg)`;
            
            // Random animation duration
            const duration = Math.random() * 10 + 10;
            cube.style.animationDuration = `${duration}s`;
            
            document.getElementById('background').appendChild(cube);
            
            // Remove cube after animation
            setTimeout(() => {
                cube.remove();
            }, duration * 1000);
        }

        // Create cubes periodically
        setInterval(createCube, 500);

        // Create initial set of cubes
        for (let i = 0; i < 10; i++) {
            setTimeout(createCube, i * 200);
        }
    </script>
</body>
</html>
