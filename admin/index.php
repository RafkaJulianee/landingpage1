<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['settings'])) {
    foreach ($_POST['settings'] as $key => $value) {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt->execute([$key, $value, $value]);
    }
    
    // Image Uploads
    $image_keys = ['hero_img', 'about_img'];
    foreach ($image_keys as $key) {
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $filename = $_FILES[$key]['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $new_name = $key . '_' . uniqid() . '.' . $ext;
                $destination = '../assets/img/uploads/' . $new_name;
                if (move_uploaded_file($_FILES[$key]['tmp_name'], $destination)) {
                    $path = 'assets/img/uploads/' . $new_name;
                    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
                    $stmt->execute([$key, $path, $path]);
                }
            }
        }
    }
    $success = "Pengaturan berhasil disimpan!";
}

$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings_db = $stmt->fetchAll();
$settings = [];
foreach ($settings_db as $row) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">General Settings</h2>
    <span class="text-muted"><i class="bi bi-calendar"></i> <?php echo date('d M Y'); ?></span>
</div>

<?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">

<div class="row">
    <!-- Kolom 1: Teks General -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-info-square me-2 text-danger"></i> Site Information</div>
            <div class="card-body">
                <div class="mb-1">
                    <label class="form-label text-muted fw-bold">Site Title</label>
                    <input type="text" name="settings[site_title]" class="form-control bg-light" value="<?= htmlspecialchars($settings['site_title'] ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="bi bi-layout-text-window-reverse me-2 text-danger"></i> Hero Section</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted fw-bold">Hero Title (Use &lt;br&gt; for line break)</label>
                    <textarea name="settings[hero_title]" class="form-control bg-light" rows="2"><?= htmlspecialchars($settings['hero_title'] ?? '') ?></textarea>
                </div>
                <div class="mb-1">
                    <label class="form-label text-muted fw-bold">Hero Subtitle</label>
                    <textarea name="settings[hero_subtitle]" class="form-control bg-light" rows="3"><?= htmlspecialchars($settings['hero_subtitle'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="bi bi-file-person me-2 text-danger"></i> About Section</div>
            <div class="card-body">
                <div class="mb-1">
                    <label class="form-label text-muted fw-bold">About Us Text</label>
                    <textarea name="settings[about_text]" class="form-control bg-light" rows="5"><?= htmlspecialchars($settings['about_text'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header"><i class="bi bi-telephone ms-2 text-danger"></i> Contact Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted fw-bold">Phone</label>
                        <input type="text" name="settings[contact_phone]" class="form-control bg-light" value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted fw-bold">Email</label>
                        <input type="text" name="settings[contact_email]" class="form-control bg-light" value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label text-muted fw-bold">Address</label>
                        <textarea name="settings[contact_address]" class="form-control bg-light" rows="2"><?= htmlspecialchars($settings['contact_address'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-12 mb-1">
                        <label class="form-label text-muted fw-bold">Opening Hours</label>
                        <input type="text" name="settings[contact_opening_hours]" class="form-control bg-light" value="<?= htmlspecialchars($settings['contact_opening_hours'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom 2: Image Uploads -->
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white border-0"><i class="bi bi-images me-2"></i> Media Uploads</div>
            <div class="card-body bg-white rounded-bottom">
                
                <div class="mb-4">
                    <label class="form-label text-muted fw-bold d-block">Hero Image (Beside Hero Text)</label>
                    <?php if(!empty($settings['hero_img'])): ?>
                        <div class="mb-3 text-center bg-light p-3 rounded">
                            <img src="../<?= $settings['hero_img'] ?>" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                        </div>
                    <?php else: ?>
                        <div class="mb-3 text-center bg-light p-3 rounded text-muted">
                           <i class="bi bi-image" style="font-size: 3rem;"></i><br> Default Image Active
                        </div>
                    <?php endif; ?>
                    <input type="file" name="hero_img" class="form-control" accept="image/*">
                    <small class="text-muted fst-italic">Leave empty to keep current image</small>
                </div>

                <hr class="text-secondary border-dashed my-4">

                <div class="mb-4">
                    <label class="form-label text-muted fw-bold d-block">About Background Image</label>
                    <?php if(!empty($settings['about_img'])): ?>
                        <div class="mb-3 text-center bg-light p-3 rounded">
                            <img src="../<?= $settings['about_img'] ?>" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                        </div>
                    <?php else: ?>
                        <div class="mb-3 text-center bg-light p-3 rounded text-muted">
                           <i class="bi bi-image" style="font-size: 3rem;"></i><br> Default Image Active
                        </div>
                    <?php endif; ?>
                    <input type="file" name="about_img" class="form-control" accept="image/*">
                    <small class="text-muted fst-italic">Leave empty to keep current image</small>
                </div>

                <div class="d-grid mt-5">
                    <button type="submit" class="btn btn-danger btn-lg shadow-sm"><i class="bi bi-save me-2"></i> Save All Changes</button>
                    <a href="../index.php" target="_blank" class="btn btn-outline-secondary mt-3">Preview Website</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<?php require_once 'includes/footer.php'; ?>
