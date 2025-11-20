<?php
/**
 * Update Admin Password to admin123
 * Hapus file ini setelah selesai!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';

$message = '';
$success = false;

try {
    $db = getDB();
    
    // Check if admin exists
    $stmt = $db->prepare("SELECT id, username FROM admins WHERE username = ?");
    $stmt->execute(['admin']);
    $admin = $stmt->fetch();
    
    if (!$admin) {
        $message = "❌ Admin user tidak ditemukan!";
    } else {
        // Generate new password hash for 'admin123'
        $newPassword = 'admin123';
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update password
        $updateStmt = $db->prepare("UPDATE admins SET password = ? WHERE username = ?");
        $updateStmt->execute([$passwordHash, 'admin']);
        
        // Verify the update
        $verifyStmt = $db->prepare("SELECT password FROM admins WHERE username = ?");
        $verifyStmt->execute(['admin']);
        $updated = $verifyStmt->fetch();
        
        if ($updated && password_verify($newPassword, $updated['password'])) {
            $success = true;
            $message = "✅ Password berhasil diupdate!<br>";
            $message .= "Username: <strong>admin</strong><br>";
            $message .= "Password: <strong>admin123</strong><br><br>";
            $message .= "Silakan coba login sekarang.";
        } else {
            $message = "❌ Gagal mengupdate password!";
        }
    }
} catch (Exception $e) {
    $message = "❌ Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d83fd 0%, #0a6dd8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Update Password</h2>
            <p class="text-muted">Mega Kayan Ganesha Admin</p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert <?php echo $success ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <div class="text-center mt-4">
            <a href="login.php" class="btn btn-primary">Go to Login Page</a>
        </div>
        
        <div class="mt-4 text-center">
            <small class="text-muted">⚠️ Hapus file ini (update-password.php) setelah selesai untuk keamanan!</small>
        </div>
    </div>
</body>
</html>

