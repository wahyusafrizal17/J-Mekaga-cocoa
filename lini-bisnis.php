<?php
$pageTitle = "Lini Bisnis - Mega Kayan Ganesha";
$pageDescription = "Jelajahi lini bisnis kami: Mekaga Gadai, Mekaga Cocoa, dan Mekaga Farm";
$pageKeywords = "Lini Bisnis, Mekaga Gadai, Mekaga Cocoa, Mekaga Farm, Gadai Online, Produk Kakao, Hasil Tani";
include 'includes/header.php';
require_once __DIR__ . '/includes/functions.php';

// Get testimonials for Mekaga Cocoa
$testimonials = getTestimonials(null, 'mekaga_cocoa');
?>

    <!-- Page Header -->
    <section class="page-header section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-title">Lini Bisnis</h1>
            <p class="page-description">Tiga pilar utama bisnis kami</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Mekaga Gadai Section -->
    <section id="mekaga-gadai-profil" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 align-items-center">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <span class="about-meta">LINI BISNIS</span>
            <h2 class="about-title">Mekaga Gadai</h2>
            <h3>Profil & Layanan</h3>
            <p class="about-description">
              Mekaga Gadai adalah layanan gadai yang memberikan solusi keuangan cepat dan mudah bagi masyarakat. Kami menyediakan layanan gadai dengan proses yang transparan, aman, dan profesional.
            </p>
            <div class="row feature-list-wrapper mt-4">
              <div class="col-md-6">
                <ul class="feature-list">
                  <li><i class="bi bi-check-circle-fill"></i> Proses cepat dan mudah</li>
                  <li><i class="bi bi-check-circle-fill"></i> Penilaian barang yang adil</li>
                  <li><i class="bi bi-check-circle-fill"></i> Bunga kompetitif</li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="feature-list">
                  <li><i class="bi bi-check-circle-fill"></i> Keamanan terjamin</li>
                  <li><i class="bi bi-check-circle-fill"></i> Layanan pelanggan 24/7</li>
                  <li><i class="bi bi-check-circle-fill"></i> Berbagai jenis barang diterima</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <img src="https://bootstrapmade.com/content/demo/iLanding/assets/img/features-illustration-1.webp" alt="Mekaga Gadai" class="img-fluid rounded-4">
          </div>
        </div>
      </div>
    </section>

    <!-- Form Pengajuan Gadai Online -->
    <section id="mekaga-gadai-form" class="section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Form Pengajuan Gadai Online</h2>
          <p>Ajukan gadai Anda secara online dengan mudah</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <form action="#" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="col-md-6">
                  <input type="tel" class="form-control" name="telepon" placeholder="Nomor Telepon" required>
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="col-md-6">
                  <select class="form-control" name="jenis_barang" required>
                    <option value="">Pilih Jenis Barang</option>
                    <option value="emas">Emas</option>
                    <option value="elektronik">Elektronik</option>
                    <option value="kendaraan">Kendaraan</option>
                    <option value="lainnya">Lainnya</option>
                  </select>
                </div>
                <div class="col-12">
                  <textarea class="form-control" name="deskripsi" rows="4" placeholder="Deskripsi Barang" required></textarea>
                </div>
                <div class="col-12">
                  <input type="file" class="form-control" name="foto_barang" accept="image/*" placeholder="Upload Foto Barang">
                </div>
                <div class="col-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Pengajuan Anda telah terkirim. Terima kasih!</div>
                  <button type="submit" class="btn btn-primary">Ajukan Gadai</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Simulasi Gadai -->
    <section id="mekaga-gadai-simulasi" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Simulasi Gadai</h2>
          <p>Hitung estimasi nilai gadai Anda</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="pricing-card">
              <form id="simulasi-form">
                <div class="mb-3">
                  <label class="form-label">Jenis Barang</label>
                  <select class="form-control" id="jenis-barang" required>
                    <option value="">Pilih Jenis Barang</option>
                    <option value="emas">Emas</option>
                    <option value="elektronik">Elektronik</option>
                    <option value="kendaraan">Kendaraan</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Nilai Barang (Rp)</label>
                  <input type="number" class="form-control" id="nilai-barang" placeholder="Masukkan nilai barang" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Jangka Waktu (Bulan)</label>
                  <select class="form-control" id="jangka-waktu" required>
                    <option value="1">1 Bulan</option>
                    <option value="3">3 Bulan</option>
                    <option value="6">6 Bulan</option>
                    <option value="12">12 Bulan</option>
                  </select>
                </div>
                <button type="button" class="btn btn-primary w-100" onclick="hitungSimulasi()">Hitung Simulasi</button>
                <div id="hasil-simulasi" class="mt-4" style="display:none;">
                  <h4>Hasil Simulasi:</h4>
                  <p>Estimasi Nilai Gadai: <strong id="nilai-gadai"></strong></p>
                  <p>Bunga: <strong id="bunga"></strong></p>
                  <p>Total yang Diterima: <strong id="total-diterima"></strong></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Kontak Cabang -->
    <section id="mekaga-gadai-kontak" class="section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Kontak Cabang Mekaga Gadai</h2>
          <p>Kunjungi cabang terdekat untuk layanan langsung</p>
        </div>

        <div class="row gy-4 mt-4">
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="info-box h-100">
              <div class="icon-box mb-3">
                <i class="bi bi-geo-alt"></i>
              </div>
              <h4>Cabang Pusat</h4>
              <p>Jl. Raya Pusat No. 123<br>Jakarta Pusat 10110</p>
              <p><strong>Telp:</strong> (021) 1234-5678</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="info-box h-100">
              <div class="icon-box mb-3">
                <i class="bi bi-geo-alt"></i>
              </div>
              <h4>Cabang Bandung</h4>
              <p>Jl. Dago No. 456<br>Bandung 40135</p>
              <p><strong>Telp:</strong> (022) 2345-6789</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="info-box h-100">
              <div class="icon-box mb-3">
                <i class="bi bi-geo-alt"></i>
              </div>
              <h4>Cabang Surabaya</h4>
              <p>Jl. Pemuda No. 789<br>Surabaya 60271</p>
              <p><strong>Telp:</strong> (031) 3456-7890</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Mekaga Cocoa Section -->
    <section id="mekaga-cocoa-produk" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 align-items-center">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <span class="about-meta">LINI BISNIS</span>
            <h2 class="about-title">Mekaga Cocoa</h2>
            <h3>Tentang Produk Kakao</h3>
            <p class="about-description">
              Mekaga Cocoa menghadirkan produk kakao berkualitas tinggi yang diproses dengan teknologi modern dan standar kualitas internasional. Kami berkomitmen untuk menghasilkan produk kakao terbaik dari biji kakao pilihan.
            </p>
            <div class="row feature-list-wrapper mt-4">
              <div class="col-md-6">
                <ul class="feature-list">
                  <li><i class="bi bi-check-circle-fill"></i> Biji kakao premium</li>
                  <li><i class="bi bi-check-circle-fill"></i> Proses fermentasi optimal</li>
                  <li><i class="bi bi-check-circle-fill"></i> Kualitas ekspor</li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="feature-list">
                  <li><i class="bi bi-check-circle-fill"></i> Sertifikasi organik</li>
                  <li><i class="bi bi-check-circle-fill"></i> Pengemasan higienis</li>
                  <li><i class="bi bi-check-circle-fill"></i> Harga kompetitif</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <img src="https://bootstrapmade.com/content/demo/iLanding/assets/img/features-illustration-2.webp" alt="Mekaga Cocoa" class="img-fluid rounded-4">
          </div>
        </div>
      </div>
    </section>

    <!-- Galeri Produksi -->
    <section id="mekaga-cocoa-galeri" class="section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Galeri Produksi</h2>
          <p>Lihat proses produksi kakao kami</p>
        </div>

        <div class="row gy-4 mt-4">
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="gallery-item">
              <img src="https://bootstrapmade.com/content/demo/iLanding/assets/img/about-2.webp" alt="Produksi Kakao" class="img-fluid rounded">
            </div>
          </div>
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="gallery-item">
              <img src="https://bootstrapmade.com/content/demo/iLanding/assets/img/about-5.webp" alt="Produksi Kakao" class="img-fluid rounded">
            </div>
          </div>
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="gallery-item">
              <img src="https://bootstrapmade.com/content/demo/iLanding/assets/img/features-illustration-3.webp" alt="Produksi Kakao" class="img-fluid rounded">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Pemesanan Online -->
    <section id="mekaga-cocoa-order" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Pemesanan Online</h2>
          <p>Pesan produk kakao berkualitas langsung dari sini</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <form action="#" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                </div>
                <div class="col-md-6">
                  <input type="tel" class="form-control" name="telepon" placeholder="Nomor Telepon" required>
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="col-md-6">
                  <select class="form-control" name="produk" required>
                    <option value="">Pilih Produk</option>
                    <option value="biji-kakao">Biji Kakao Premium</option>
                    <option value="bubuk-kakao">Bubuk Kakao</option>
                    <option value="cocoa-butter">Cocoa Butter</option>
                  </select>
                </div>
                <div class="col-12">
                  <input type="number" class="form-control" name="jumlah" placeholder="Jumlah (kg)" required>
                </div>
                <div class="col-12">
                  <textarea class="form-control" name="alamat" rows="4" placeholder="Alamat Pengiriman" required></textarea>
                </div>
                <div class="col-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Pesanan Anda telah terkirim. Terima kasih!</div>
                  <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimoni Pelanggan -->
    <section id="mekaga-cocoa-testimoni" class="section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Testimoni Pelanggan</h2>
          <p>Apa kata pelanggan tentang produk kami</p>
        </div>

        <div class="row g-4 mt-4">
          <?php if (empty($testimonials)): ?>
            <div class="col-12">
              <div class="alert alert-info text-center">Belum ada testimoni yang tersedia.</div>
            </div>
          <?php else: ?>
            <?php 
            $delay = 100;
            foreach ($testimonials as $testimoni): 
            ?>
              <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="testimonial-item">
                  <?php if ($testimoni['foto']): ?>
                    <img src="uploads/testimoni/<?php echo htmlspecialchars($testimoni['foto']); ?>" class="testimonial-img" alt="<?php echo htmlspecialchars($testimoni['nama']); ?>">
                  <?php else: ?>
                    <img src="https://bootstrapmade.com/content/demo/iLanding/assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="<?php echo htmlspecialchars($testimoni['nama']); ?>">
                  <?php endif; ?>
                  <h3><?php echo htmlspecialchars($testimoni['nama']); ?></h3>
                  <h4><?php echo htmlspecialchars($testimoni['jabatan'] ?: ($testimoni['perusahaan'] ?: '')); ?></h4>
                  <?php if ($testimoni['perusahaan'] && $testimoni['jabatan']): ?>
                    <p class="text-muted small"><?php echo htmlspecialchars($testimoni['perusahaan']); ?></p>
                  <?php endif; ?>
                  <div class="stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                      <i class="bi bi-star<?php echo $i <= $testimoni['rating'] ? '-fill' : ''; ?>"></i>
                    <?php endfor; ?>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    <span><?php echo htmlspecialchars($testimoni['testimoni']); ?></span>
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
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

    <!-- Mekaga Farm Section -->
    <section id="mekaga-farm-tentang" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 align-items-center">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <span class="about-meta">LINI BISNIS</span>
            <h2 class="about-title">Mekaga Farm</h2>
            <h3>Tentang Kegiatan Pertanian</h3>
            <p class="about-description">
              Mekaga Farm mengembangkan kegiatan pertanian berkelanjutan dengan menerapkan teknologi modern dan praktik pertanian yang ramah lingkungan. Kami berkomitmen untuk menghasilkan produk pertanian berkualitas tinggi.
            </p>
            <div class="row feature-list-wrapper mt-4">
              <div class="col-md-6">
                <ul class="feature-list">
                  <li><i class="bi bi-check-circle-fill"></i> Pertanian organik</li>
                  <li><i class="bi bi-check-circle-fill"></i> Teknologi modern</li>
                  <li><i class="bi bi-check-circle-fill"></i> Ramah lingkungan</li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="feature-list">
                  <li><i class="bi bi-check-circle-fill"></i> Kualitas premium</li>
                  <li><i class="bi bi-check-circle-fill"></i> Berkelanjutan</li>
                  <li><i class="bi bi-check-circle-fill"></i> Dukungan petani lokal</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <img src="https://bootstrapmade.com/content/demo/iLanding/assets/img/features-illustration-3.webp" alt="Mekaga Farm" class="img-fluid rounded-4">
          </div>
        </div>
      </div>
    </section>

    <!-- Produk Hasil Tani -->
    <section id="mekaga-farm-produk" class="section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Produk Hasil Tani</h2>
          <p>Produk pertanian berkualitas dari Mekaga Farm</p>
        </div>

        <div class="row gy-4 mt-4">
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="feature-box">
              <i class="bi bi-flower1"></i>
              <h4>Sayuran Organik</h4>
              <p>Berbagai jenis sayuran organik segar dan sehat</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="feature-box">
              <i class="bi bi-tree"></i>
              <h4>Buah-buahan</h4>
              <p>Buah-buahan segar dengan kualitas premium</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="feature-box">
              <i class="bi bi-seedling"></i>
              <h4>Bibit Unggul</h4>
              <p>Bibit tanaman berkualitas untuk petani</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Pemesanan / Kerjasama -->
    <section id="mekaga-farm-order" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Pemesanan / Kerjasama</h2>
          <p>Hubungi kami untuk pemesanan atau kerjasama bisnis</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <form action="#" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap / Perusahaan" required>
                </div>
                <div class="col-md-6">
                  <input type="tel" class="form-control" name="telepon" placeholder="Nomor Telepon" required>
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="col-md-6">
                  <select class="form-control" name="tipe" required>
                    <option value="">Pilih Tipe</option>
                    <option value="pemesanan">Pemesanan Produk</option>
                    <option value="kerjasama">Kerjasama Bisnis</option>
                  </select>
                </div>
                <div class="col-12">
                  <textarea class="form-control" name="pesan" rows="6" placeholder="Pesan / Detail Pemesanan" required></textarea>
                </div>
                <div class="col-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Pesan Anda telah terkirim. Terima kasih!</div>
                  <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <script>
    function hitungSimulasi() {
      const jenisBarang = document.getElementById('jenis-barang').value;
      const nilaiBarang = parseFloat(document.getElementById('nilai-barang').value);
      const jangkaWaktu = parseInt(document.getElementById('jangka-waktu').value);

      if (!jenisBarang || !nilaiBarang || !jangkaWaktu) {
        alert('Mohon lengkapi semua field');
        return;
      }

      // Persentase nilai gadai berdasarkan jenis barang
      const persentaseGadai = {
        'emas': 0.85,
        'elektronik': 0.60,
        'kendaraan': 0.70
      };

      // Bunga per bulan
      const bungaPerBulan = 0.02; // 2% per bulan

      const persentase = persentaseGadai[jenisBarang] || 0.70;
      const estimasiNilaiGadai = nilaiBarang * persentase;
      const totalBunga = estimasiNilaiGadai * bungaPerBulan * jangkaWaktu;
      const totalDiterima = estimasiNilaiGadai - totalBunga;

      document.getElementById('nilai-gadai').textContent = 'Rp ' + estimasiNilaiGadai.toLocaleString('id-ID');
      document.getElementById('bunga').textContent = 'Rp ' + totalBunga.toLocaleString('id-ID') + ' (' + (bungaPerBulan * 100) + '% per bulan)';
      document.getElementById('total-diterima').textContent = 'Rp ' + totalDiterima.toLocaleString('id-ID');
      document.getElementById('hasil-simulasi').style.display = 'block';
    }
    </script>

<?php include 'includes/footer.php'; ?>

