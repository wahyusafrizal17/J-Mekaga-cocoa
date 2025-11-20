<?php
$pageTitle = "Lowongan Pekerjaan";
require_once __DIR__ . '/includes/header.php';

$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create' || $action == 'edit') {
        $posisi = sanitize($_POST['posisi']);
        $divisi = sanitize($_POST['divisi']);
        $lokasi = sanitize($_POST['lokasi']);
        $deskripsi = $_POST['deskripsi'];
        $kualifikasi = $_POST['kualifikasi'];
        $tanggung_jawab = $_POST['tanggung_jawab'] ?? null;
        $gaji_min = $_POST['gaji_min'] ?: null;
        $gaji_max = $_POST['gaji_max'] ?: null;
        $tipe_pekerjaan = $_POST['tipe_pekerjaan'];
        $status = $_POST['status'];
        $deadline = $_POST['deadline'] ?: null;
        
        if ($action == 'create') {
            $stmt = $db->prepare("INSERT INTO lowongan (posisi, divisi, lokasi, deskripsi, kualifikasi, tanggung_jawab, gaji_min, gaji_max, tipe_pekerjaan, status, deadline, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$posisi, $divisi, $lokasi, $deskripsi, $kualifikasi, $tanggung_jawab, $gaji_min, $gaji_max, $tipe_pekerjaan, $status, $deadline, $_SESSION['admin_id']]);
            $_SESSION['success'] = 'Lowongan berhasil ditambahkan!';
        } else {
            $stmt = $db->prepare("UPDATE lowongan SET posisi = ?, divisi = ?, lokasi = ?, deskripsi = ?, kualifikasi = ?, tanggung_jawab = ?, gaji_min = ?, gaji_max = ?, tipe_pekerjaan = ?, status = ?, deadline = ? WHERE id = ?");
            $stmt->execute([$posisi, $divisi, $lokasi, $deskripsi, $kualifikasi, $tanggung_jawab, $gaji_min, $gaji_max, $tipe_pekerjaan, $status, $deadline, $id]);
            $_SESSION['success'] = 'Lowongan berhasil diperbarui!';
        }
        header('Location: lowongan.php');
        exit;
    }
}

if ($action == 'delete' && $id) {
    $stmt = $db->prepare("DELETE FROM lowongan WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = 'Lowongan berhasil dihapus!';
    header('Location: lowongan.php');
    exit;
}

$lowongan = null;
if ($action == 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM lowongan WHERE id = ?");
    $stmt->execute([$id]);
    $lowongan = $stmt->fetch();
    if (!$lowongan) {
        $_SESSION['error'] = 'Lowongan tidak ditemukan!';
        header('Location: lowongan.php');
        exit;
    }
}

if ($action == 'list') {
    $stmt = $db->query("SELECT l.*, ad.full_name as author FROM lowongan l LEFT JOIN admins ad ON l.created_by = ad.id ORDER BY l.created_at DESC");
    $lowongans = $stmt->fetchAll();
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-briefcase me-2"></i>Lowongan Pekerjaan</h2>
        <a href="?action=create" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Lowongan</a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Posisi</th>
                            <th>Divisi</th>
                            <th>Lokasi</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Deadline</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lowongans as $l): ?>
                            <tr>
                                <td><?php echo $l['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($l['posisi']); ?></strong></td>
                                <td><?php echo htmlspecialchars($l['divisi']); ?></td>
                                <td><?php echo htmlspecialchars($l['lokasi']); ?></td>
                                <td><?php echo ucfirst($l['tipe_pekerjaan']); ?></td>
                                <td><?php echo getStatusBadge($l['status']); ?></td>
                                <td><?php echo $l['deadline'] ? formatDate($l['deadline']) : '-'; ?></td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $l['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    <a href="?action=delete&id=<?php echo $l['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php
} else {
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-briefcase me-2"></i><?php echo $action == 'create' ? 'Tambah' : 'Edit'; ?> Lowongan</h2>
        <a href="lowongan.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="posisi" class="form-label">Posisi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="posisi" name="posisi" value="<?php echo htmlspecialchars($lowongan['posisi'] ?? ''); ?>" required>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="divisi" class="form-label">Divisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="divisi" name="divisi" value="<?php echo htmlspecialchars($lowongan['divisi'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo htmlspecialchars($lowongan['lokasi'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tipe_pekerjaan" class="form-label">Tipe Pekerjaan</label>
                        <select class="form-select" id="tipe_pekerjaan" name="tipe_pekerjaan" required>
                            <option value="fulltime" <?php echo ($lowongan['tipe_pekerjaan'] ?? 'fulltime') == 'fulltime' ? 'selected' : ''; ?>>Full Time</option>
                            <option value="parttime" <?php echo ($lowongan['tipe_pekerjaan'] ?? '') == 'parttime' ? 'selected' : ''; ?>>Part Time</option>
                            <option value="kontrak" <?php echo ($lowongan['tipe_pekerjaan'] ?? '') == 'kontrak' ? 'selected' : ''; ?>>Kontrak</option>
                            <option value="internship" <?php echo ($lowongan['tipe_pekerjaan'] ?? '') == 'internship' ? 'selected' : ''; ?>>Internship</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required><?php echo htmlspecialchars($lowongan['deskripsi'] ?? ''); ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="kualifikasi" class="form-label">Kualifikasi <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="kualifikasi" name="kualifikasi" rows="5" required><?php echo htmlspecialchars($lowongan['kualifikasi'] ?? ''); ?></textarea>
                    <small class="text-muted">Gunakan baris baru untuk setiap kualifikasi</small>
                </div>
                
                <div class="mb-3">
                    <label for="tanggung_jawab" class="form-label">Tanggung Jawab</label>
                    <textarea class="form-control" id="tanggung_jawab" name="tanggung_jawab" rows="5"><?php echo htmlspecialchars($lowongan['tanggung_jawab'] ?? ''); ?></textarea>
                    <small class="text-muted">Gunakan baris baru untuk setiap tanggung jawab</small>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="gaji_min" class="form-label">Gaji Minimum (Rp)</label>
                        <input type="number" class="form-control" id="gaji_min" name="gaji_min" value="<?php echo $lowongan['gaji_min'] ?? ''; ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="gaji_max" class="form-label">Gaji Maksimum (Rp)</label>
                        <input type="number" class="form-control" id="gaji_max" name="gaji_max" value="<?php echo $lowongan['gaji_max'] ?? ''; ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo $lowongan['deadline'] ?? ''; ?>">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="draft" <?php echo ($lowongan['status'] ?? 'draft') == 'draft' ? 'selected' : ''; ?>>Draft</option>
                        <option value="open" <?php echo ($lowongan['status'] ?? '') == 'open' ? 'selected' : ''; ?>>Open</option>
                        <option value="closed" <?php echo ($lowongan['status'] ?? '') == 'closed' ? 'selected' : ''; ?>>Closed</option>
                    </select>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="lowongan.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php
}

require_once __DIR__ . '/includes/footer.php';
?>

