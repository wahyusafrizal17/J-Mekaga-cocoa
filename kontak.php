<?php
$pageTitle = "Kontak Kami - Mega Kayan Ganesha";
$pageDescription = "Hubungi Mega Kayan Ganesha untuk pertanyaan, informasi, atau kerjasama bisnis";
$pageKeywords = "Kontak, Hubungi Kami, Lokasi, Kantor Cabang, Media Sosial, WhatsApp, Mega Kayan Ganesha";
include 'includes/header.php';
?>

    <!-- Page Header -->
    <section class="page-header section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-title">Kontak Kami</h1>
            <p class="page-description">Kami siap membantu Anda</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Hubungi Kami</h2>
          <p>Jangan ragu untuk menghubungi kami jika ada pertanyaan atau informasi yang Anda butuhkan</p>
        </div>

        <div class="row g-4 g-lg-5 mt-4">
          <div class="col-lg-5">
            <div class="info-box" data-aos="fade-up" data-aos-delay="200">
              <h3>Informasi Kontak</h3>
              <p>Kantor Pusat Mega Kayan Ganesha siap melayani Anda dengan profesional dan ramah.</p>

              <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="content">
                  <h4>Alamat Kantor Pusat</h4>
                  <p>Jl. Raya Pusat No. 123</p>
                  <p>Jakarta Pusat 10110, Indonesia</p>
                </div>
              </div>

              <div class="info-item" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-box">
                  <i class="bi bi-telephone"></i>
                </div>
                <div class="content">
                  <h4>Telepon</h4>
                  <p>+62 21 1234 5678</p>
                  <p>+62 21 1234 5679</p>
                </div>
              </div>

              <div class="info-item" data-aos="fade-up" data-aos-delay="500">
                <div class="icon-box">
                  <i class="bi bi-envelope"></i>
                </div>
                <div class="content">
                  <h4>Email</h4>
                  <p><a href="mailto:info@megakayanganesha.com">info@megakayanganesha.com</a></p>
                  <p><a href="mailto:cs@megakayanganesha.com">cs@megakayanganesha.com</a></p>
                </div>
              </div>

              <div class="info-item" data-aos="fade-up" data-aos-delay="600">
                <div class="icon-box">
                  <i class="bi bi-clock"></i>
                </div>
                <div class="content">
                  <h4>Jam Operasional</h4>
                  <p>Senin - Jumat: 08:00 - 17:00 WIB</p>
                  <p>Sabtu: 08:00 - 13:00 WIB</p>
                  <p>Minggu: Tutup</p>
                </div>
              </div>

              <div class="social-links d-flex mt-4" data-aos="fade-up" data-aos-delay="700">
                <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                <a href="https://wa.me/621234567890" title="WhatsApp" target="_blank"><i class="bi bi-whatsapp"></i></a>
                <a href="#" title="Twitter"><i class="bi bi-twitter-x"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
              <h3>Formulir Pesan / Pertanyaan</h3>
              <p>Isi formulir di bawah ini untuk mengirimkan pesan atau pertanyaan kepada kami.</p>

              <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                <div class="row gy-4">

                  <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
                  </div>

                  <div class="col-md-6">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                  </div>

                  <div class="col-md-6">
                    <input type="tel" class="form-control" name="phone" placeholder="Nomor Telepon" required>
                  </div>

                  <div class="col-md-6">
                    <select class="form-control" name="subject" required>
                      <option value="">Pilih Subjek</option>
                      <option value="informasi">Informasi Umum</option>
                      <option value="mekaga-gadai">Mekaga Gadai</option>
                      <option value="mekaga-cocoa">Mekaga Cocoa</option>
                      <option value="mekaga-farm">Mekaga Farm</option>
                      <option value="kerjasama">Kerjasama Bisnis</option>
                      <option value="lainnya">Lainnya</option>
                    </select>
                  </div>

                  <div class="col-12">
                    <textarea class="form-control" name="message" rows="6" placeholder="Pesan / Pertanyaan" required></textarea>
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
      </div>
    </section>

    <!-- Lokasi & Kantor Cabang Section -->
    <section id="lokasi-cabang" class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Lokasi & Kantor Cabang</h2>
          <p>Kunjungi kantor cabang kami di berbagai kota</p>
        </div>

        <div class="row gy-4 mt-4">
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="info-box h-100">
              <div class="icon-box mb-3">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <h4>Kantor Pusat Jakarta</h4>
              <p><strong>Alamat:</strong><br>
              Jl. Raya Pusat No. 123<br>
              Jakarta Pusat 10110</p>
              <p><strong>Telepon:</strong> (021) 1234-5678</p>
              <p><strong>Email:</strong> jakarta@megakayanganesha.com</p>
              <a href="https://maps.google.com" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Lihat di Peta</a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="info-box h-100">
              <div class="icon-box mb-3">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <h4>Cabang Bandung</h4>
              <p><strong>Alamat:</strong><br>
              Jl. Dago No. 456<br>
              Bandung 40135</p>
              <p><strong>Telepon:</strong> (022) 2345-6789</p>
              <p><strong>Email:</strong> bandung@megakayanganesha.com</p>
              <a href="https://maps.google.com" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Lihat di Peta</a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="info-box h-100">
              <div class="icon-box mb-3">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <h4>Cabang Surabaya</h4>
              <p><strong>Alamat:</strong><br>
              Jl. Pemuda No. 789<br>
              Surabaya 60271</p>
              <p><strong>Telepon:</strong> (031) 3456-7890</p>
              <p><strong>Email:</strong> surabaya@megakayanganesha.com</p>
              <a href="https://maps.google.com" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Lihat di Peta</a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="info-box h-100">
              <div class="icon-box mb-3">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <h4>Cabang Yogyakarta</h4>
              <p><strong>Alamat:</strong><br>
              Jl. Malioboro No. 321<br>
              Yogyakarta 55213</p>
              <p><strong>Telepon:</strong> (0274) 4567-8901</p>
              <p><strong>Email:</strong> yogyakarta@megakayanganesha.com</p>
              <a href="https://maps.google.com" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Lihat di Peta</a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="info-box h-100">
              <div class="icon-box mb-3">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <h4>Cabang Medan</h4>
              <p><strong>Alamat:</strong><br>
              Jl. Gatot Subroto No. 654<br>
              Medan 20112</p>
              <p><strong>Telepon:</strong> (061) 5678-9012</p>
              <p><strong>Email:</strong> medan@megakayanganesha.com</p>
              <a href="https://maps.google.com" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Lihat di Peta</a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="info-box h-100">
              <div class="icon-box mb-3">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <h4>Cabang Makassar</h4>
              <p><strong>Alamat:</strong><br>
              Jl. Ahmad Yani No. 987<br>
              Makassar 90231</p>
              <p><strong>Telepon:</strong> (0411) 6789-0123</p>
              <p><strong>Email:</strong> makassar@megakayanganesha.com</p>
              <a href="https://maps.google.com" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Lihat di Peta</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Media Sosial & WhatsApp Section -->
    <section id="media-sosial" class="section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center">
          <h2>Media Sosial & WhatsApp</h2>
          <p>Ikuti dan hubungi kami melalui media sosial</p>
        </div>

        <div class="row gy-4 mt-4 justify-content-center">
          <div class="col-lg-3 col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="feature-box text-center">
              <a href="https://wa.me/621234567890" target="_blank" class="text-decoration-none">
                <i class="bi bi-whatsapp" style="font-size: 3rem; color: #25D366;"></i>
                <h4 class="mt-3">WhatsApp</h4>
                <p>+62 812-3456-7890</p>
                <p class="small">Chat langsung dengan customer service kami</p>
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="feature-box text-center">
              <a href="#" target="_blank" class="text-decoration-none">
                <i class="bi bi-instagram" style="font-size: 3rem; color: #E4405F;"></i>
                <h4 class="mt-3">Instagram</h4>
                <p>@megakayanganesha</p>
                <p class="small">Ikuti update terbaru dari kami</p>
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="feature-box text-center">
              <a href="#" target="_blank" class="text-decoration-none">
                <i class="bi bi-facebook" style="font-size: 3rem; color: #1877F2;"></i>
                <h4 class="mt-3">Facebook</h4>
                <p>Mega Kayan Ganesha</p>
                <p class="small">Bergabung dengan komunitas kami</p>
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="400">
            <div class="feature-box text-center">
              <a href="#" target="_blank" class="text-decoration-none">
                <i class="bi bi-linkedin" style="font-size: 3rem; color: #0077B5;"></i>
                <h4 class="mt-3">LinkedIn</h4>
                <p>Mega Kayan Ganesha</p>
                <p class="small">Koneksi profesional dan karier</p>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

<?php include 'includes/footer.php'; ?>

