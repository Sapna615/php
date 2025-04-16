<?php
session_start();
require_once '../config/db_connect.php';
require_once '../check_session.php';

// Ensure user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Handle status updates
if (isset($_POST['update_status'])) {
    $message_id = $_POST['message_id'];
    $new_status = $_POST['new_status'];
    $admin_notes = $_POST['admin_notes'];
    
    $stmt = $pdo->prepare("UPDATE contact_submissions SET status = ?, admin_notes = ? WHERE id = ?");
    $stmt->execute([$new_status, $admin_notes, $message_id]);
    
    header('Location: view_messages.php?status=updated');
    exit();
}

// Get messages with optional filtering
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'all';
$query = "SELECT * FROM contact_submissions";
if ($status_filter !== 'all') {
    $query .= " WHERE status = ?";
}
$query .= " ORDER BY submission_date DESC";

$stmt = $pdo->prepare($query);
if ($status_filter !== 'all') {
    $stmt->execute([$status_filter]);
} else {
    $stmt->execute();
}
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact Messages - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Contact Messages</h1>
            <div>
                <form action="" method="GET" class="flex gap-2">
                    <select name="status_filter" class="rounded-lg border-gray-300 shadow-sm">
                        <option value="all" <?= $status_filter === 'all' ? 'selected' : '' ?>>All Messages</option>
                        <option value="new" <?= $status_filter === 'new' ? 'selected' : '' ?>>New</option>
                        <option value="in_progress" <?= $status_filter === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="resolved" <?= $status_filter === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'updated'): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            Message status updated successfully!
        </div>
        <?php endif; ?>

        <div class="grid gap-6">
            <?php foreach ($messages as $message): ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($message['subject']) ?></h2>
                        <p class="text-gray-600">From: <?= htmlspecialchars($message['name']) ?> (<?= htmlspecialchars($message['email']) ?>)</p>
                        <?php if ($message['phone']): ?>
                        <p class="text-gray-600">Phone: <?= htmlspecialchars($message['phone']) ?></p>
                        <?php endif; ?>
                        <p class="text-sm text-gray-500">Submitted: <?= date('F j, Y g:i a', strtotime($message['submission_date'])) ?></p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        <?php
                        switch($message['status']) {
                            case 'new': echo 'bg-blue-100 text-blue-800'; break;
                            case 'in_progress': echo 'bg-yellow-100 text-yellow-800'; break;
                            case 'resolved': echo 'bg-green-100 text-green-800'; break;
                        }
                        ?>">
                        <?= ucfirst(str_replace('_', ' ', $message['status'])) ?>
                    </span>
                </div>

                <div class="bg-gray-50 rounded p-4 mb-4">
                    <p class="text-gray-800 whitespace-pre-line"><?= htmlspecialchars($message['message']) ?></p>
                </div>

                <form action="" method="POST" class="space-y-4">
                    <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                        <select name="new_status" class="w-full rounded-lg border-gray-300 shadow-sm">
                            <option value="new" <?= $message['status'] === 'new' ? 'selected' : '' ?>>New</option>
                            <option value="in_progress" <?= $message['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="resolved" <?= $message['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Admin Notes</label>
                        <textarea name="admin_notes" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm"><?= htmlspecialchars($message['admin_notes'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" name="update_status" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Update Message
                    </button>
                </form>
            </div>
            <?php endforeach; ?>

            <?php if (empty($messages)): ?>
            <div class="text-center py-8 text-gray-600">
                No messages found.
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
