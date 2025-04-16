<?php
session_start();

// Update last login time in database if user was logged in
if (isset($_SESSION['user_id'])) {
    require_once 'config/db_connect.php';
    
    $sql = "UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
}

// Destroy all session data
session_destroy();

// Clear session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Redirect to login page
header('Location: login.php');
exit();
