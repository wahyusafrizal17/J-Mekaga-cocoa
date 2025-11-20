<?php
$pageTitle = "Jurnal & Inovasi";
require_once __DIR__ . '/includes/header.php';

$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($action == 'create' || $action == 'edit') {
        $judul = sanitize($_POST['judul']);
        $slug = generateSlug($judul);
        $penulis = sanitize($_POST['penulis']);
        $tahun = $_POST['tahun'];
        $abstrak = $_POST['abstrak'];
        $konten = $_POST['konten'] ?? null;
        $kategori = $_POST['kategori'];
        $status = $_POST['status'];
        $published_at = $status == 'published' ? date('Y-m-d H:i:s') : null;
        
        $file_pdf = null;
        if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] == UPLOAD_ERR_OK) {
            $upload = uploadFile($_FILES['file_pdf'], 'uploads/jurnal/', ['application/pdf']);
            if ($upload['success']) {
                $file_pdf = $upload['filename'];
            }
        }
        
        if ($action == 'create') {
            $stmt = $db->prepare("INSERT INTO jurnal (judul, slug, penulis, tahun, abstrak, konten, file_pdf, kategori, status, published_at, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$judul, $slug, $penulis, $tahun, $abstrak, $konten, $file_pdf, $kategori, $status, $published_at, $_SESSION['admin_id']]);
            $_SESSION['success'] = 'Jurnal berhasil ditambahkan!';
        } else {
            $oldData = $db->prepare("SELECT file_pdf FROM jurnal WHERE id = ?");
            $oldData->execute([$id]);
            $old = $oldData->fetch();
            
            if ($file_pdf && $old['file_pdf']) {
                deleteFile($old['file_pdf'], 'uploads/jurnal/');
            }
            
            if ($file_pdf) {
                $stmt = $db->prepare("UPDATE jurnal SET judul = ?, slug = ?, penulis = ?, tahun = ?, abstrak = ?, konten = ?, file_pdf = ?, kategori = ?, status = ?, published_at = ? WHERE id = ?");
                $stmt->execute([$judul, $slug, $penulis, $tahun, $abstrak, $konten, $file_pdf, $kategori, $status, $published_at, $id]);
            } else {
                $stmt = $db->prepare("UPDATE jurnal SET judul = ?, slug = ?, penulis = ?, tahun = ?, abstrak = ?, konten = ?, kategori = ?, status = ?, published_at = ? WHERE id = ?");
                $stmt->execute([$judul, $slug, $penulis, $tahun, $abstrak, $konten, $kategori, $status, $published_at, $id]);
            }
            $_SESSION['success'] = 'Jurnal berhasil diperbarui!';
        }
        header('Location: jurnal.php');
        exit;
    }
}

if ($action == 'delete' && $id) {
    $stmt = $db->prepare("SELECT file_pdf FROM jurnal WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    
    if ($data && $data['file_pdf']) {
        deleteFile($data['file_pdf'], 'uploads/jurnal/');
    }
    
    $stmt = $db->prepare("DELETE FROM jurnal WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = 'Jurnal berhasil dihapus!';
    header('Location: jurnal.php');
    exit;
}

$jurnal = null;
if ($action == 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM jurnal WHERE id = ?");
    $stmt->execute([$id]);
    $jurnal = $stmt->fetch();
    if (!$jurnal) {
        $_SESSION['error'] = 'Jurnal tidak ditemukan!';
        header('Location: jurnal.php');
        exit;
    }
}

if ($action == 'list') {
    $stmt = $db->query("SELECT j.*, ad.full_name as author FROM jurnal j LEFT JOIN admins ad ON j.created_by = ad.id ORDER BY j.created_at DESC");
    $jurnals = $stmt->fetchAll();
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-journal-text me-2"></i>Jurnal & Inovasi</h2>
        <a href="?action=create" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Jurnal</a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Tahun</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>PDF</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jurnals as $j): ?>
                            <tr>
                                <td><?php echo $j['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($j['judul']); ?></strong></td>
                                <td><?php echo htmlspecialchars($j['penulis']); ?></td>
                                <td><?php echo $j['tahun']; ?></td>
                                <td><?php echo ucfirst(str_replace('_', ' ', $j['kategori'])); ?></td>
                                <td><?php echo getStatusBadge($j['status']); ?></td>
                                <td>
                                    <?php if ($j['file_pdf']): ?>
                                        <a href="../../uploads/jurnal/<?php echo htmlspecialchars($j['file_pdf']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-pdf"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $j['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    <a href="?action=delete&id=<?php echo $j['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()"><i class="bi bi-trash"></i></a>
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
        <h2><i class="bi bi-journal-text me-2"></i><?php echo $action == 'create' ? 'Tambah' : 'Edit'; ?> Jurnal</h2>
        <a href="jurnal.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($jurnal['judul'] ?? ''); ?>" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="penulis" class="form-label">Penulis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo htmlspecialchars($jurnal['penulis'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="tahun" name="tahun" value="<?php echo $jurnal['tahun'] ?? date('Y'); ?>" min="2000" max="<?php echo date('Y') + 1; ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="abstrak" class="form-label">Abstrak <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="abstrak" name="abstrak" rows="5" required><?php echo htmlspecialchars($jurnal['abstrak'] ?? ''); ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="konten" class="form-label">Konten Lengkap</label>
                    <textarea class="form-control" id="konten" name="konten" rows="10"><?php echo htmlspecialchars($jurnal['konten'] ?? ''); ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="jurnal" <?php echo ($jurnal['kategori'] ?? '') == 'jurnal' ? 'selected' : ''; ?>>Jurnal</option>
                            <option value="inovasi" <?php echo ($jurnal['kategori'] ?? '') == 'inovasi' ? 'selected' : ''; ?>>Inovasi</option>
                            <option value="tugas_akhir" <?php echo ($jurnal['kategori'] ?? '') == 'tugas_akhir' ? 'selected' : ''; ?>>Tugas Akhir</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="draft" <?php echo ($jurnal['status'] ?? 'draft') == 'draft' ? 'selected' : ''; ?>>Draft</option>
                            <option value="published" <?php echo ($jurnal['status'] ?? '') == 'published' ? 'selected' : ''; ?>>Published</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="file_pdf" class="form-label">File PDF</label>
                    <input type="file" class="form-control" id="file_pdf" name="file_pdf" accept="application/pdf">
                    <?php if (isset($jurnal['file_pdf']) && $jurnal['file_pdf']): ?>
                        <div class="mt-2">
                            <a href="../../uploads/jurnal/<?php echo htmlspecialchars($jurnal['file_pdf']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-pdf me-2"></i>Lihat PDF Saat Ini
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="jurnal.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php
}

require_once __DIR__ . '/includes/footer.php';
?>

