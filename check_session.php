<?php
require_once 'config/session_handler.php';
session_start();

header('Content-Type: application/json');

$response = ['expired' => false];

// Check if session exists and hasn't expired
if (!isset($_SESSION['user_id']) || !isset($_SESSION['LAST_ACTIVITY']) || 
    (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    $response['expired'] = true;
}

echo json_encode($response);
