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
        $nama = sanitize($_POST['nama']);
        $jabatan = sanitize($_POST['jabatan'] ?? '');
        $perusahaan = sanitize($_POST['perusahaan'] ?? '');
        $testimoni = $_POST['testimoni'];
        $rating = $_POST['rating'];
        $kategori = $_POST['kategori'];
        $status = $_POST['status'];
        
        $foto = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
            $upload = uploadFile($_FILES['foto'], 'uploads/testimoni/');
            if ($upload['success']) {
                $foto = $upload['filename'];
            }
        }
        
        if ($action == 'create') {
            $stmt = $db->prepare("INSERT INTO testimoni (nama, jabatan, perusahaan, testimoni, rating, foto, kategori, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $jabatan, $perusahaan, $testimoni, $rating, $foto, $kategori, $status]);
            $_SESSION['success'] = 'Testimoni berhasil ditambahkan!';
        } else {
            $oldData = $db->prepare("SELECT foto FROM testimoni WHERE id = ?");
            $oldData->execute([$id]);
            $old = $oldData->fetch();
            
            if ($foto && $old['foto']) {
                deleteFile($old['foto'], 'uploads/testimoni/');
            }
            
            if ($foto) {
                $stmt = $db->prepare("UPDATE testimoni SET nama = ?, jabatan = ?, perusahaan = ?, testimoni = ?, rating = ?, foto = ?, kategori = ?, status = ? WHERE id = ?");
                $stmt->execute([$nama, $jabatan, $perusahaan, $testimoni, $rating, $foto, $kategori, $status, $id]);
            } else {
                $stmt = $db->prepare("UPDATE testimoni SET nama = ?, jabatan = ?, perusahaan = ?, testimoni = ?, rating = ?, kategori = ?, status = ? WHERE id = ?");
                $stmt->execute([$nama, $jabatan, $perusahaan, $testimoni, $rating, $kategori, $status, $id]);
            }
            $_SESSION['success'] = 'Testimoni berhasil diperbarui!';
        }
        header('Location: testimoni.php');
        exit;
    }
}

if ($action == 'delete' && $id) {
    $stmt = $db->prepare("SELECT foto FROM testimoni WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    
    if ($data && $data['foto']) {
        deleteFile($data['foto'], 'uploads/testimoni/');
    }
    
    $stmt = $db->prepare("DELETE FROM testimoni WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = 'Testimoni berhasil dihapus!';
    header('Location: testimoni.php');
    exit;
}

// Now include header.php (after all redirects are handled)
$pageTitle = "Testimoni";
require_once __DIR__ . '/includes/header.php';

$testimoni = null;
if ($action == 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM testimoni WHERE id = ?");
    $stmt->execute([$id]);
    $testimoni = $stmt->fetch();
    if (!$testimoni) {
        $_SESSION['error'] = 'Testimoni tidak ditemukan!';
        header('Location: testimoni.php');
        exit;
    }
}

if ($action == 'list') {
    $stmt = $db->query("SELECT * FROM testimoni ORDER BY created_at DESC");
    $testimonis = $stmt->fetchAll();
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-star me-2"></i>Testimoni</h2>
        <a href="?action=create" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Testimoni</a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Kategori</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testimonis as $t): ?>
                            <tr>
                                <td><?php echo $t['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($t['nama']); ?></strong>
                                    <?php if ($t['foto']): ?>
                                        <i class="bi bi-image text-muted ms-2"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($t['jabatan'] ?: '-'); ?></td>
                                <td><?php echo ucfirst(str_replace('_', ' ', $t['kategori'])); ?></td>
                                <td>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?php echo $i <= $t['rating'] ? '-fill text-warning' : ''; ?>"></i>
                                    <?php endfor; ?>
                                </td>
                                <td><?php echo getStatusBadge($t['status']); ?></td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $t['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    <a href="?action=delete&id=<?php echo $t['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()"><i class="bi bi-trash"></i></a>
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
        <h2><i class="bi bi-star me-2"></i><?php echo $action == 'create' ? 'Tambah' : 'Edit'; ?> Testimoni</h2>
        <a href="testimoni.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($testimoni['nama'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo htmlspecialchars($testimoni['jabatan'] ?? ''); ?>">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="perusahaan" class="form-label">Perusahaan</label>
                    <input type="text" class="form-control" id="perusahaan" name="perusahaan" value="<?php echo htmlspecialchars($testimoni['perusahaan'] ?? ''); ?>">
                </div>
                
                <div class="mb-3">
                    <label for="testimoni" class="form-label">Testimoni <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="testimoni" name="testimoni" rows="5" required><?php echo htmlspecialchars($testimoni['testimoni'] ?? ''); ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                        <select class="form-select" id="rating" name="rating" required>
                            <option value="5" <?php echo ($testimoni['rating'] ?? 5) == 5 ? 'selected' : ''; ?>>5 Bintang</option>
                            <option value="4" <?php echo ($testimoni['rating'] ?? '') == 4 ? 'selected' : ''; ?>>4 Bintang</option>
                            <option value="3" <?php echo ($testimoni['rating'] ?? '') == 3 ? 'selected' : ''; ?>>3 Bintang</option>
                            <option value="2" <?php echo ($testimoni['rating'] ?? '') == 2 ? 'selected' : ''; ?>>2 Bintang</option>
                            <option value="1" <?php echo ($testimoni['rating'] ?? '') == 1 ? 'selected' : ''; ?>>1 Bintang</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="mekaga_gadai" <?php echo ($testimoni['kategori'] ?? '') == 'mekaga_gadai' ? 'selected' : ''; ?>>Mekaga Gadai</option>
                            <option value="mekaga_cocoa" <?php echo ($testimoni['kategori'] ?? '') == 'mekaga_cocoa' ? 'selected' : ''; ?>>Mekaga Cocoa</option>
                            <option value="mekaga_farm" <?php echo ($testimoni['kategori'] ?? '') == 'mekaga_farm' ? 'selected' : ''; ?>>Mekaga Farm</option>
                            <option value="umum" <?php echo ($testimoni['kategori'] ?? '') == 'umum' ? 'selected' : ''; ?>>Umum</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pending" <?php echo ($testimoni['status'] ?? 'pending') == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="approved" <?php echo ($testimoni['status'] ?? '') == 'approved' ? 'selected' : ''; ?>>Approved</option>
                        <option value="rejected" <?php echo ($testimoni['status'] ?? '') == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                    <?php if (isset($testimoni['foto']) && $testimoni['foto']): ?>
                        <div class="mt-2">
                            <img src="../../uploads/testimoni/<?php echo htmlspecialchars($testimoni['foto']); ?>" alt="Current" style="max-width: 100px; max-height: 100px;" class="img-thumbnail rounded-circle">
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="testimoni.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php
}

require_once __DIR__ . '/includes/footer.php';
?>

