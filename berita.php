<?php
$pageTitle = "Berita & Publikasi - Mega Kayan Ganesha";
$pageDescription = "Baca artikel, jurnal, dan kegiatan CSR dari Mega Kayan Ganesha";
$pageKeywords = "Berita, Artikel, Jurnal, Inovasi, CSR, Kegiatan Sosial, Mega Kayan Ganesha";
include 'includes/header.php';
require_once __DIR__ . '/includes/functions.php';

// Get data from database
$artikels = getArticles();
$csrs = getCSR();
?>

    <!-- Page Header -->
    <section class="page-header section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-title">Berita & Publikasi</h1>
            <p class="page-description">Informasi terbaru dari Mega Kayan Ganesha</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Berita Section -->
    <section id="artikel" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title">
          <h2>Berita</h2>
          <p>Berita dan artikel terkini seputar perusahaan</p>
        </div>

        <div class="row gy-4 mt-4">
          <?php if (empty($artikels)): ?>
            <div class="col-12">
              <div class="alert alert-info">Belum ada artikel yang dipublikasikan.</div>
            </div>
          <?php else: ?>
            <?php 
            $delay = 100;
            foreach ($artikels as $artikel): 
            ?>
              <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="service-card d-flex flex-column h-100">
                  <div class="icon flex-shrink-0 mb-3">
                    <i class="bi bi-newspaper"></i>
                  </div>
                  <div>
                    <h3><?php echo htmlspecialchars($artikel['judul']); ?></h3>
                    <p class="text-muted small"><?php echo formatDateID($artikel['published_at'] ?: $artikel['created_at']); ?></p>
                    <p><?php echo htmlspecialchars(truncate($artikel['excerpt'] ?: $artikel['konten'], 150)); ?></p>
                    <a href="artikel-detail.php?slug=<?php echo htmlspecialchars($artikel['slug']); ?>" class="read-more">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            <?php 
              $delay += 100;
            endforeach; 
            ?>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- CSR & Kegiatan Sosial Section -->
    <section id="csr" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title">
          <h2>CSR & Kegiatan Sosial</h2>
          <p>Kontribusi kami untuk masyarakat dan lingkungan</p>
        </div>

        <div class="row gy-4 mt-4">
          <?php if (empty($csrs)): ?>
            <div class="col-12">
              <div class="alert alert-info">Belum ada kegiatan CSR yang dipublikasikan.</div>
            </div>
          <?php else: ?>
            <?php 
            $delay = 100;
            foreach ($csrs as $csr): 
              $icons = [
                'beasiswa' => 'bi-heart',
                'lingkungan' => 'bi-tree',
                'kesehatan' => 'bi-hospital',
                'bencana' => 'bi-house-heart',
                'pendidikan' => 'bi-book',
                'lainnya' => 'bi-people'
              ];
              $icon = $icons[$csr['kategori']] ?? 'bi-heart';
            ?>
              <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
                <div class="feature-box">
                  <i class="bi <?php echo $icon; ?>"></i>
                  <h4><?php echo htmlspecialchars($csr['judul']); ?></h4>
                  <p><?php echo htmlspecialchars(truncate($csr['deskripsi'], 120)); ?></p>
                </div>
              </div>
            <?php 
              $delay += 100;
            endforeach; 
            ?>
          <?php endif; ?>
        </div>

        <?php 
        // Get latest 2 CSR with images for featured section
        $featuredCSR = getCSR(2);
        if (!empty($featuredCSR)):
        ?>
        <div class="row gy-4 mt-5">
          <?php 
          $delay = 100;
          foreach ($featuredCSR as $csr): 
            if (!$csr['gambar']) continue;
          ?>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
              <div class="info-box h-100">
                <img src="uploads/csr/<?php echo htmlspecialchars($csr['gambar']); ?>" alt="<?php echo htmlspecialchars($csr['judul']); ?>" class="img-fluid rounded mb-3">
                <h4><?php echo htmlspecialchars($csr['judul']); ?></h4>
                <p class="text-muted small"><?php echo $csr['tanggal_kegiatan'] ? formatDateID($csr['tanggal_kegiatan']) : formatDateID($csr['published_at'] ?: $csr['created_at']); ?></p>
                <p><?php echo htmlspecialchars(truncate($csr['deskripsi'], 200)); ?></p>
              </div>
            </div>
          <?php 
            $delay += 100;
          endforeach; 
          ?>
        </div>
        <?php endif; ?>
      </div>
    </section>

<?php include 'includes/footer.php'; ?>

