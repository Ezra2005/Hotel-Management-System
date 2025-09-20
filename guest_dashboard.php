<?php
session_start();

// redirect if not logged in or not guest
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'guest') {
    header("Location: login.php");
    exit;
}

$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Guest Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js" defer></script>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h2>
    <p>This is your guest dashboard.</p>
    
    <a href="book_room.php">Book a Room</a> | 
    <a href="my_bookings.php">My Bookings</a> | 
    <a href="logout.php">Logout</a>
</body>
</html>

