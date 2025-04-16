<?php
session_start();
require_once 'config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        // Step 1: Generate reset token
        $email = $_POST['email'];
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        try {
            // Check if email exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($user = $stmt->fetch()) {
                // Store reset token
                $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE email = ?");
                $stmt->execute([$token, $expiry, $email]);
                
                // Send reset email
                $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $token;
                $to = $email;
                $subject = "Password Reset - TravelEase";
                $message = "
                Hello,

                You have requested to reset your password. Click the link below to reset it:
                
                $resetLink
                
                This link will expire in 1 hour.
                
                If you didn't request this, please ignore this email.

                Best regards,
                TravelEase Team
                ";
                
                $headers = "From: noreply@travelease.com\r\n";
                $headers .= "Reply-To: support@travelease.com\r\n";
                $headers .= "X-Mailer: PHP/" . phpversion();
                
                mail($to, $subject, $message, $headers);
                $success = "Password reset instructions have been sent to your email.";
            } else {
                $error = "Email not found.";
            }
        } catch(PDOException $e) {
            $error = "An error occurred. Please try again.";
        }
    } elseif (isset($_POST['new_password']) && isset($_POST['token'])) {
        // Step 2: Reset password
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $token = $_POST['token'];
        
        try {
            $stmt = $pdo->prepare("SELECT email FROM users WHERE reset_token = ? AND reset_expiry > NOW()");
            $stmt->execute([$token]);
            if ($user = $stmt->fetch()) {
                $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE reset_token = ?");
                $stmt->execute([$new_password, $token]);
                $success = "Password has been reset successfully. You can now login.";
            } else {
                $error = "Invalid or expired reset token.";
            }
        } catch(PDOException $e) {
            $error = "An error occurred. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - TravelEase</title>
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

        .wave {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent 50%, rgba(52, 152, 219, 0.2) 100%);
            z-index: -1;
        }

        .wave::before,
        .wave::after {
            content: '';
            position: absolute;
            width: 300%;
            height: 100%;
            top: 0;
            left: -100%;
            transform-origin: 50% 50%;
            background-color: transparent;
            border-radius: 45%;
            animation: rotate 15s linear infinite;
        }

        .wave::after {
            border-radius: 47%;
            animation: rotate 10s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .reset-container {
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

        .success-message {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid rgba(46, 204, 113, 0.3);
            color: #fff;
            padding: 0.5rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .error-message {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.3);
            color: #fff;
            padding: 0.5rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="wave"></div>

    <div class="container">
        <div class="reset-container">
            <?php if (isset($_GET['token'])): ?>
                <h2 class="text-center mb-4">Reset Your Password</h2>
                <?php if (isset($success)): ?>
                    <div class="success-message text-center"><?php echo htmlspecialchars($success); ?></div>
                    <div class="text-center">
                        <a href="login.php" class="btn btn-primary">Go to Login</a>
                    </div>
                <?php else: ?>
                    <?php if (isset($error)): ?>
                        <div class="error-message text-center"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <form method="POST" action="reset_password.php" onsubmit="return validatePassword()">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                            <div class="password-requirements small text-light mt-2">
                                Password must be at least 8 characters long and contain:
                                <ul>
                                    <li>One uppercase letter</li>
                                    <li>One lowercase letter</li>
                                    <li>One number</li>
                                    <li>One special character</li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <h2 class="text-center mb-4">Forgot Password?</h2>
                <?php if (isset($success)): ?>
                    <div class="success-message text-center"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="error-message text-center"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form method="POST" action="reset_password.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Send Reset Link</button>
                    <div class="text-center">
                        <a href="login.php" class="text-light">Back to Login</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function validatePassword() {
            const password = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            
            if (!passwordRegex.test(password)) {
                alert('Password must meet all requirements');
                return false;
            }
            
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return false;
            }
            
            return true;
        }
    </script>
</body>
</html>
