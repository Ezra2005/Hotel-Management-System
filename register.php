<?php
session_start();

// ✅ show errors instead of blank page
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $error = "⚠️ Email already registered!";
        } else {
            // insert as guest by default
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'guest')");
            $stmt->execute([$name, $email, $hashedPassword]);

            $_SESSION["user_id"] = $pdo->lastInsertId();
            $_SESSION["name"] = $name;
            $_SESSION["role"] = "guest";

            header("Location: guest_dashboard.php");
            exit;
        }
    } catch (Exception $e) {
        $error = "❌ Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js" defer></script>
</head>
<body>
    <h2>Guest Registration</h2>
    
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
