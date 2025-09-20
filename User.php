<?php
require_once __DIR__ . '/../config/db.php';

class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register new user
    public function register($name, $email, $password, $role) {
    // check if email already exists
    $query = "SELECT id FROM users WHERE email = :email";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return false; // email already exists
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password, role, created_at) 
              VALUES (:name, :email, :password, :role, NOW())";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashed_password);
    $stmt->bindParam(":role", $role);

    return $stmt->execute();
}
public function createAdmin($name, $email, $password) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $this->connect()->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')");
    return $stmt->execute([$name, $email, $hashedPassword]);
}



    // Login user
    public function login($email, $password) {
    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
            return $user; // return full user row
        }
    }
    return false;
}

    
}
?>
