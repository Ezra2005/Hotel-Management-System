<?php
function getDashboardStatistics($db) {
    $stats = [];
    
    // Total bookings
    $query = "SELECT COUNT(*) as total FROM bookings";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stats['total_bookings'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Active guests
    $query = "SELECT COUNT(DISTINCT guest_id) as active FROM bookings WHERE check_out > NOW() AND status = 'checked_in'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stats['active_guests'] = $stmt->fetch(PDO::FETCH_ASSOC)['active'];
    
    // Revenue (this month)
    $query = "SELECT SUM(total_amount) as revenue FROM payments WHERE MONTH(payment_date) = MONTH(NOW()) AND YEAR(payment_date) = YEAR(NOW())";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stats['revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['revenue'] ?? 0;
    
    // Low inventory items
    $query = "SELECT COUNT(*) as low FROM inventory WHERE quantity <= min_quantity";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stats['low_inventory'] = $stmt->fetch(PDO::FETCH_ASSOC)['low'];
    
    return $stats;
}

function getRecentBookings($db) {
    $query = "SELECT b.id, g.name as guest_name, b.check_in, b.status, 
              CASE 
                WHEN b.status = 'confirmed' THEN 'success'
                WHEN b.status = 'checked_in' THEN 'primary'
                WHEN b.status = 'checked_out' THEN 'secondary'
                WHEN b.status = 'cancelled' THEN 'danger'
                ELSE 'warning'
              END as status_color
              FROM bookings b
              JOIN guests g ON b.guest_id = g.id
              ORDER BY b.created_at DESC LIMIT 5";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUpcomingCheckouts($db) {
    $query = "SELECT b.id, r.room_number, g.name as guest_name, b.check_out
              FROM bookings b
              JOIN guests g ON b.guest_id = g.id
              JOIN rooms r ON b.room_id = r.id
              WHERE b.status = 'checked_in' AND b.check_out BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 DAY)
              ORDER BY b.check_out ASC LIMIT 5";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAvailableRooms($db, $check_in, $check_out, $room_type = null) {
    $query = "SELECT r.*, rt.name as room_type, rt.price_per_night
              FROM rooms r
              JOIN room_types rt ON r.room_type_id = rt.id
              WHERE r.status = 'available'";
    
    if ($room_type) {
        $query .= " AND rt.id = :room_type";
    }
    
    $query .= " AND r.id NOT IN (
        SELECT room_id FROM bookings 
        WHERE status IN ('confirmed', 'checked_in') 
        AND (
            (check_in <= :check_out AND check_out >= :check_in)
        )
    )";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':check_in', $check_in);
    $stmt->bindParam(':check_out', $check_out);
    
    if ($room_type) {
        $stmt->bindParam(':room_type', $room_type);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>