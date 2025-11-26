<?php
$pageTitle = "Dashboard";
require_once __DIR__ . '/includes/header.php';

$db = getDB();

// Get statistics
$stats = [];

// Artikel
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published FROM artikel");
$stats['artikel'] = $stmt->fetch();

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

// Pemesanan Cocoa
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending FROM pemesanan_cocoa");
$stats['pemesanan_cocoa'] = $stmt->fetch();

// Pemesanan Farm
$stmt = $db->query("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending FROM pemesanan_farm");
$stats['pemesanan_farm'] = $stmt->fetch();

// Recent Artikel
$stmt = $db->query("SELECT * FROM artikel ORDER BY created_at DESC LIMIT 5");
$recentArtikel = $stmt->fetchAll();

// Recent CSR
$stmt = $db->query("SELECT * FROM csr ORDER BY created_at DESC LIMIT 5");
$recentCSR = $stmt->fetchAll();

// Recent Pelamar
$stmt = $db->query("SELECT p.*, l.posisi FROM pelamar p LEFT JOIN lowongan l ON p.lowongan_id = l.id ORDER BY p.created_at DESC LIMIT 5");
$recentPelamar = $stmt->fetchAll();

// Recent Testimoni
$stmt = $db->query("SELECT * FROM testimoni ORDER BY created_at DESC LIMIT 5");
$recentTestimoni = $stmt->fetchAll();

// Recent Pengajuan Gadai
$stmt = $db->query("SELECT * FROM pengajuan_gadai ORDER BY created_at DESC LIMIT 5");
$recentPengajuan = $stmt->fetchAll();

// Recent Kontak
$stmt = $db->query("SELECT * FROM kontak ORDER BY created_at DESC LIMIT 5");
$recentKontak = $stmt->fetchAll();

// Recent Pemesanan Cocoa
$stmt = $db->query("SELECT * FROM pemesanan_cocoa ORDER BY created_at DESC LIMIT 5");
$recentPemesananCocoa = $stmt->fetchAll();

// Recent Pemesanan Farm
$stmt = $db->query("SELECT * FROM pemesanan_farm ORDER BY created_at DESC LIMIT 5");
$recentPemesananFarm = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
    <span class="text-muted">Selamat datang, <?php echo htmlspecialchars($currentAdmin['full_name'] ?? $currentAdmin['username']); ?>!</span>
</div>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    .card-footer {
        padding: 0.75rem;
        transition: background-color 0.2s;
    }
    .card-footer:hover {
        background-color: #f8f9fa !important;
    }
</style>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Berita</h6>
                        <h3 class="mb-0"><?php echo $stats['artikel']['total'] ?? 0; ?></h3>
                        <small class="text-success"><?php echo $stats['artikel']['published'] ?? 0; ?> Published</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-newspaper"></i>
                    </div>
                </div>
            </div>
            <a href="artikel.php" class="card-footer bg-white text-center text-decoration-none text-primary border-top">
                <small>Lihat Detail <i class="bi bi-arrow-right"></i></small>
            </a>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">CSR & Kegiatan</h6>
                        <h3 class="mb-0"><?php echo $stats['csr']['total'] ?? 0; ?></h3>
                        <small class="text-success"><?php echo $stats['csr']['published'] ?? 0; ?> Published</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-heart"></i>
                    </div>
                </div>
            </div>
            <a href="csr.php" class="card-footer bg-white text-center text-decoration-none text-primary border-top">
                <small>Lihat Detail <i class="bi bi-arrow-right"></i></small>
            </a>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Lowongan</h6>
                        <h3 class="mb-0"><?php echo $stats['lowongan']['total'] ?? 0; ?></h3>
                        <small class="text-success"><?php echo $stats['lowongan']['open'] ?? 0; ?> Open</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-briefcase"></i>
                    </div>
                </div>
            </div>
            <a href="lowongan.php" class="card-footer bg-white text-center text-decoration-none text-primary border-top">
                <small>Lihat Detail <i class="bi bi-arrow-right"></i></small>
            </a>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pelamar</h6>
                        <h3 class="mb-0"><?php echo $stats['pelamar']['total'] ?? 0; ?></h3>
                        <small class="text-warning"><?php echo $stats['pelamar']['pending'] ?? 0; ?> Pending</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>
            </div>
            <a href="pelamar.php" class="card-footer bg-white text-center text-decoration-none text-primary border-top">
                <small>Lihat Detail <i class="bi bi-arrow-right"></i></small>
            </a>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Testimoni</h6>
                        <h3 class="mb-0"><?php echo $stats['testimoni']['total'] ?? 0; ?></h3>
                        <small class="text-success"><?php echo $stats['testimoni']['approved'] ?? 0; ?> Approved</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-star"></i>
                    </div>
                </div>
            </div>
            <a href="testimoni.php" class="card-footer bg-white text-center text-decoration-none text-primary border-top">
                <small>Lihat Detail <i class="bi bi-arrow-right"></i></small>
            </a>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pengajuan Gadai</h6>
                        <h3 class="mb-0"><?php echo $stats['pengajuan']['total'] ?? 0; ?></h3>
                        <small class="text-warning"><?php echo $stats['pengajuan']['pending'] ?? 0; ?> Pending</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                </div>
            </div>
            <a href="pengajuan.php" class="card-footer bg-white text-center text-decoration-none text-primary border-top">
                <small>Lihat Detail <i class="bi bi-arrow-right"></i></small>
            </a>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pemesanan Cocoa</h6>
                        <h3 class="mb-0"><?php echo $stats['pemesanan_cocoa']['total'] ?? 0; ?></h3>
                        <small class="text-warning"><?php echo $stats['pemesanan_cocoa']['pending'] ?? 0; ?> Pending</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-cart"></i>
                    </div>
                </div>
            </div>
            <a href="pemesanan.php?tab=cocoa" class="card-footer bg-white text-center text-decoration-none text-primary border-top">
                <small>Lihat Detail <i class="bi bi-arrow-right"></i></small>
            </a>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Pesan Kontak</h6>
                        <h3 class="mb-0"><?php echo $stats['kontak']['total'] ?? 0; ?></h3>
                        <small class="text-primary"><?php echo $stats['kontak']['unread'] ?? 0; ?> Unread</small>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
            </div>
            <a href="kontak.php" class="card-footer bg-white text-center text-decoration-none text-primary border-top">
                <small>Lihat Detail <i class="bi bi-arrow-right"></i></small>
            </a>
        </div>
    </div>
