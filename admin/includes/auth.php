<?php
/**
 * Authentication Helper
 * Mega Kayan Ganesha Admin
 */

session_start();

require_once __DIR__ . '/../../config/database.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

// Require login
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Get current admin user
function getCurrentAdmin() {
    if (!isLoggedIn()) {
        return null;
    }
    
    $db = getDB();
    $stmt = $db->prepare("SELECT id, username, email, full_name, role, status FROM admins WHERE id = ? AND status = 'active'");
    $stmt->execute([$_SESSION['admin_id']]);
    return $stmt->fetch();
}

// Login function
function login($username, $password) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM admins WHERE (username = ? OR email = ?) AND status = 'active'");
    $stmt->execute([$username, $username]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_role'] = $admin['role'];
        
        // Update last login
        $updateStmt = $db->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?");
        $updateStmt->execute([$admin['id']]);
        
        return true;
    }
    
    return false;
}

// Logout function
function logout() {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

// Check if user has permission
function hasPermission($requiredRole = 'admin') {
    if (!isLoggedIn()) {
        return false;
    }
    
    $roles = ['editor' => 1, 'admin' => 2, 'super_admin' => 3];
    $currentRole = $_SESSION['admin_role'] ?? 'editor';
    $requiredLevel = $roles[$requiredRole] ?? 1;
    $currentLevel = $roles[$currentRole] ?? 1;
    
    return $currentLevel >= $requiredLevel;
}

// Require permission
function requirePermission($requiredRole = 'admin') {
    requireLogin();
    
    if (!hasPermission($requiredRole)) {
        header('Location: index.php?error=permission_denied');
        exit;
    }
}

