<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../includes/db.php';

// Prepare a message variable
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['settings'])) {
    foreach ($_POST['settings'] as $key => $value) {
        // Update each setting based on its key
        $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
        $stmt->execute([$value, $key]);
    }
    $success = "Pengaturan berhasil disimpan!";
}

// Fetch all settings from the database
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings_db = $stmt->fetchAll();
$settings = [];
foreach ($settings_db as $row) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Settings</title>
    <!-- Use Bootstrap from the template's assets for consistency -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-info" href="../index.php" target="_blank">Lihat Website</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5 mb-5 border-light">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">General Settings</h2>
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>
                
                <form method="post" class="bg-white p-4 shadow-sm rounded">
                    <h5 class="mb-3 text-secondary">General Info</h5>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Site Title</label>
                        <input type="text" name="settings[site_title]" class="form-control" value="<?= htmlspecialchars($settings['site_title'] ?? '') ?>">
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 text-secondary">Hero Section</h5>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Hero Title (Use &lt;br&gt; for line break)</label>
                        <textarea name="settings[hero_title]" class="form-control" rows="2"><?= htmlspecialchars($settings['hero_title'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Hero Subtitle</label>
                        <textarea name="settings[hero_subtitle]" class="form-control" rows="3"><?= htmlspecialchars($settings['hero_subtitle'] ?? '') ?></textarea>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 text-secondary">About Section</h5>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">About Us Text</label>
                        <textarea name="settings[about_text]" class="form-control" rows="5"><?= htmlspecialchars($settings['about_text'] ?? '') ?></textarea>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 text-secondary">Contact Information</h5>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Phone Number</label>
                        <input type="text" name="settings[contact_phone]" class="form-control" value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Email Address</label>
                        <input type="text" name="settings[contact_email]" class="form-control" value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Physical Address</label>
                        <textarea name="settings[contact_address]" class="form-control" rows="2"><?= htmlspecialchars($settings['contact_address'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Opening Hours</label>
                        <input type="text" name="settings[contact_opening_hours]" class="form-control" value="<?= htmlspecialchars($settings['contact_opening_hours'] ?? '') ?>">
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
