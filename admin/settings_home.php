<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['settings'])) {
    foreach ($_POST['settings'] as $key => $value) {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt->execute([$key, $value, $value]);
    }
    $success = "Teks Beranda berhasil diperbarui!";
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
        <h2 class="fw-bold mb-0">Teks Website 📝</h2>
        <p class="text-muted mt-1" style="font-size: 0.9rem;">Kelola seluruh kata-kata di halaman depan</p>
    </div>
</div>

<?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm"><i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($success) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<form method="post">
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-compass me-2 text-primary"></i> Teks Navigasi Atas</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Link 1 (Beranda)</label>
                        <input type="text" name="settings[text_nav_home]" class="form-control" value="<?= htmlspecialchars($settings['text_nav_home'] ?? 'Beranda') ?>">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Link 2 (Tentang)</label>
                        <input type="text" name="settings[text_nav_about]" class="form-control" value="<?= htmlspecialchars($settings['text_nav_about'] ?? 'Tentang Kami') ?>">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Link 3 (Menu)</label>
                        <input type="text" name="settings[text_nav_menu]" class="form-control" value="<?= htmlspecialchars($settings['text_nav_menu'] ?? 'Menu') ?>">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Link 4 (Acara)</label>
                        <input type="text" name="settings[text_nav_events]" class="form-control" value="<?= htmlspecialchars($settings['text_nav_events'] ?? 'Acara') ?>">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Link 5 (Koki)</label>
                        <input type="text" name="settings[text_nav_chefs]" class="form-control" value="<?= htmlspecialchars($settings['text_nav_chefs'] ?? 'Koki') ?>">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Link 6 (Galeri)</label>
                        <input type="text" name="settings[text_nav_gallery]" class="form-control" value="<?= htmlspecialchars($settings['text_nav_gallery'] ?? 'Galeri') ?>">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Link 7 (Kontak)</label>
                        <input type="text" name="settings[text_nav_contact]" class="form-control" value="<?= htmlspecialchars($settings['text_nav_contact'] ?? 'Kontak') ?>">
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Tombol Pesan Meja</label>
                        <input type="text" name="settings[text_nav_book]" class="form-control" value="<?= htmlspecialchars($settings['text_nav_book'] ?? 'Pesan Meja') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-card-text me-2 text-primary"></i> Poin-Poin Tentang Kami</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Poin Checklist 1</label>
                    <input type="text" name="settings[about_point_1]" class="form-control" value="<?= htmlspecialchars($settings['about_point_1'] ?? 'Bahan-bahan segar yang dimasak dengan penuh cinta dan dedikasi.') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Poin Checklist 2</label>
                    <input type="text" name="settings[about_point_2]" class="form-control" value="<?= htmlspecialchars($settings['about_point_2'] ?? 'Suasana restoran yang nyaman untuk setiap perayaan Anda.') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Poin Checklist 3</label>
                    <input type="text" name="settings[about_point_3]" class="form-control" value="<?= htmlspecialchars($settings['about_point_3'] ?? 'Pelayanan ramah yang siap menyambut Anda bagaikan di rumah sendiri.') ?>">
                </div>
                <div class="mb-3 mt-4">
                    <label class="form-label">Link Video (YouTube ID atau Link Penuh)</label>
                    <input type="text" name="settings[about_video_link]" class="form-control" value="<?= htmlspecialchars($settings['about_video_link'] ?? 'https://www.youtube.com/watch?v=LXb3EKWsInQ') ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header"><i class="bi bi-patch-question me-2 text-primary"></i> Section "Kenapa Memilih Kami"</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Judul Utama</label>
                        <input type="text" name="settings[why_us_title]" class="form-control" value="<?= htmlspecialchars($settings['why_us_title'] ?? 'Mengapa Memilih Kami?') ?>">
                        <label class="form-label mt-2">Deskripsi Utama</label>
                        <textarea name="settings[why_us_desc]" class="form-control" rows="3"><?= htmlspecialchars($settings['why_us_desc'] ?? 'Kami menyajikan yang terbaik untuk Anda.') ?></textarea>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kotak 1: Judul</label>
                                <input type="text" name="settings[why_us_box1_title]" class="form-control mb-1" value="<?= htmlspecialchars($settings['why_us_box1_title'] ?? 'Kualitas Premium') ?>">
                                <textarea name="settings[why_us_box1_desc]" class="form-control" rows="2"><?= htmlspecialchars($settings['why_us_box1_desc'] ?? 'Hanya bahan terbaik.') ?></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kotak 2: Judul</label>
                                <input type="text" name="settings[why_us_box2_title]" class="form-control mb-1" value="<?= htmlspecialchars($settings['why_us_box2_title'] ?? 'Resep Asli') ?>">
                                <textarea name="settings[why_us_box2_desc]" class="form-control" rows="2"><?= htmlspecialchars($settings['why_us_box2_desc'] ?? 'Rahasia turun temurun.') ?></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kotak 3: Judul</label>
                                <input type="text" name="settings[why_us_box3_title]" class="form-control mb-1" value="<?= htmlspecialchars($settings['why_us_box3_title'] ?? 'Koki Handal') ?>">
                                <textarea name="settings[why_us_box3_desc]" class="form-control" rows="2"><?= htmlspecialchars($settings['why_us_box3_desc'] ?? 'Profesional bersertifikasi.') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header"><i class="bi bi-bar-chart me-2 text-primary"></i> Angka Statistik</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="number" name="settings[stats_1_num]" class="form-control mb-1" value="<?= htmlspecialchars($settings['stats_1_num'] ?? '232') ?>">
                        <input type="text" name="settings[stats_1_label]" class="form-control" value="<?= htmlspecialchars($settings['stats_1_label'] ?? 'Pelanggan') ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="number" name="settings[stats_2_num]" class="form-control mb-1" value="<?= htmlspecialchars($settings['stats_2_num'] ?? '521') ?>">
                        <input type="text" name="settings[stats_2_label]" class="form-control" value="<?= htmlspecialchars($settings['stats_2_label'] ?? 'Proyek') ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="number" name="settings[stats_3_num]" class="form-control mb-1" value="<?= htmlspecialchars($settings['stats_3_num'] ?? '1453') ?>">
                        <input type="text" name="settings[stats_3_label]" class="form-control" value="<?= htmlspecialchars($settings['stats_3_label'] ?? 'Jam Layanan') ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="number" name="settings[stats_4_num]" class="form-control mb-1" value="<?= htmlspecialchars($settings['stats_4_num'] ?? '32') ?>">
                        <input type="text" name="settings[stats_4_label]" class="form-control" value="<?= htmlspecialchars($settings['stats_4_label'] ?? 'Karyawan Penuh') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header"><i class="bi bi-c-circle me-2 text-primary"></i> Footer & Penutup</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teks Hak Cipta (Copyright)</label>
                        <input type="text" name="settings[footer_copyright]" class="form-control mb-1" value="<?= htmlspecialchars($settings['footer_copyright'] ?? 'Yummy') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slogan Pendek Footer</label>
                        <input type="text" name="settings[footer_slogan]" class="form-control" value="<?= htmlspecialchars($settings['footer_slogan'] ?? 'Kami menanti kedatangan Anda kembali.') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="position-sticky bottom-0 bg-white p-3 shadow-lg rounded" style="z-index: 10;">
    <button class="btn btn-primary btn-lg px-5"><i class="bi bi-save me-2"></i> Terapkan Semua Perubahan Teks</button>
</div>
</form>

<?php require_once 'includes/footer.php'; ?>
