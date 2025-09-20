<?php
$host = "localhost";   // or 127.0.0.1
$dbname = "hotel_db";  // your database name
$username = "root";    // your MySQL username
$password = "";        // your MySQL password (default is empty in XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
?>
