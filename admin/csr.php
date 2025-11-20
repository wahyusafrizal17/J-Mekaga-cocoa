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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create' || $action == 'edit') {
        $judul = sanitize($_POST['judul']);
        $slug = generateSlug($judul);
        $deskripsi = $_POST['deskripsi'];
        $konten = $_POST['konten'] ?? null;
        $kategori = $_POST['kategori'];
        $lokasi = sanitize($_POST['lokasi'] ?? '');
        $tanggal_kegiatan = $_POST['tanggal_kegiatan'] ?? null;
        $status = $_POST['status'];
        $published_at = $status == 'published' ? date('Y-m-d H:i:s') : null;
        
        $gambar = null;
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
            $upload = uploadFile($_FILES['gambar'], 'uploads/csr/');
            if ($upload['success']) {
                $gambar = $upload['filename'];
            }
        }
        
        if ($action == 'create') {
            $stmt = $db->prepare("INSERT INTO csr (judul, slug, deskripsi, konten, gambar, kategori, lokasi, tanggal_kegiatan, status, published_at, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$judul, $slug, $deskripsi, $konten, $gambar, $kategori, $lokasi, $tanggal_kegiatan, $status, $published_at, $_SESSION['admin_id']]);
            $_SESSION['success'] = 'CSR berhasil ditambahkan!';
        } else {
            $oldData = $db->prepare("SELECT gambar FROM csr WHERE id = ?");
            $oldData->execute([$id]);
            $old = $oldData->fetch();
            
            if ($gambar && $old['gambar']) {
                deleteFile($old['gambar'], 'uploads/csr/');
            }
            
            if ($gambar) {
                $stmt = $db->prepare("UPDATE csr SET judul = ?, slug = ?, deskripsi = ?, konten = ?, gambar = ?, kategori = ?, lokasi = ?, tanggal_kegiatan = ?, status = ?, published_at = ? WHERE id = ?");
                $stmt->execute([$judul, $slug, $deskripsi, $konten, $gambar, $kategori, $lokasi, $tanggal_kegiatan, $status, $published_at, $id]);
            } else {
                $stmt = $db->prepare("UPDATE csr SET judul = ?, slug = ?, deskripsi = ?, konten = ?, kategori = ?, lokasi = ?, tanggal_kegiatan = ?, status = ?, published_at = ? WHERE id = ?");
                $stmt->execute([$judul, $slug, $deskripsi, $konten, $kategori, $lokasi, $tanggal_kegiatan, $status, $published_at, $id]);
            }
            $_SESSION['success'] = 'CSR berhasil diperbarui!';
        }
        header('Location: csr.php');
        exit;
    }
}

if ($action == 'delete' && $id) {
    $stmt = $db->prepare("SELECT gambar FROM csr WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    
    if ($data && $data['gambar']) {
        deleteFile($data['gambar'], 'uploads/csr/');
    }
    
    $stmt = $db->prepare("DELETE FROM csr WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = 'CSR berhasil dihapus!';
    header('Location: csr.php');
    exit;
}

$csr = null;
if ($action == 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM csr WHERE id = ?");
    $stmt->execute([$id]);
    $csr = $stmt->fetch();
    if (!$csr) {
        $_SESSION['error'] = 'CSR tidak ditemukan!';
        header('Location: csr.php');
        exit;
    }
}

// Now include header.php (after all redirects are handled)
$pageTitle = "CSR & Kegiatan Sosial";
require_once __DIR__ . '/includes/header.php';

if ($action == 'list') {
    $stmt = $db->query("SELECT c.*, ad.full_name as author FROM csr c LEFT JOIN admins ad ON c.created_by = ad.id ORDER BY c.created_at DESC");
    $csrs = $stmt->fetchAll();
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-heart me-2"></i>CSR & Kegiatan Sosial</h2>
        <a href="?action=create" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah CSR</a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($csrs as $c): ?>
                            <tr>
                                <td><?php echo $c['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($c['judul']); ?></strong></td>
                                <td><?php echo ucfirst(str_replace('_', ' ', $c['kategori'])); ?></td>
                                <td><?php echo htmlspecialchars($c['lokasi'] ?: '-'); ?></td>
                                <td><?php echo $c['tanggal_kegiatan'] ? formatDate($c['tanggal_kegiatan']) : '-'; ?></td>
                                <td><?php echo getStatusBadge($c['status']); ?></td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $c['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    <a href="?action=delete&id=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()"><i class="bi bi-trash"></i></a>
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
        <h2><i class="bi bi-heart me-2"></i><?php echo $action == 'create' ? 'Tambah' : 'Edit'; ?> CSR</h2>
        <a href="csr.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($csr['judul'] ?? ''); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required><?php echo htmlspecialchars($csr['deskripsi'] ?? ''); ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="konten" class="form-label">Konten Lengkap</label>
                    <textarea class="form-control" id="konten" name="konten" rows="10"><?php echo htmlspecialchars($csr['konten'] ?? ''); ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="beasiswa" <?php echo ($csr['kategori'] ?? '') == 'beasiswa' ? 'selected' : ''; ?>>Beasiswa</option>
                            <option value="lingkungan" <?php echo ($csr['kategori'] ?? '') == 'lingkungan' ? 'selected' : ''; ?>>Lingkungan</option>
                            <option value="kesehatan" <?php echo ($csr['kategori'] ?? '') == 'kesehatan' ? 'selected' : ''; ?>>Kesehatan</option>
                            <option value="bencana" <?php echo ($csr['kategori'] ?? '') == 'bencana' ? 'selected' : ''; ?>>Bencana</option>
                            <option value="pendidikan" <?php echo ($csr['kategori'] ?? '') == 'pendidikan' ? 'selected' : ''; ?>>Pendidikan</option>
                            <option value="lainnya" <?php echo ($csr['kategori'] ?? '') == 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo htmlspecialchars($csr['lokasi'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="<?php echo $csr['tanggal_kegiatan'] ?? ''; ?>">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="draft" <?php echo ($csr['status'] ?? 'draft') == 'draft' ? 'selected' : ''; ?>>Draft</option>
                            <option value="published" <?php echo ($csr['status'] ?? '') == 'published' ? 'selected' : ''; ?>>Published</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                    <?php if (isset($csr['gambar']) && $csr['gambar']): ?>
                        <div class="mt-2">
                            <img src="../../uploads/csr/<?php echo htmlspecialchars($csr['gambar']); ?>" alt="Current" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="csr.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php
}

require_once __DIR__ . '/includes/footer.php';
?>

