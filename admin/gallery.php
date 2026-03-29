<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$success = '';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
    if($stmt->execute([$id])) {
        if($item && file_exists("../" . $item['image']) && strpos($item['image'], 'uploads/') !== false) {
             @unlink("../" . $item['image']);
        }
        $success = "Foto berhasil dihapus dari galeri!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
    $uploadedCount = 0;
    
    // Multiple upload handling
    foreach($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        if($_FILES['images']['error'][$key] == 0) {
            $ext = strtolower(pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $new_name = 'gallery_' . uniqid() . '_' . $key . '.' . $ext;
                if (move_uploaded_file($tmp_name, '../assets/img/uploads/' . $new_name)) {
                    $imagePath = 'assets/img/uploads/' . $new_name;
                    $stmt = $pdo->prepare("INSERT INTO gallery (image) VALUES (?)");
                    $stmt->execute([$imagePath]);
                    $uploadedCount++;
                }
            }
        }
    }
    
    if ($uploadedCount > 0) {
        $success = "$uploadedCount foto baru berhasil ditambahkan!";
    } else {
        $success = "Tidak ada foto valid yang diunggah.";
    }
}

$stmt = $pdo->query("SELECT * FROM gallery ORDER BY id DESC");
$photos = $stmt->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4 pb-2">
    <div>
        <h2 class="fw-bold mb-0">Galeri Foto 📷</h2>
        <p class="text-muted mt-1" style="font-size: 0.9rem;">Kelola potret restoran dan hidangan</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#galleryModal">
        <i class="bi bi-cloud-arrow-up me-1"></i> Unggah Foto
    </button>
</div>

<?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm"><i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($success) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card border-0 shadow-sm p-4">
    <div class="row g-4">
        <?php foreach ($photos as $p): ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="position-relative gallery-item rounded overflow-hidden shadow-sm" style="height: 200px; background: #f4f6fa;">
                <img src="../<?= htmlspecialchars($p['image']) ?>" alt="Gallery Image" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s ease;">
                
                <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center" style="background: rgba(0,0,0,0.5); opacity: 0; transition: 0.3s;">
                    <a href="gallery.php?delete=<?= $p['id'] ?>" class="btn btn-danger rounded-circle shadow" onclick="return confirm('Hapus gambar ini dari galeri?');" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-trash fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <?php if(empty($photos)): ?>
        <div class="col-12 text-center py-5">
            <i class="bi bi-images text-muted" style="font-size: 4rem;"></i>
            <p class="text-muted mt-3">Belum ada foto yang diunggah d galeri.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="galleryModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 10px 40px rgba(0,0,0,0.1)">
      <form method="post" enctype="multipart/form-data">
          <div class="modal-header border-0 bg-light rounded-top" style="border-radius:20px 20px 0 0; padding:20px 25px;">
            <h5 class="modal-title fw-bold">Unggah Banyak Gambar Sekaligus</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4 text-center">
                
                <i class="bi bi-cloud-upload text-primary mb-3 d-block" style="font-size: 4rem;"></i>
                <h6 class="fw-bold">Pilih Foto-Foto Terbaik</h6>
                <p class="text-muted small">Anda bisa memilih lebih dari satu foto sekaligus (Tahan tombol CTRL/CMD)</p>
                
                <div class="mb-4">
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                </div>
          </div>
          <div class="modal-footer border-0 p-4 pt-1 justify-content-center">
            <button type="button" class="btn btn-light rounded px-4" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-5"><i class="bi bi-upload me-2"></i> Mulai Unggah</button>
          </div>
      </form>
    </div>
  </div>
</div>

<style>
    .gallery-item:hover img { transform: scale(1.05); }
    .gallery-item:hover .gallery-overlay { opacity: 1 !important; }
</style>

<?php require_once 'includes/footer.php'; ?>
