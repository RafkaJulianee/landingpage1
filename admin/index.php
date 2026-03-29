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
    $success = "Settings successfully updated!";
}

$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings_db = $stmt->fetchAll();
$settings = [];
foreach ($settings_db as $row) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<div class="d-flex justify-content-between align-items-center mb-4 pb-2">
    <div>
        <h2 class="fw-bold mb-0">General Settings 👋</h2>
        <p class="text-muted mt-1" style="font-size: 0.9rem;">Manage your store's core details</p>
    </div>
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
            <div class="card-header"><i class="bi bi-info-circle me-2 text-primary"></i> Basic Information</div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label">Site Title</label>
                    <input type="text" name="settings[site_title]" class="form-control" value="<?= htmlspecialchars($settings['site_title'] ?? '') ?>">
                </div>
                
                <hr class="text-secondary opacity-25">

                <div class="mb-4 mt-4">
                    <label class="form-label">Hero Title <small class="text-muted fw-normal">(Use &lt;br&gt; for line break)</small></label>
                    <textarea name="settings[hero_title]" class="form-control" rows="2"><?= htmlspecialchars($settings['hero_title'] ?? '') ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label">Hero Subtitle</label>
                    <textarea name="settings[hero_subtitle]" class="form-control" rows="3"><?= htmlspecialchars($settings['hero_subtitle'] ?? '') ?></textarea>
                </div>

                <hr class="text-secondary opacity-25">

                <div class="mb-2 mt-4">
                    <label class="form-label">About Us Story</label>
                    <textarea name="settings[about_text]" class="form-control" rows="5"><?= htmlspecialchars($settings['about_text'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header"><i class="bi bi-telephone ms-2 text-primary"></i> Local Details</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="settings[contact_phone]" class="form-control" value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Email Support</label>
                        <input type="text" name="settings[contact_email]" class="form-control" value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label class="form-label">Physical Address</label>
                        <textarea name="settings[contact_address]" class="form-control" rows="2"><?= htmlspecialchars($settings['contact_address'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Opening Hours</label>
                        <input type="text" name="settings[contact_opening_hours]" class="form-control" value="<?= htmlspecialchars($settings['contact_opening_hours'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom 2: Image Uploads -->
    <div class="col-md-5">
        <div class="card" style="position: sticky; top: 10px;">
            <div class="card-header border-0"><i class="bi bi-images me-2 text-primary"></i> Multimedia</div>
            <div class="card-body">
                
                <div class="mb-4">
                    <label class="form-label d-block text-center text-md-start">Hero Billboard Image</label>
                    <div class="p-4 rounded text-center mb-3" style="background:#fcfcff; border: 2px dashed #ececf1;">
                        <?php if(!empty($settings['hero_img'])): ?>
                            <img src="../<?= $settings['hero_img'] ?>" class="img-fluid rounded shadow-sm" style="max-height: 140px;">
                        <?php else: ?>
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i><br>
                            <span class="text-muted small">No custom image set</span>
                        <?php endif; ?>
                    </div>
                    <input type="file" name="hero_img" class="form-control" accept="image/*">
                </div>

                <hr class="text-secondary opacity-25 my-4">

                <div class="mb-5">
                    <label class="form-label d-block text-center text-md-start">About Us Background</label>
                    <div class="p-4 rounded text-center mb-3" style="background:#fcfcff; border: 2px dashed #ececf1;">
                        <?php if(!empty($settings['about_img'])): ?>
                            <img src="../<?= $settings['about_img'] ?>" class="img-fluid rounded shadow-sm" style="max-height: 140px;">
                        <?php else: ?>
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i><br>
                            <span class="text-muted small">No custom image set</span>
                        <?php endif; ?>
                    </div>
                    <input type="file" name="about_img" class="form-control" accept="image/*">
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-save me-2"></i> Save Preferences</button>
                    <a href="../index.php" target="_blank" class="btn btn-outline-secondary mt-3">Preview Frontend</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<?php require_once 'includes/footer.php'; ?>
