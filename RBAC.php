<?php
class RoleManager {
    public static function canAccess($requiredRole) {
        if (!isset($_SESSION['role'])) {
            return false;
        }
        
        // Admin has access to everything
        if ($_SESSION['role'] === 'admin') {
            return true;
        }
        
        // Guest can only access guest features
        if ($_SESSION['role'] === 'guest' && $requiredRole === 'guest') {
            return true;
        }
        
        return false;
    }
    
    public static function checkAccess($requiredRole) {
        if (!self::canAccess($requiredRole)) {
            header('HTTP/1.0 403 Forbidden');
            echo "Access Denied: You don't have permission to access this page.";
            exit;
        }
    }
}
?>