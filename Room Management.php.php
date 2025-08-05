class Room {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function create($roomNumber, $type, $isAvailable = true) {
        if (!RoleManager::checkPermission('admin')) {
            throw new Exception("Access denied");
        }
        
        $stmt = $this->db->prepare("INSERT INTO rooms (room_number, type, is_available) VALUES (?, ?, ?)");
        $success = $stmt->execute([$roomNumber, $type, $isAvailable]);
        
        if ($success) {
            Logger::log($_SESSION['user_id'], "Created room $roomNumber");
        }
        
        return $success;
    }
    
    public function getAvailableRooms($checkIn, $checkOut) {
        $stmt = $this->db->prepare("
            SELECT r.* FROM rooms r
            WHERE r.is_available = TRUE
            AND r.id NOT IN (
                SELECT b.room_id FROM bookings b
                WHERE (
                    (b.check_in <= ? AND b.check_out >= ?) OR
                    (b.check_in >= ? AND b.check_in <= ?) OR
                    (b.check_out >= ? AND b.check_out <= ?)
                )
                AND b.status = 'confirmed'
            )
        ");
        
        $stmt->execute([$checkOut, $checkIn, $checkIn, $checkOut, $checkIn, $checkOut]);
        return $stmt->fetchAll();
    }
    
    // ... other CRUD methods
}