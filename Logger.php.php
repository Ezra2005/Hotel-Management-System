class Logger {
    public static function log($userId, $action) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO audit_log (user_id, action) VALUES (?, ?)");
        $stmt->execute([$userId, $action]);
    }
}