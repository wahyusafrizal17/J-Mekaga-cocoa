<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';
requireLogin();

$currentAdmin = getCurrentAdmin();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Admin Panel - Mega Kayan Ganesha</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d83fd 0%, #0a6dd8 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 20px;
            z-index: 1000;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-left: 250px;
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
                transition: margin-left 0.3s;
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-content,
            .navbar-custom {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="text-center mb-4">
            <h4 class="text-white">Mega Kayan Ganesha</h4>
            <small>Admin Panel</small>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>" href="index.php">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($currentPage, 'artikel') !== false ? 'active' : ''; ?>" href="artikel.php">
                    <i class="bi bi-newspaper me-2"></i> Berita
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($currentPage, 'csr') !== false ? 'active' : ''; ?>" href="csr.php">
                    <i class="bi bi-heart me-2"></i> CSR & Kegiatan Sosial
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($currentPage, 'lowongan') !== false ? 'active' : ''; ?>" href="lowongan.php">
                    <i class="bi bi-briefcase me-2"></i> Karier
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($currentPage, 'pelamar') !== false ? 'active' : ''; ?>" href="pelamar.php">
                    <i class="bi bi-person-check me-2"></i> Pelamar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($currentPage, 'testimoni') !== false ? 'active' : ''; ?>" href="testimoni.php">
                    <i class="bi bi-star me-2"></i> Testimoni
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($currentPage, 'pengajuan') !== false ? 'active' : ''; ?>" href="pengajuan.php">
                    <i class="bi bi-file-earmark-text me-2"></i> Pengajuan Gadai
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($currentPage, 'pemesanan') !== false ? 'active' : ''; ?>" href="pemesanan.php">
                    <i class="bi bi-cart me-2"></i> Pemesanan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($currentPage, 'kontak') !== false ? 'active' : ''; ?>" href="kontak.php">
                    <i class="bi bi-envelope me-2"></i> Pesan Kontak
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($currentPage, 'settings') !== false ? 'active' : ''; ?>" href="settings.php">
                    <i class="bi bi-gear me-2"></i> Pengaturan
                </a>
            </li>
            <li class="nav-item mt-3">
                <a class="nav-link" href="../index.php" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-2"></i> Lihat Website
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="logout.php">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <button class="btn btn-link d-md-none" type="button" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="ms-auto">
                <span class="navbar-text">
                    <i class="bi bi-person-circle me-2"></i>
                    <?php echo htmlspecialchars($currentAdmin['full_name'] ?? $currentAdmin['username']); ?>
                    <small class="text-muted">(<?php echo htmlspecialchars($currentAdmin['role']); ?>)</small>
                </span>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

