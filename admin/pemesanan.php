<?php
$pageTitle = "Pemesanan";
require_once __DIR__ . '/includes/header.php';

$db = getDB();
$tab = $_GET['tab'] ?? 'cocoa';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $catatan = sanitize($_POST['catatan'] ?? '');
    
    if ($tab == 'cocoa') {
        $stmt = $db->prepare("UPDATE pemesanan_cocoa SET status = ?, catatan = ? WHERE id = ?");
    } else {
        $stmt = $db->prepare("UPDATE pemesanan_farm SET status = ?, catatan = ? WHERE id = ?");
    }
    $stmt->execute([$status, $catatan, $id]);
    $_SESSION['success'] = 'Status pemesanan berhasil diperbarui!';
    header('Location: pemesanan.php?tab=' . $tab);
    exit;
}

if ($tab == 'cocoa') {
    $stmt = $db->query("SELECT * FROM pemesanan_cocoa ORDER BY created_at DESC");
    $pemesanans = $stmt->fetchAll();
    $title = "Pemesanan Cocoa";
} else {
    $stmt = $db->query("SELECT * FROM pemesanan_farm ORDER BY created_at DESC");
    $pemesanans = $stmt->fetchAll();
    $title = "Pemesanan/Kerjasama Farm";
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cart me-2"></i>Pemesanan</h2>
</div>

<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link <?php echo $tab == 'cocoa' ? 'active' : ''; ?>" href="?tab=cocoa">Pemesanan Cocoa</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo $tab == 'farm' ? 'active' : ''; ?>" href="?tab=farm">Pemesanan Farm</a>
    </li>
</ul>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="mb-3"><?php echo $title; ?></h5>
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <?php if ($tab == 'cocoa'): ?>
                            <th>Produk</th>
                            <th>Jumlah</th>
                        <?php else: ?>
                            <th>Tipe</th>
                        <?php endif; ?>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pemesanans as $p): ?>
                        <tr>
                            <td><?php echo $p['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($p['nama']); ?></strong></td>
                            <td><?php echo htmlspecialchars($p['email']); ?></td>
                            <td><?php echo htmlspecialchars($p['telepon']); ?></td>
                            <?php if ($tab == 'cocoa'): ?>
                                <td><?php echo htmlspecialchars($p['produk']); ?></td>
                                <td><?php echo number_format($p['jumlah'], 2); ?> kg</td>
                            <?php else: ?>
                                <td><?php echo ucfirst($p['tipe']); ?></td>
                            <?php endif; ?>
                            <td><?php echo getStatusBadge($p['status']); ?></td>
                            <td><?php echo formatDate($p['created_at']); ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal<?php echo $p['id']; ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="modal<?php echo $p['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Pemesanan #<?php echo $p['id']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6"><strong>Nama:</strong> <?php echo htmlspecialchars($p['nama']); ?></div>
                                            <div class="col-md-6"><strong>Email:</strong> <?php echo htmlspecialchars($p['email']); ?></div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6"><strong>Telepon:</strong> <?php echo htmlspecialchars($p['telepon']); ?></div>
                                            <?php if ($tab == 'cocoa'): ?>
                                                <div class="col-md-6"><strong>Produk:</strong> <?php echo htmlspecialchars($p['produk']); ?></div>
                                            <?php else: ?>
                                                <div class="col-md-6"><strong>Tipe:</strong> <?php echo ucfirst($p['tipe']); ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($tab == 'cocoa'): ?>
                                            <div class="mb-3">
                                                <strong>Jumlah:</strong> <?php echo number_format($p['jumlah'], 2); ?> kg
                                            </div>
                                            <div class="mb-3">
                                                <strong>Alamat Pengiriman:</strong><br>
                                                <?php echo nl2br(htmlspecialchars($p['alamat'])); ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="mb-3">
                                                <strong>Pesan:</strong><br>
                                                <div class="p-3 bg-light rounded">
                                                    <?php echo nl2br(htmlspecialchars($p['pesan'])); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <form method="POST" class="mt-3">
                                            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                            <div class="mb-3">
                                                <label for="status<?php echo $p['id']; ?>" class="form-label">Status</label>
                                                <select class="form-select" id="status<?php echo $p['id']; ?>" name="status" required>
                                                    <?php if ($tab == 'cocoa'): ?>
                                                        <option value="pending" <?php echo $p['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="confirmed" <?php echo $p['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                        <option value="processing" <?php echo $p['status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                                        <option value="shipped" <?php echo $p['status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                                        <option value="completed" <?php echo $p['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                        <option value="cancelled" <?php echo $p['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                    <?php else: ?>
                                                        <option value="pending" <?php echo $p['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="review" <?php echo $p['status'] == 'review' ? 'selected' : ''; ?>>Review</option>
                                                        <option value="approved" <?php echo $p['status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                                                        <option value="rejected" <?php echo $p['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="catatan<?php echo $p['id']; ?>" class="form-label">Catatan</label>
                                                <textarea class="form-control" id="catatan<?php echo $p['id']; ?>" name="catatan" rows="3"><?php echo htmlspecialchars($p['catatan'] ?? ''); ?></textarea>
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

<?php require_once __DIR__ . '/includes/footer.php'; ?>

