<?php
$pageTitle = "Pengaturan";
require_once __DIR__ . '/includes/header.php';
requirePermission('super_admin');

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if ($key != 'submit') {
            $stmt = $db->prepare("UPDATE settings SET value = ? WHERE `key` = ?");
            $stmt->execute([$value, $key]);
        }
    }
    $_SESSION['success'] = 'Pengaturan berhasil diperbarui!';
    header('Location: settings.php');
    exit;
}

$stmt = $db->query("SELECT * FROM settings ORDER BY `key`");
$settings = $stmt->fetchAll();

$settingsArray = [];
foreach ($settings as $setting) {
    $settingsArray[$setting['key']] = $setting['value'];
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-gear me-2"></i>Pengaturan Website</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST">
            <h5 class="mb-3">Informasi Umum</h5>
            
            <div class="mb-3">
                <label for="site_name" class="form-label">Nama Website</label>
                <input type="text" class="form-control" id="site_name" name="site_name" value="<?php echo htmlspecialchars($settingsArray['site_name'] ?? ''); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="site_email" class="form-label">Email Website</label>
                <input type="email" class="form-control" id="site_email" name="site_email" value="<?php echo htmlspecialchars($settingsArray['site_email'] ?? ''); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="site_phone" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="site_phone" name="site_phone" value="<?php echo htmlspecialchars($settingsArray['site_phone'] ?? ''); ?>">
            </div>
            
            <div class="mb-3">
                <label for="site_address" class="form-label">Alamat</label>
                <textarea class="form-control" id="site_address" name="site_address" rows="3"><?php echo htmlspecialchars($settingsArray['site_address'] ?? ''); ?></textarea>
            </div>
            
            <hr>
            
            <h5 class="mb-3">Media Sosial</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="facebook_url" class="form-label">Facebook URL</label>
                    <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="<?php echo htmlspecialchars($settingsArray['facebook_url'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="instagram_url" class="form-label">Instagram URL</label>
                    <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="<?php echo htmlspecialchars($settingsArray['instagram_url'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                    <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" value="<?php echo htmlspecialchars($settingsArray['linkedin_url'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="twitter_url" class="form-label">Twitter URL</label>
                    <input type="url" class="form-control" id="twitter_url" name="twitter_url" value="<?php echo htmlspecialchars($settingsArray['twitter_url'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="whatsapp_number" class="form-label">Nomor WhatsApp</label>
                <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="<?php echo htmlspecialchars($settingsArray['whatsapp_number'] ?? ''); ?>" placeholder="+62 812-3456-7890">
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

