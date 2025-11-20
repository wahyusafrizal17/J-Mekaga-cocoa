<?php
/**
 * Test Login - Debug Script
 * Hapus file ini setelah selesai debugging!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';

echo "<h2>Test Login Debug</h2>";
echo "<pre>";

// Test 1: Database Connection
echo "1. Testing Database Connection...\n";
try {
    $db = getDB();
    echo "✓ Database connection successful!\n\n";
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    echo "Please check your database configuration in config/database.php\n";
    exit;
}

// Test 2: Check if admins table exists
echo "2. Checking if 'admins' table exists...\n";
try {
    $stmt = $db->query("SHOW TABLES LIKE 'admins'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Table 'admins' exists!\n\n";
    } else {
        echo "✗ Table 'admins' does not exist!\n";
        echo "Please import the database schema from database/schema.sql\n";
        exit;
    }
} catch (Exception $e) {
    echo "✗ Error checking table: " . $e->getMessage() . "\n";
    exit;
}

// Test 3: Check if admin user exists
echo "3. Checking if admin user exists...\n";
try {
    $stmt = $db->query("SELECT * FROM admins WHERE username = 'admin'");
    $admin = $stmt->fetch();
    
    if ($admin) {
        echo "✓ Admin user found!\n";
        echo "   ID: " . $admin['id'] . "\n";
        echo "   Username: " . $admin['username'] . "\n";
        echo "   Email: " . $admin['email'] . "\n";
        echo "   Status: " . $admin['status'] . "\n";
        echo "   Password Hash: " . substr($admin['password'], 0, 20) . "...\n\n";
    } else {
        echo "✗ Admin user not found!\n";
        echo "Creating admin user...\n";
        
        // Create admin user with password 'admin123'
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO admins (username, email, password, full_name, role, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@megakayanganesha.com', $password, 'Administrator', 'super_admin', 'active']);
        echo "✓ Admin user created!\n";
        echo "   Username: admin\n";
        echo "   Password: admin123\n\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit;
}

// Test 4: Test password verification
echo "4. Testing password verification...\n";
try {
    $stmt = $db->prepare("SELECT * FROM admins WHERE username = 'admin'");
    $stmt->execute();
    $admin = $stmt->fetch();
    
    if ($admin) {
        $testPassword = 'admin123';
        if (password_verify($testPassword, $admin['password'])) {
            echo "✓ Password verification successful!\n";
            echo "   Password 'admin123' matches the hash in database.\n\n";
        } else {
            echo "✗ Password verification failed!\n";
            echo "   The password hash in database doesn't match 'admin123'.\n";
            echo "   Updating password...\n";
            
            // Update password
            $newPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE admins SET password = ? WHERE username = 'admin'");
            $stmt->execute([$newPassword]);
            echo "✓ Password updated! Try logging in again.\n\n";
        }
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit;
}

// Test 5: Test login function
echo "5. Testing login function...\n";
require_once __DIR__ . '/includes/auth.php';

// Start session for testing
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$testLogin = login('admin', 'admin123');
if ($testLogin) {
    echo "✓ Login function works correctly!\n";
    echo "   Session created successfully.\n";
    echo "   Admin ID in session: " . ($_SESSION['admin_id'] ?? 'not set') . "\n\n";
} else {
    echo "✗ Login function failed!\n";
    echo "   Please check the login function in admin/includes/auth.php\n\n";
}

echo "</pre>";
echo "<hr>";
echo "<h3>Summary:</h3>";
echo "<ul>";
echo "<li>If all tests passed, you should be able to login with: <strong>admin / admin123</strong></li>";
echo "<li>If any test failed, please fix the issue and refresh this page.</li>";
echo "<li><strong>IMPORTANT:</strong> Delete this file (test-login.php) after debugging for security!</li>";
echo "</ul>";
echo "<p><a href='login.php'>Go to Login Page</a></p>";

