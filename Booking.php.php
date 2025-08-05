class Booking {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function create($guestId, $roomId, $checkIn, $checkOut, $guestData) {
        // Verify room availability
        $room = new Room($this->db);
        $availableRooms = $room->getAvailableRooms($checkIn, $checkOut);
        $isAvailable = false;
        
        foreach ($availableRooms as $availableRoom) {
            if ($availableRoom['id'] == $roomId) {
                $isAvailable = true;
                break;
            }
        }
        
        if (!$isAvailable) {
            throw new Exception("Room is not available for the selected dates");
        }
        
        $stmt = $this->db->prepare("
            INSERT INTO bookings 
            (guest_id, room_id, check_in, check_out, guest_data) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $success = $stmt->execute([$guestId, $roomId, $checkIn, $checkOut, $guestData]);
        
        if ($success) {
            Logger::log($_SESSION['user_id'], "Created booking for room $roomId");
        }
        
        return $success;
    }
    
    // ... other methods
}