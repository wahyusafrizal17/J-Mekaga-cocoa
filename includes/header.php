<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo isset($pageTitle) ? $pageTitle : 'Mega Kayan Ganesha'; ?></title>
  <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Mega Kayan Ganesha - Perusahaan terpercaya dengan lini bisnis Mekaga Gadai, Mekaga Cocoa, dan Mekaga Farm'; ?>">
  <meta name="keywords" content="<?php echo isset($pageKeywords) ? $pageKeywords : 'Mega Kayan Ganesha, Mekaga Gadai, Mekaga Cocoa, Mekaga Farm'; ?>">

  <meta name="robots" content="noindex, nofollow">

  <!-- Favicons -->
  <link href="https://bootstrapmade.com/content/demo/iLanding/assets/img/favicon.png" rel="icon">
  <link href="https://bootstrapmade.com/content/demo/iLanding/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/aos.css" rel="stylesheet">
  <link href="assets/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/css/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt="Mega Kayan Ganesha"> -->
        <h1 class="sitename">Mega Kayan Ganesha</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : ''; ?>>Beranda</a></li>
          <li class="dropdown"><a href="#"><span>Tentang Kami</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="tentang-kami.php#sejarah">Sejarah & Filosofi</a></li>
              <li><a href="tentang-kami.php#struktur">Struktur Organisasi</a></li>
              <li><a href="tentang-kami.php#visi-misi">Visi & Misi</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Lini Bisnis</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li class="dropdown"><a href="#"><span>Mekaga Gadai</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="lini-bisnis.php#mekaga-gadai-profil">Profil & Layanan</a></li>
                  <li><a href="lini-bisnis.php#mekaga-gadai-form">Form Pengajuan Gadai Online</a></li>
                  <li><a href="lini-bisnis.php#mekaga-gadai-simulasi">Simulasi Gadai</a></li>
                  <li><a href="lini-bisnis.php#mekaga-gadai-kontak">Kontak Cabang</a></li>
                </ul>
              </li>
              <li class="dropdown"><a href="#"><span>Mekaga Cocoa</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="lini-bisnis.php#mekaga-cocoa-produk">Tentang Produk Kakao</a></li>
                  <li><a href="lini-bisnis.php#mekaga-cocoa-galeri">Galeri Produksi</a></li>
                  <li><a href="lini-bisnis.php#mekaga-cocoa-testimoni">Testimoni Pelanggan</a></li>
                </ul>
              </li>
              <li class="dropdown"><a href="#"><span>Mekaga Farm</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="lini-bisnis.php#mekaga-farm-tentang">Tentang Kegiatan Pertanian</a></li>
                  <li><a href="lini-bisnis.php#mekaga-farm-produk">Produk Hasil Tani</a></li>
                  <li><a href="lini-bisnis.php#mekaga-farm-order">Pemesanan / Kerjasama</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Berita & Publikasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="berita.php#artikel">Berita</a></li>
              <li><a href="berita.php#csr">CSR & Kegiatan Sosial</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Karier</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="karier.php#lowongan">Lowongan Pekerjaan</a></li>
              <li><a href="karier.php#formulir">Formulir Lamaran</a></li>
              <li><a href="karier.php#budaya">Budaya Kerja</a></li>
            </ul>
          </li>
          <li><a href="kontak.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'kontak.php') ? 'class="active"' : ''; ?>>Kontak Kami</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="kontak.php">Hubungi Kami</a>

    </div>
  </header>

  <main class="main">

