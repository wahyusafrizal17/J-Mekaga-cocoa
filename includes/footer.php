  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.php" class="logo d-flex align-items-center">
            <span class="sitename">Mega Kayan Ganesha</span>
          </a>
          <div class="footer-contact pt-3">
            <?php
            require_once __DIR__ . '/../includes/functions.php';
            $siteAddress = getSetting('site_address', 'Jl. Raya Pusat No. 123, Jakarta Pusat 10110, Indonesia');
            $addressLines = explode(',', $siteAddress);
            foreach ($addressLines as $line) {
              echo '<p>' . htmlspecialchars(trim($line)) . '</p>';
            }
            ?>
            <p class="mt-3"><strong>Phone:</strong> <span><?php echo htmlspecialchars(getSetting('site_phone', '+62 21 1234 5678')); ?></span></p>
            <p><strong>Email:</strong> <span><a href="mailto:<?php echo htmlspecialchars(getSetting('site_email', 'info@megakayanganesha.com')); ?>"><?php echo htmlspecialchars(getSetting('site_email', 'info@megakayanganesha.com')); ?></a></span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <?php if (getSetting('twitter_url')): ?>
              <a href="<?php echo htmlspecialchars(getSetting('twitter_url')); ?>" target="_blank"><i class="bi bi-twitter-x"></i></a>
            <?php endif; ?>
            <?php if (getSetting('facebook_url')): ?>
              <a href="<?php echo htmlspecialchars(getSetting('facebook_url')); ?>" target="_blank"><i class="bi bi-facebook"></i></a>
            <?php endif; ?>
            <?php if (getSetting('instagram_url')): ?>
              <a href="<?php echo htmlspecialchars(getSetting('instagram_url')); ?>" target="_blank"><i class="bi bi-instagram"></i></a>
            <?php endif; ?>
            <?php if (getSetting('linkedin_url')): ?>
              <a href="<?php echo htmlspecialchars(getSetting('linkedin_url')); ?>" target="_blank"><i class="bi bi-linkedin"></i></a>
            <?php endif; ?>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Tautan Berguna</h4>
          <ul>
            <li><a href="index.php">Beranda</a></li>
            <li><a href="tentang-kami.php">Tentang Kami</a></li>
            <li><a href="lini-bisnis.php">Lini Bisnis</a></li>
            <li><a href="berita.php">Berita & Publikasi</a></li>
            <li><a href="karier.php">Karier</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Lini Bisnis</h4>
          <ul>
            <li><a href="lini-bisnis.php#mekaga-gadai-profil">Mekaga Gadai</a></li>
            <li><a href="lini-bisnis.php#mekaga-cocoa-produk">Mekaga Cocoa</a></li>
            <li><a href="lini-bisnis.php#mekaga-farm-tentang">Mekaga Farm</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Informasi</h4>
          <ul>
            <li><a href="tentang-kami.php#sejarah">Sejarah & Filosofi</a></li>
            <li><a href="tentang-kami.php#struktur">Struktur Organisasi</a></li>
            <li><a href="tentang-kami.php#visi-misi">Visi & Misi</a></li>
            <li><a href="berita.php#csr">CSR & Kegiatan Sosial</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Kontak</h4>
          <ul>
            <li><a href="kontak.php">Hubungi Kami</a></li>
            <li><a href="lini-bisnis.php#mekaga-gadai-kontak">Kontak Cabang</a></li>
            <li><a href="karier.php#lowongan">Lowongan Kerja</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Mega Kayan Ganesha</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script src="assets/js/validate.js"></script>
  <script src="assets/js/aos.js"></script>
  <script src="assets/js/glightbox.min.js"></script>
  <script src="assets/js/swiper-bundle.min.js"></script>
  <script src="assets/js/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"68c5ca450bae485a842ff76066d69420","server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>

</html>

