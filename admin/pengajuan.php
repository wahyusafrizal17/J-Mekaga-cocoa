<?php
$pageTitle = "Pengajuan Gadai";
require_once __DIR__ . '/includes/header.php';

$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'update_status') {
    $status = $_POST['status'];
    $catatan = sanitize($_POST['catatan'] ?? '');
    
    $stmt = $db->prepare("UPDATE pengajuan_gadai SET status = ?, catatan = ? WHERE id = ?");
    $stmt->execute([$status, $catatan, $id]);
    $_SESSION['success'] = 'Status pengajuan berhasil diperbarui!';
    header('Location: pengajuan.php');
    exit;
}

if ($action == 'list') {
    $statusFilter = $_GET['status'] ?? '';
    $where = '';
    $params = [];
    
    if ($statusFilter) {
        $where = "WHERE status = ?";
        $params[] = $statusFilter;
    }
    
    $sql = "SELECT * FROM pengajuan_gadai $where ORDER BY created_at DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $pengajuans = $stmt->fetchAll();
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-file-earmark-text me-2"></i>Pengajuan Gadai</h2>
        <div>
            <a href="?status=" class="btn btn-sm btn-outline-secondary">Semua</a>
            <a href="?status=pending" class="btn btn-sm btn-outline-warning">Pending</a>
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
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Jenis Barang</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pengajuans as $p): ?>
                            <tr>
                                <td><?php echo $p['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($p['nama']); ?></strong></td>
                                <td><?php echo htmlspecialchars($p['telepon']); ?></td>
                                <td><?php echo htmlspecialchars($p['email']); ?></td>
                                <td><?php echo ucfirst($p['jenis_barang']); ?></td>
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
    $stmt = $db->prepare("SELECT * FROM pengajuan_gadai WHERE id = ?");
    $stmt->execute([$id]);
    $pengajuan = $stmt->fetch();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $status = $_POST['status'];
        $catatan = sanitize($_POST['catatan'] ?? '');
        $stmt = $db->prepare("UPDATE pengajuan_gadai SET status = ?, catatan = ? WHERE id = ?");
        $stmt->execute([$status, $catatan, $id]);
        $_SESSION['success'] = 'Status berhasil diperbarui!';
        header('Location: pengajuan.php?action=view&id=' . $id);
        exit;
    }
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-file-earmark-text me-2"></i>Detail Pengajuan</h2>
        <a href="pengajuan.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
    </div>
    
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4">Informasi Pengajuan</h4>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nama:</strong><br>
                            <?php echo htmlspecialchars($pengajuan['nama']); ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong><br>
                            <?php echo htmlspecialchars($pengajuan['email']); ?>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Telepon:</strong><br>
                            <?php echo htmlspecialchars($pengajuan['telepon']); ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Jenis Barang:</strong><br>
                            <?php echo ucfirst($pengajuan['jenis_barang']); ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Deskripsi Barang:</strong><br>
                        <div class="p-3 bg-light rounded">
                            <?php echo nl2br(htmlspecialchars($pengajuan['deskripsi'])); ?>
                        </div>
                    </div>
                    
                    <?php if ($pengajuan['foto_barang']): ?>
                        <div class="mb-3">
                            <strong>Foto Barang:</strong><br>
                            <img src="../../uploads/pengajuan/<?php echo htmlspecialchars($pengajuan['foto_barang']); ?>" alt="Foto Barang" style="max-width: 300px;" class="img-thumbnail">
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
                                <option value="pending" <?php echo $pengajuan['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="review" <?php echo $pengajuan['status'] == 'review' ? 'selected' : ''; ?>>Review</option>
                                <option value="approved" <?php echo $pengajuan['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                                <option value="rejected" <?php echo $pengajuan['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="4"><?php echo htmlspecialchars($pengajuan['catatan'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php
}

require_once __DIR__ . '/includes/footer.php';
?>

