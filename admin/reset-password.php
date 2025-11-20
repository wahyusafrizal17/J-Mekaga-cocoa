<?php
/**
 * Reset Admin Password
 * Hapus file ini setelah selesai!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $newPassword = $_POST['password'] ?? '';
    
    if ($username && $newPassword) {
        try {
            $db = getDB();
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $stmt = $db->prepare("UPDATE admins SET password = ? WHERE username = ?");
            $stmt->execute([$passwordHash, $username]);
            
            if ($stmt->rowCount() > 0) {
                $message = "Password berhasil direset untuk user: $username";
                $success = true;
            } else {
                $message = "User tidak ditemukan: $username";
            }
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Username dan password harus diisi!";
    }
}

// Get all admins
$admins = [];
try {
    $db = getDB();
    $stmt = $db->query("SELECT id, username, email, full_name, role, status FROM admins");
    $admins = $stmt->fetchAll();
} catch (Exception $e) {
    $message = "Error connecting to database: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Reset Admin Password</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-6">
                <h4>Reset Password</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <select class="form-select" id="username" name="username" required>
                            <option value="">Pilih Username</option>
                            <?php foreach ($admins as $admin): ?>
                                <option value="<?php echo htmlspecialchars($admin['username']); ?>">
                                    <?php echo htmlspecialchars($admin['username']); ?> 
                                    (<?php echo htmlspecialchars($admin['role']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </form>
            </div>
            
            <div class="col-md-6">
                <h4>Daftar Admin</h4>
                <?php if (empty($admins)): ?>
                    <p class="text-muted">Tidak ada admin ditemukan.</p>
                <?php else: ?>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admins as $admin): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($admin['username']); ?></td>
                                    <td><?php echo htmlspecialchars($admin['email']); ?></td>
                                    <td><?php echo htmlspecialchars($admin['role']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $admin['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                            <?php echo htmlspecialchars($admin['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
        
        <hr>
        
        <div class="alert alert-warning">
            <strong>Peringatan Keamanan:</strong> Hapus file ini (reset-password.php) setelah selesai menggunakan untuk keamanan!
        </div>
        
        <p>
            <a href="test-login.php" class="btn btn-secondary">Test Login</a>
            <a href="login.php" class="btn btn-primary">Go to Login</a>
        </p>
    </div>
</body>
</html>

