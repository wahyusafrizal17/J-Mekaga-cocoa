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
    $catatan = sanitize($_POST['catatan'] ?? '');
    
    $stmt = $db->prepare("UPDATE pelamar SET status = ?, catatan = ? WHERE id = ?");
    $stmt->execute([$status, $catatan, $id]);
    $_SESSION['success'] = 'Status pelamar berhasil diperbarui!';
    header('Location: pelamar.php');
    exit;
}

$pelamar = null;
if ($action == 'view' && $id) {
    $stmt = $db->prepare("SELECT p.*, l.posisi, l.divisi FROM pelamar p LEFT JOIN lowongan l ON p.lowongan_id = l.id WHERE p.id = ?");
    $stmt->execute([$id]);
    $pelamar = $stmt->fetch();
    if (!$pelamar) {
        $_SESSION['error'] = 'Pelamar tidak ditemukan!';
        header('Location: pelamar.php');
        exit;
    }
}

// Now include header.php (after all redirects are handled)
$pageTitle = "Pelamar";
require_once __DIR__ . '/includes/header.php';

if ($action == 'list') {
    $statusFilter = $_GET['status'] ?? '';
    $where = '';
    $params = [];
    
    if ($statusFilter) {
        $where = "WHERE p.status = ?";
        $params[] = $statusFilter;
    }
    
    $sql = "SELECT p.*, l.posisi, l.divisi FROM pelamar p LEFT JOIN lowongan l ON p.lowongan_id = l.id $where ORDER BY p.created_at DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $pelamars = $stmt->fetchAll();
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-check me-2"></i>Pelamar</h2>
        <div>
            <a href="?status=" class="btn btn-sm btn-outline-secondary">Semua</a>
            <a href="?status=pending" class="btn btn-sm btn-outline-warning">Pending</a>
            <a href="?status=review" class="btn btn-sm btn-outline-info">Review</a>
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
                            <th>Posisi</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pelamars as $p): ?>
                            <tr>
                                <td><?php echo $p['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($p['nama']); ?></strong></td>
                                <td><?php echo htmlspecialchars($p['posisi'] ?: $p['posisi']); ?></td>
                                <td><?php echo htmlspecialchars($p['email']); ?></td>
                                <td><?php echo htmlspecialchars($p['telepon']); ?></td>
                                <td><?php echo getStatusBadge($p['status']); ?></td>
                                <td><?php echo formatDate($p['created_at']); ?></td>
                                <td>
                                    <a href="?action=view&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php
} else if ($action == 'view') {
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-check me-2"></i>Detail Pelamar</h2>
        <a href="pelamar.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
    </div>
    
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4">Informasi Pelamar</h4>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nama Lengkap:</strong><br>
                            <?php echo htmlspecialchars($pelamar['nama']); ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong><br>
                            <?php echo htmlspecialchars($pelamar['email']); ?>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Telepon:</strong><br>
                            <?php echo htmlspecialchars($pelamar['telepon']); ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Posisi yang Dilamar:</strong><br>
                            <?php echo htmlspecialchars($pelamar['posisi'] ?: $pelamar['posisi']); ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Alamat:</strong><br>
                        <?php echo nl2br(htmlspecialchars($pelamar['alamat'])); ?>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Pendidikan Terakhir:</strong><br>
                            <?php echo htmlspecialchars($pelamar['pendidikan']); ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Pengalaman:</strong><br>
                            <?php echo htmlspecialchars($pelamar['pengalaman']); ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Motivasi & Alasan Melamar:</strong><br>
                        <div class="p-3 bg-light rounded">
                            <?php echo nl2br(htmlspecialchars($pelamar['motivasi'])); ?>
                        </div>
                    </div>
                    
                    <?php if ($pelamar['cv_file']): ?>
                        <div class="mb-3">
                            <strong>CV/Resume:</strong><br>
                            <a href="../../uploads/pelamar/<?php echo htmlspecialchars($pelamar['cv_file']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-pdf me-2"></i>Download CV
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($pelamar['foto_file']): ?>
                        <div class="mb-3">
                            <strong>Foto:</strong><br>
                            <img src="../../uploads/pelamar/<?php echo htmlspecialchars($pelamar['foto_file']); ?>" alt="Foto" style="max-width: 200px;" class="img-thumbnail">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Update Status</h5>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" <?php echo $pelamar['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="review" <?php echo $pelamar['status'] == 'review' ? 'selected' : ''; ?>>Review</option>
                                <option value="interview" <?php echo $pelamar['status'] == 'interview' ? 'selected' : ''; ?>>Interview</option>
                                <option value="accepted" <?php echo $pelamar['status'] == 'accepted' ? 'selected' : ''; ?>>Accepted</option>
                                <option value="rejected" <?php echo $pelamar['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="4"><?php echo htmlspecialchars($pelamar['catatan'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                    
                    <hr>
                    
                    <div class="small text-muted">
                        <strong>Dikirim:</strong><br>
                        <?php echo formatDateTime($pelamar['created_at']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
}

require_once __DIR__ . '/includes/footer.php';
?>