</div>

<!-- Recent Items Section -->
<div class="row g-4">
    <!-- Recent Berita -->
    <div class="col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-newspaper me-2"></i>Berita Terbaru</h5>
                <a href="artikel.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentArtikel)): ?>
                    <p class="text-muted mb-0">Belum ada berita</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentArtikel as $artikel): ?>
                            <div class="list-group-item px-0 border-bottom">
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
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent CSR -->
    <div class="col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-heart me-2"></i>CSR & Kegiatan Terbaru</h5>
                <a href="csr.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentCSR)): ?>
                    <p class="text-muted mb-0">Belum ada CSR</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentCSR as $csr): ?>
                            <div class="list-group-item px-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($csr['judul']); ?></h6>
                                        <small class="text-muted"><?php echo formatDate($csr['created_at']); ?></small>
                                    </div>
                                    <?php echo getStatusBadge($csr['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Pelamar -->
    <div class="col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-person-check me-2"></i>Pelamar Terbaru</h5>
                <a href="pelamar.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentPelamar)): ?>
                    <p class="text-muted mb-0">Belum ada pelamar</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentPelamar as $pelamar): ?>
                            <div class="list-group-item px-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($pelamar['nama']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($pelamar['posisi'] ?? '-'); ?> - <?php echo formatDate($pelamar['created_at']); ?></small>
                                    </div>
                                    <?php echo getStatusBadge($pelamar['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Testimoni -->
    <div class="col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-star me-2"></i>Testimoni Terbaru</h5>
                <a href="testimoni.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentTestimoni)): ?>
                    <p class="text-muted mb-0">Belum ada testimoni</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentTestimoni as $testimoni): ?>
                            <div class="list-group-item px-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($testimoni['nama']); ?></h6>
                                        <small class="text-muted"><?php echo formatDate($testimoni['created_at']); ?></small>
                                    </div>
                                    <?php echo getStatusBadge($testimoni['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Pengajuan Gadai -->
    <div class="col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Pengajuan Gadai Terbaru</h5>
                <a href="pengajuan.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentPengajuan)): ?>
                    <p class="text-muted mb-0">Belum ada pengajuan</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentPengajuan as $pengajuan): ?>
                            <div class="list-group-item px-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($pengajuan['nama']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($pengajuan['jenis_barang']); ?> - <?php echo formatDate($pengajuan['created_at']); ?></small>
                                    </div>
                                    <?php echo getStatusBadge($pengajuan['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Pesan Kontak -->
    <div class="col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>Pesan Kontak Terbaru</h5>
                <a href="kontak.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentKontak)): ?>
                    <p class="text-muted mb-0">Belum ada pesan</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentKontak as $kontak): ?>
                            <div class="list-group-item px-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($kontak['nama']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($kontak['subjek']); ?> - <?php echo formatDate($kontak['created_at']); ?></small>
                                    </div>
                                    <?php echo getStatusBadge($kontak['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Pemesanan Cocoa -->
    <div class="col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-cart me-2"></i>Pemesanan Cocoa Terbaru</h5>
                <a href="pemesanan.php?tab=cocoa" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentPemesananCocoa)): ?>
                    <p class="text-muted mb-0">Belum ada pemesanan</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentPemesananCocoa as $pemesanan): ?>
                            <div class="list-group-item px-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($pemesanan['nama']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($pemesanan['produk']); ?> - <?php echo formatDate($pemesanan['created_at']); ?></small>
                                    </div>
                                    <?php echo getStatusBadge($pemesanan['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Pemesanan Farm -->
    <div class="col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-cart me-2"></i>Pemesanan Farm Terbaru</h5>
                <a href="pemesanan.php?tab=farm" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($recentPemesananFarm)): ?>
                    <p class="text-muted mb-0">Belum ada pemesanan</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentPemesananFarm as $pemesanan): ?>
                            <div class="list-group-item px-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($pemesanan['nama']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($pemesanan['tipe']); ?> - <?php echo formatDate($pemesanan['created_at']); ?></small>
                                    </div>
                                    <?php echo getStatusBadge($pemesanan['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

