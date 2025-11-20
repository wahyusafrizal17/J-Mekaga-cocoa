<?php
$pageTitle = "Karier - Mega Kayan Ganesha";
$pageDescription = "Bergabunglah dengan tim profesional Mega Kayan Ganesha. Lihat lowongan pekerjaan dan peluang karier terbaru";
$pageKeywords = "Karier, Lowongan Kerja, Rekrutmen, Budaya Kerja, Mega Kayan Ganesha";
include 'includes/header.php';
require_once __DIR__ . '/includes/functions.php';

// Get lowongan from database
$lowongans = getLowongan();
?>

    <!-- Page Header -->
    <section class="page-header section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-title">Karier</h1>
            <p class="page-description">Bergabunglah dengan tim profesional kami</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Lowongan Pekerjaan Section -->
    <section id="lowongan" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title">
          <h2>Lowongan Pekerjaan</h2>
          <p>Peluang karier yang tersedia di Mega Kayan Ganesha</p>
        </div>

        <div class="row gy-4 mt-4">
          <?php if (empty($lowongans)): ?>
            <div class="col-12">
              <div class="alert alert-info">Saat ini tidak ada lowongan pekerjaan yang tersedia.</div>
            </div>
          <?php else: ?>
            <?php 
            $delay = 100;
            foreach ($lowongans as $lowongan): 
            ?>
              <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="service-card d-flex flex-column h-100">
                  <div class="icon flex-shrink-0 mb-3">
                    <i class="bi bi-briefcase"></i>
                  </div>
                  <div>
                    <h3><?php echo htmlspecialchars($lowongan['posisi']); ?></h3>
                    <p class="text-muted small"><?php echo htmlspecialchars($lowongan['divisi']); ?> | <?php echo htmlspecialchars($lowongan['lokasi']); ?></p>
                    <p><?php echo htmlspecialchars(truncate($lowongan['deskripsi'], 150)); ?></p>
                    <ul class="feature-list mt-3">
                      <?php 
                      $kualifikasi = explode("\n", $lowongan['kualifikasi']);
                      foreach (array_slice($kualifikasi, 0, 3) as $kual): 
                        if (trim($kual)):
                      ?>
                        <li><i class="bi bi-check-circle-fill"></i> <?php echo htmlspecialchars(trim($kual)); ?></li>
                      <?php 
                        endif;
                      endforeach; 
                      ?>
                    </ul>
                    <a href="#formulir" class="read-more mt-3" onclick="document.getElementById('posisi').value='<?php echo htmlspecialchars($lowongan['posisi']); ?>'">Lamar Sekarang <i class="bi bi-arrow-right"></i></a>
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

    <!-- Formulir Lamaran Section -->
    <section id="formulir" class="section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Formulir Lamaran</h2>
          <p>Isi formulir di bawah ini untuk melamar posisi yang tersedia</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <form action="#" method="post" class="php-email-form" enctype="multipart/form-data" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="col-md-6">
                  <input type="tel" class="form-control" name="telepon" placeholder="Nomor Telepon" required>
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="posisi" name="posisi" placeholder="Posisi yang Dilamar" required>
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="pendidikan" placeholder="Pendidikan Terakhir" required>
                </div>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="pengalaman" placeholder="Tahun Pengalaman" required>
                </div>
                <div class="col-12">
                  <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat Lengkap" required></textarea>
                </div>
                <div class="col-12">
                  <textarea class="form-control" name="motivasi" rows="4" placeholder="Motivasi & Alasan Melamar" required></textarea>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Upload CV/Resume (PDF, Max 2MB)</label>
                  <input type="file" class="form-control" name="cv" accept=".pdf,.doc,.docx" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Upload Foto (JPG, Max 1MB)</label>
                  <input type="file" class="form-control" name="foto" accept="image/jpeg,image/jpg,image/png">
                </div>
                <div class="col-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Lamaran Anda telah terkirim. Terima kasih!</div>
                  <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Budaya Kerja Section -->
    <section id="budaya" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title">
          <h2>Budaya Kerja</h2>
          <p>Nilai-nilai yang kami junjung tinggi di Mega Kayan Ganesha</p>
        </div>

        <div class="row gy-4 mt-4">
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="feature-box">
              <i class="bi bi-heart"></i>
              <h4>Integritas</h4>
              <p>Kami menjunjung tinggi kejujuran, transparansi, dan etika dalam setiap tindakan dan keputusan bisnis.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="feature-box">
              <i class="bi bi-lightbulb"></i>
              <h4>Inovasi</h4>
              <p>Kami mendorong kreativitas dan inovasi untuk terus berkembang dan memberikan solusi terbaik.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="feature-box">
              <i class="bi bi-people"></i>
              <h4>Kerjasama Tim</h4>
              <p>Kami percaya bahwa kerja sama tim yang solid adalah kunci kesuksesan bersama.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
            <div class="feature-box">
              <i class="bi bi-trophy"></i>
              <h4>Komitmen terhadap Kualitas</h4>
              <p>Kami selalu berusaha memberikan yang terbaik dalam setiap produk dan layanan.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="500">
            <div class="feature-box">
              <i class="bi bi-person-check"></i>
              <h4>Pengembangan Diri</h4>
              <p>Kami mendukung pengembangan karir dan kemampuan setiap karyawan melalui pelatihan dan mentoring.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="600">
            <div class="feature-box">
              <i class="bi bi-hand-thumbs-up"></i>
              <h4>Keseimbangan Hidup</h4>
              <p>Kami menghargai keseimbangan antara pekerjaan dan kehidupan pribadi untuk kesejahteraan karyawan.</p>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="info-box h-100">
              <h3>Fasilitas & Benefit</h3>
              <ul class="feature-list mt-3">
                <li><i class="bi bi-check-circle-fill"></i> Gaji kompetitif sesuai industri</li>
                <li><i class="bi bi-check-circle-fill"></i> Tunjangan kesehatan dan asuransi</li>
                <li><i class="bi bi-check-circle-fill"></i> Program pelatihan dan pengembangan</li>
                <li><i class="bi bi-check-circle-fill"></i> Bonus dan insentif kinerja</li>
                <li><i class="bi bi-check-circle-fill"></i> Lingkungan kerja yang nyaman</li>
                <li><i class="bi bi-check-circle-fill"></i> Kesempatan promosi karir</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="info-box h-100">
              <h3>Proses Rekrutmen</h3>
              <ol class="mt-3">
                <li class="mb-2"><strong>Submit Lamaran:</strong> Kirim CV dan dokumen pendukung melalui formulir online</li>
                <li class="mb-2"><strong>Seleksi Administrasi:</strong> Tim HR akan meninjau kualifikasi dan pengalaman</li>
                <li class="mb-2"><strong>Wawancara:</strong> Tahap wawancara dengan tim HR dan user</li>
                <li class="mb-2"><strong>Assessment:</strong> Tes kemampuan dan psikotes (jika diperlukan)</li>
                <li class="mb-2"><strong>Penawaran:</strong> Penawaran kerja dan negosiasi gaji</li>
                <li><strong>Onboarding:</strong> Proses orientasi dan integrasi ke tim</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </section>

<?php include 'includes/footer.php'; ?>

