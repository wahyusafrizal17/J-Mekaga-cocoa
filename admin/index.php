<?php
$pageTitle = "Dashboard";
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Get statistics
$stats = [];

// Artikel
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published FROM artikel");
$stats['artikel'] = $stmt->fetch();

// Jurnal
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published FROM jurnal");
$stats['jurnal'] = $stmt->fetch();

// CSR
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published FROM csr");
$stats['csr'] = $stmt->fetch();

// Lowongan
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'open' THEN 1 ELSE 0 END) as open FROM lowongan");
$stats['lowongan'] = $stmt->fetch();

// Pelamar
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending FROM pelamar");
$stats['pelamar'] = $stmt->fetch();

// Testimoni
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved FROM testimoni");
$stats['testimoni'] = $stmt->fetch();

// Pengajuan Gadai
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending FROM pengajuan_gadai");
$stats['pengajuan'] = $stmt->fetch();

// Kontak
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'unread' THEN 1 ELSE 0 END) as unread FROM kontak");
$stats['kontak'] = $stmt->fetch();

// Recent Artikel
$stmt = $db->query("SELECT * FROM artikel ORDER BY created_at DESC LIMIT 5");
$recentArtikel = $stmt->fetchAll();

// Recent Pelamar
$stmt = $db->query("SELECT p.*, l.posisi FROM pelamar p LEFT JOIN lowongan l ON p.lowongan_id = l.id ORDER BY p.created_at DESC LIMIT 5");
$recentPelamar = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
    <span class="text-muted">Selamat datang, <?php echo htmlspecialchars($currentAdmin['full_name'] ?? $currentAdmin['username']); ?>!</span>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Artikel</h6>
                        <h3 class="mb-0"><?php echo $stats['artikel']['total']; ?></h3>
                        <small class="text-success"><?php echo $stats['artikel']['published']; ?> Published</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Lowongan</h6>
                        <h3 class="mb-0"><?php echo $stats['lowongan']['total']; ?></h3>
                        <small class="text-success"><?php echo $stats['lowongan']['open']; ?> Open</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-briefcase"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pelamar</h6>
                        <h3 class="mb-0"><?php echo $stats['pelamar']['total']; ?></h3>
                        <small class="text-warning"><?php echo $stats['pelamar']['pending']; ?> Pending</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pesan Kontak</h6>
                        <h3 class="mb-0"><?php echo $stats['kontak']['total']; ?></h3>
                        <small class="text-primary"><?php echo $stats['kontak']['unread']; ?> Unread</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Artikel -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-newspaper me-2"></i>Artikel Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recentArtikel)): ?>
                    <p class="text-muted">Belum ada artikel</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentArtikel as $artikel): ?>
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($artikel['judul']); ?></h6>
                                        <small class="text-muted"><?php echo formatDate($artikel['created_at']); ?></small>
                                    </div>
                                    <?php echo getStatusBadge($artikel['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-3">
                        <a href="artikel.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Pelamar -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-check me-2"></i>Pelamar Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recentPelamar)): ?>
                    <p class="text-muted">Belum ada pelamar</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentPelamar as $pelamar): ?>
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($pelamar['nama']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($pelamar['posisi'] ?? $pelamar['posisi']); ?> - <?php echo formatDate($pelamar['created_at']); ?></small>
                                    </div>
                                    <?php echo getStatusBadge($pelamar['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-3">
                        <a href="pelamar.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

