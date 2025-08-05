class RoleManager {
    public static function checkPermission($requiredRole) {
        if (!isset($_SESSION['role']) {
            return false;
        }
        
        // Admin has all permissions
        if ($_SESSION['role'] === 'admin') {
            return true;
        }
        
        return $_SESSION['role'] === $requiredRole;
    }
}