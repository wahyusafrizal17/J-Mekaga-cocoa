<?php
// Include required files first (before any output)
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
requireLogin();

// Get database connection
require_once __DIR__ . '/../config/database.php';
$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Handle actions (must be before header.php to allow redirects)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'update_status') {
    $status = $_POST['status'];
    $stmt = $db->prepare("UPDATE kontak SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    $_SESSION['success'] = 'Status pesan berhasil diperbarui!';
    header('Location: kontak.php');
    exit;
}

// Now include header.php (after all redirects are handled)
$pageTitle = "Pesan Kontak";
require_once __DIR__ . '/includes/header.php';

if ($action == 'list') {
    $statusFilter = $_GET['status'] ?? '';
    $where = '';
    $params = [];
    
    if ($statusFilter) {
        $where = "WHERE status = ?";
        $params[] = $statusFilter;
    }
    
    $sql = "SELECT * FROM kontak $where ORDER BY created_at DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $kontaks = $stmt->fetchAll();
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-envelope me-2"></i>Pesan Kontak</h2>
        <div>
            <a href="?status=" class="btn btn-sm btn-outline-secondary">Semua</a>
            <a href="?status=unread" class="btn btn-sm btn-outline-primary">Unread</a>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Subjek</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kontaks as $k): ?>
                            <tr class="<?php echo $k['status'] == 'unread' ? 'table-primary' : ''; ?>">
                                <td><?php echo $k['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($k['nama']); ?></strong></td>
                                <td><?php echo htmlspecialchars($k['email']); ?></td>
                                <td><?php echo htmlspecialchars($k['telepon'] ?: '-'); ?></td>
                                <td><?php echo htmlspecialchars($k['subjek']); ?></td>
                                <td><?php echo getStatusBadge($k['status']); ?></td>
                                <td><?php echo formatDate($k['created_at']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal<?php echo $k['id']; ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="modal<?php echo $k['id']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Pesan dari <?php echo htmlspecialchars($k['nama']); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6"><strong>Email:</strong> <?php echo htmlspecialchars($k['email']); ?></div>
                                                <div class="col-md-6"><strong>Telepon:</strong> <?php echo htmlspecialchars($k['telepon'] ?: '-'); ?></div>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Subjek:</strong><br>
                                                <?php echo htmlspecialchars($k['subjek']); ?>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Pesan:</strong><br>
                                                <div class="p-3 bg-light rounded">
                                                    <?php echo nl2br(htmlspecialchars($k['pesan'])); ?>
                                                </div>
                                            </div>
                                            
                                            <form method="POST" class="mt-3">
                                                <input type="hidden" name="id" value="<?php echo $k['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="status<?php echo $k['id']; ?>" class="form-label">Status</label>
                                                    <select class="form-select" id="status<?php echo $k['id']; ?>" name="status" required>
                                                        <option value="unread" <?php echo $k['status'] == 'unread' ? 'selected' : ''; ?>>Unread</option>
                                                        <option value="read" <?php echo $k['status'] == 'read' ? 'selected' : ''; ?>>Read</option>
                                                        <option value="replied" <?php echo $k['status'] == 'replied' ? 'selected' : ''; ?>>Replied</option>
                                                        <option value="archived" <?php echo $k['status'] == 'archived' ? 'selected' : ''; ?>>Archived</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="update_status" value="1">
                                                <button type="submit" class="btn btn-primary">Update Status</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php
}

require_once __DIR__ . '/includes/footer.php';
?>

