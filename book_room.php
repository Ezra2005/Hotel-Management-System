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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id   = $_POST['room_id'] ?? null;
    $check_in  = $_POST['check_in'] ?? null;
    $check_out = $_POST['check_out'] ?? null;
    $guest_id  = $_SESSION['user_id'];

    if ($room_id && $check_in && $check_out) {
        try {
            // Insert booking
            $stmt = $pdo->prepare("INSERT INTO bookings (guest_id, room_id, check_in, check_out) 
                                   VALUES (?, ?, ?, ?)");
            $stmt->execute([$guest_id, $room_id, $check_in, $check_out]);

            echo "<p style='color:green;'>✅ Booking successful!</p>";
        } catch (Exception $e) {
            echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ Please fill all fields.</p>";
    }
}

// Get available rooms
$stmt = $pdo->query("SELECT id, room_number, type FROM rooms WHERE is_available = 1");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book a Room</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js" defer></script>
</head>
<body>
    <h2>Book a Room</h2>
    <form method="POST">
        <label>Room:</label>
        <select name="room_id" required>
            <?php foreach ($rooms as $room): ?>
                <option value="<?= htmlspecialchars($room['id']) ?>">
                    <?= htmlspecialchars($room['room_number']) ?> - <?= htmlspecialchars($room['type']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Check-in:</label>
        <input type="date" name="check_in" required><br><br>

        <label>Check-out:</label>
        <input type="date" name="check_out" required><br><br>

        <button type="submit">Book Now</button>
    </form>

    <br>
    <a href="guest_dashboard.php">⬅ Back to Dashboard</a>
</body>
</html>
