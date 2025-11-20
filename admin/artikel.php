<?php
$pageTitle = "Artikel/Berita";
require_once __DIR__ . '/includes/header.php';

$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Handle actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create' || $action == 'edit') {
        $judul = sanitize($_POST['judul']);
        $slug = generateSlug($judul);
        $konten = $_POST['konten'];
        $excerpt = sanitize($_POST['excerpt']);
        $kategori = $_POST['kategori'];
        $status = $_POST['status'];
        $published_at = $status == 'published' ? date('Y-m-d H:i:s') : null;
        
        // Handle image upload
        $gambar = null;
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
            $upload = uploadFile($_FILES['gambar'], 'uploads/artikel/');
            if ($upload['success']) {
                $gambar = $upload['filename'];
            }
        }
        
        if ($action == 'create') {
            $stmt = $db->prepare("INSERT INTO artikel (judul, slug, konten, excerpt, gambar, kategori, status, published_at, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$judul, $slug, $konten, $excerpt, $gambar, $kategori, $status, $published_at, $_SESSION['admin_id']]);
            $_SESSION['success'] = 'Artikel berhasil ditambahkan!';
        } else {
            $oldData = $db->prepare("SELECT gambar FROM artikel WHERE id = ?");
            $oldData->execute([$id]);
            $old = $oldData->fetch();
            
            if ($gambar && $old['gambar']) {
                deleteFile($old['gambar'], 'uploads/artikel/');
            }
            
            if ($gambar) {
                $stmt = $db->prepare("UPDATE artikel SET judul = ?, slug = ?, konten = ?, excerpt = ?, gambar = ?, kategori = ?, status = ?, published_at = ? WHERE id = ?");
                $stmt->execute([$judul, $slug, $konten, $excerpt, $gambar, $kategori, $status, $published_at, $id]);
            } else {
                $stmt = $db->prepare("UPDATE artikel SET judul = ?, slug = ?, konten = ?, excerpt = ?, kategori = ?, status = ?, published_at = ? WHERE id = ?");
                $stmt->execute([$judul, $slug, $konten, $excerpt, $kategori, $status, $published_at, $id]);
            }
            $_SESSION['success'] = 'Artikel berhasil diperbarui!';
        }
        header('Location: artikel.php');
        exit;
    }
}

if ($action == 'delete' && $id) {
    $stmt = $db->prepare("SELECT gambar FROM artikel WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    
    if ($data && $data['gambar']) {
        deleteFile($data['gambar'], 'uploads/artikel/');
    }
    
    $stmt = $db->prepare("DELETE FROM artikel WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = 'Artikel berhasil dihapus!';
    header('Location: artikel.php');
    exit;
}

// Get data for edit
$artikel = null;
if ($action == 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM artikel WHERE id = ?");
    $stmt->execute([$id]);
    $artikel = $stmt->fetch();
    if (!$artikel) {
        $_SESSION['error'] = 'Artikel tidak ditemukan!';
        header('Location: artikel.php');
        exit;
    }
}

// List view
if ($action == 'list') {
    $page = $_GET['page'] ?? 1;
    $limit = 20;
    $offset = ($page - 1) * $limit;
    
    $stmt = $db->query("SELECT COUNT(*) as total FROM artikel");
    $total = $stmt->fetch()['total'];
    $totalPages = ceil($total / $limit);
    
    $stmt = $db->prepare("SELECT a.*, ad.full_name as author FROM artikel a LEFT JOIN admins ad ON a.created_by = ad.id ORDER BY a.created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$limit, $offset]);
    $artikels = $stmt->fetchAll();
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-newspaper me-2"></i>Artikel/Berita</h2>
        <a href="?action=create" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Artikel</a>
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
                            <th>Status</th>
                            <th>Author</th>
                            <th>Tanggal</th>
                            <th>Views</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($artikels as $art): ?>
                            <tr>
                                <td><?php echo $art['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($art['judul']); ?></strong>
                                    <?php if ($art['gambar']): ?>
                                        <i class="bi bi-image text-muted ms-2"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo ucfirst($art['kategori']); ?></td>
                                <td><?php echo getStatusBadge($art['status']); ?></td>
                                <td><?php echo htmlspecialchars($art['author'] ?? '-'); ?></td>
                                <td><?php echo formatDate($art['created_at']); ?></td>
                                <td><?php echo $art['views']; ?></td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $art['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="?action=delete&id=<?php echo $art['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">
                                        <i class="bi bi-trash"></i>
                                    </a>
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
    // Create/Edit form
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-newspaper me-2"></i><?php echo $action == 'create' ? 'Tambah' : 'Edit'; ?> Artikel</h2>
        <a href="artikel.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($artikel['judul'] ?? ''); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="excerpt" class="form-label">Ringkasan</label>
                    <textarea class="form-control" id="excerpt" name="excerpt" rows="3"><?php echo htmlspecialchars($artikel['excerpt'] ?? ''); ?></textarea>
                    <small class="text-muted">Ringkasan singkat artikel (akan digunakan sebagai deskripsi)</small>
                </div>
                
                <div class="mb-3">
                    <label for="konten" class="form-label">Konten <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="konten" name="konten" rows="10" required><?php echo htmlspecialchars($artikel['konten'] ?? ''); ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="artikel" <?php echo ($artikel['kategori'] ?? '') == 'artikel' ? 'selected' : ''; ?>>Artikel</option>
                            <option value="berita" <?php echo ($artikel['kategori'] ?? '') == 'berita' ? 'selected' : ''; ?>>Berita</option>
                            <option value="pengumuman" <?php echo ($artikel['kategori'] ?? '') == 'pengumuman' ? 'selected' : ''; ?>>Pengumuman</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="draft" <?php echo ($artikel['status'] ?? 'draft') == 'draft' ? 'selected' : ''; ?>>Draft</option>
                            <option value="published" <?php echo ($artikel['status'] ?? '') == 'published' ? 'selected' : ''; ?>>Published</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                    <?php if (isset($artikel['gambar']) && $artikel['gambar']): ?>
                        <div class="mt-2">
                            <img src="../../uploads/artikel/<?php echo htmlspecialchars($artikel['gambar']); ?>" alt="Current" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                            <p class="text-muted small mt-2">Gambar saat ini</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="artikel.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php
}

require_once __DIR__ . '/includes/footer.php';
?>

