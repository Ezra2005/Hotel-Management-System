<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);



// redirect if not logged in or not guest
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'guest') {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . "/../config/db.php";

$guest_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT b.id, r.room_number, r.type, b.check_in, b.check_out 
                           FROM bookings b
                           JOIN rooms r ON b.room_id = r.id
                           WHERE b.guest_id = ?");
    $stmt->execute([$guest_id]);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js" defer></script>
</head>
<body>
    <h2>My Bookings</h2>
    <?php if ($bookings): ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Room</th>
                <th>Type</th>
                <th>Check-in</th>
                <th>Check-out</th>
            </tr>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['id']) ?></td>
                    <td><?= htmlspecialchars($booking['room_number']) ?></td>
                    <td><?= htmlspecialchars($booking['type']) ?></td>
                    <td><?= htmlspecialchars($booking['check_in']) ?></td>
                    <td><?= htmlspecialchars($booking['check_out']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>

    <br>
    <a href="guest_dashboard.php">⬅ Back to Dashboard</a>
</body>
</html>
