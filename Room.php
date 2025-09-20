<?php
require_once __DIR__ . '/../config/db.php';

class Room {
    private $conn;
    private $table = "rooms";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add new room
    public function addRoom($room_number, $room_type, $price) {
        $query = "INSERT INTO " . $this->table . " (room_number, room_type, price) 
                  VALUES (:room_number, :room_type, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":room_number", $room_number);
        $stmt->bindParam(":room_type", $room_type);
        $stmt->bindParam(":price", $price);
        return $stmt->execute();
    }

    // Get all rooms
    public function getRooms() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
