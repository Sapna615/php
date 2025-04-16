<?php
// Set session timeout to 30 minutes (1800 seconds)
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);

function checkSessionExpiration() {
    if (isset($_SESSION['LAST_ACTIVITY'])) {
        // If 30 minutes have passed since last activity
        if (time() - $_SESSION['LAST_ACTIVITY'] > 1800) {
            // Record last login time before destroying session
            if (isset($_SESSION['user_id'])) {
                require_once 'db_connect.php';
                $sql = "UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$_SESSION['user_id']]);
            }
            
            // Destroy session
            session_unset();
            session_destroy();
            
            // Clear session cookie
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time()-3600, '/');
            }
            
            // Redirect to login with expired message
            header('Location: /INT220/login.php?expired=1');
            exit();
        }
    }
    // Update last activity time
    $_SESSION['LAST_ACTIVITY'] = time();
}
?>
