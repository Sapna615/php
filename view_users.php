<?php
require_once '../config/db_connect.php';
require_once '../config/session_handler.php';
session_start();
checkSessionExpiration();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Fetch all users from the database
$sql = "SELECT u.*, up.theme, up.newsletter_subscription 
        FROM users u 
        LEFT JOIN user_preferences up ON u.id = up.user_id 
        ORDER BY u.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
    // Check session expiration every minute
    setInterval(function() {
        fetch('../check_session.php')
            .then(response => response.json())
            .then(data => {
                if (data.expired) {
                    window.location.href = '../login.php?expired=1';
                }
            });
    }, 60000); // Check every minute
    </script>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>User Details</h2>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Bio</th>
                        <th>Theme</th>
                        <th>Newsletter</th>
                        <th>Created At</th>
                        <th>Last Login</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['bio'] ?? 'Not provided'); ?></td>
                                <td><?php echo htmlspecialchars($user['theme'] ?? 'Default'); ?></td>
                                <td><?php echo $user['newsletter_subscription'] ? 'Yes' : 'No'; ?></td>
                                <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($user['last_login'] ?? 'Never'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// No need to close connection with PDO
?>
