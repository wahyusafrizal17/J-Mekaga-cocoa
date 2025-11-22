<?php
$pageDescription = "Baca artikel lengkap dari Mega Kayan Ganesha";
$pageKeywords = "Artikel, Berita, Publikasi, Mega Kayan Ganesha";
include 'includes/header.php';
require_once __DIR__ . '/includes/functions.php';

// Get slug from URL
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: berita.php');
    exit;
}

// Get article by slug
$artikel = getArticleBySlug($slug);

if (!$artikel) {
    header('Location: berita.php');
    exit;
}

// Update view count
$db = getDB();
$stmt = $db->prepare("UPDATE artikel SET views = views + 1 WHERE id = ?");
$stmt->execute([$artikel['id']]);

// Get author info
$author = null;
if ($artikel['created_by']) {
    $stmt = $db->prepare("SELECT full_name, username FROM admins WHERE id = ?");
    $stmt->execute([$artikel['created_by']]);
    $author = $stmt->fetch();
}

// Get related articles (same category, exclude current)
$relatedArticles = getArticles(3, $artikel['kategori']);
$relatedArticles = array_filter($relatedArticles, function($a) use ($artikel) {
    return $a['id'] != $artikel['id'];
});
$relatedArticles = array_slice($relatedArticles, 0, 3);

// Set page title
$pageTitle = htmlspecialchars($artikel['judul']) . ' - Mega Kayan Ganesha';
?>

    <!-- Page Header -->
    <section class="page-header section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item"><a href="berita.php">Berita & Publikasi</a></li>
                <li class="breadcrumb-item"><a href="berita.php#artikel">Artikel</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($artikel['judul']); ?></li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>

    <!-- Article Detail Section -->
    <section class="section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-8">
            <article class="article-detail">
              <!-- Article Header -->
              <div class="article-header mb-4">
                <span class="badge bg-primary mb-2"><?php echo ucfirst($artikel['kategori']); ?></span>
                <h1 class="article-title"><?php echo htmlspecialchars($artikel['judul']); ?></h1>
                
                <div class="article-meta d-flex flex-wrap align-items-center gap-3 mt-3 mb-4">
                  <div class="meta-item">
                    <i class="bi bi-calendar"></i>
                    <span><?php echo formatDateID($artikel['published_at'] ?: $artikel['created_at']); ?></span>
                  </div>
                  <?php if ($author): ?>
                  <div class="meta-item">
                    <i class="bi bi-person"></i>
                    <span><?php echo htmlspecialchars($author['full_name'] ?: $author['username']); ?></span>
                  </div>
                  <?php endif; ?>
                  <div class="meta-item">
                    <i class="bi bi-eye"></i>
                    <span><?php echo number_format($artikel['views']); ?> views</span>
                  </div>
                </div>
              </div>

              <!-- Article Image -->
              <?php if ($artikel['gambar']): ?>
              <div class="article-image mb-4">
                <img src="uploads/artikel/<?php echo htmlspecialchars($artikel['gambar']); ?>" 
                     alt="<?php echo htmlspecialchars($artikel['judul']); ?>" 
                     class="img-fluid rounded">
              </div>
              <?php endif; ?>

              <!-- Article Excerpt -->
              <?php if ($artikel['excerpt']): ?>
              <div class="article-excerpt mb-4">
                <p class="lead"><?php echo htmlspecialchars($artikel['excerpt']); ?></p>
              </div>
              <?php endif; ?>

              <!-- Article Content -->
              <div class="article-content">
                <?php echo nl2br(htmlspecialchars($artikel['konten'])); ?>
              </div>

              <!-- Article Footer -->
              <div class="article-footer mt-5 pt-4 border-top">
                <div class="d-flex justify-content-between align-items-center">
                  <a href="berita.php#artikel" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Artikel
                  </a>
                  <div class="social-share">
                    <span class="me-2">Bagikan:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                       target="_blank" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($artikel['judul']); ?>" 
                       target="_blank" class="btn btn-sm btn-outline-info">
                      <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="https://wa.me/?text=<?php echo urlencode($artikel['judul'] . ' - ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" 
                       target="_blank" class="btn btn-sm btn-outline-success">
                      <i class="bi bi-whatsapp"></i>
                    </a>
                  </div>
                </div>
              </div>
            </article>
          </div>

          <!-- Sidebar -->
          <div class="col-lg-4">
            <aside class="sidebar">
              <!-- Related Articles -->
              <?php if (!empty($relatedArticles)): ?>
              <div class="sidebar-widget mb-4">
                <h4 class="widget-title">Artikel Terkait</h4>
                <div class="widget-content">
                  <?php foreach ($relatedArticles as $related): ?>
                  <div class="related-item mb-3 pb-3 border-bottom">
                    <h5 class="mb-2">
                      <a href="artikel-detail.php?slug=<?php echo htmlspecialchars($related['slug']); ?>" class="text-decoration-none">
                        <?php echo htmlspecialchars($related['judul']); ?>
                      </a>
                    </h5>
                    <p class="text-muted small mb-0">
                      <?php echo formatDateID($related['published_at'] ?: $related['created_at']); ?>
                    </p>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php endif; ?>

              <!-- Latest Articles -->
              <?php 
              $latestArticles = getArticles(5);
              $latestArticles = array_filter($latestArticles, function($a) use ($artikel) {
                return $a['id'] != $artikel['id'];
              });
              $latestArticles = array_slice($latestArticles, 0, 5);
              ?>
              <?php if (!empty($latestArticles)): ?>
              <div class="sidebar-widget">
                <h4 class="widget-title">Artikel Terbaru</h4>
                <div class="widget-content">
                  <ul class="list-unstyled">
                    <?php foreach ($latestArticles as $latest): ?>
                    <li class="mb-3 pb-3 border-bottom">
                      <h6 class="mb-1">
                        <a href="artikel-detail.php?slug=<?php echo htmlspecialchars($latest['slug']); ?>" class="text-decoration-none">
                          <?php echo htmlspecialchars($latest['judul']); ?>
                        </a>
                      </h6>
                      <p class="text-muted small mb-0">
                        <?php echo formatDateID($latest['published_at'] ?: $latest['created_at']); ?>
                      </p>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
              <?php endif; ?>
            </aside>
          </div>
        </div>
      </div>
    </section>

    <style>
      .article-detail {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      }
      .article-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e3a5f;
        margin-bottom: 1rem;
      }
      .article-meta {
        color: #6c757d;
        font-size: 0.9rem;
      }
      .article-meta .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }
      .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
      }
      .article-content p {
        margin-bottom: 1.5rem;
      }
      .article-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
      }
      .sidebar-widget {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      }
      .widget-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e3a5f;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #0d83fd;
      }
      .related-item h5 a {
        color: #1e3a5f;
        transition: color 0.3s;
      }
      .related-item h5 a:hover {
        color: #0d83fd;
      }
      .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
      }
      .breadcrumb-item a {
        color: #0d83fd;
        text-decoration: none;
      }
      .breadcrumb-item.active {
        color: #6c757d;
      }
    </style>

<?php include 'includes/footer.php'; ?>

