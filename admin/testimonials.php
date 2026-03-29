<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$success = '';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM testimonials WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
    if($stmt->execute([$id])) {
        if($item && file_exists("../" . $item['image']) && strpos($item['image'], 'uploads/') !== false) {
             @unlink("../" . $item['image']);
        }
        $success = "Testimoni berhasil dihapus!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $content = $_POST['content'];
    $rating = (int)$_POST['rating'];
    
    $imagePath = $_POST['current_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_name = 'testi_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/uploads/' . $new_name)) {
                $imagePath = 'assets/img/uploads/' . $new_name;
            }
        }
    }
    
    if ($_POST['action'] == 'add') {
        if(empty($imagePath)) $imagePath = 'assets/img/testimonials/testimonials-1.jpg'; // default
        $stmt = $pdo->prepare("INSERT INTO testimonials (name, role, content, rating, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $role, $content, $rating, $imagePath]);
        $success = "Testimoni baru berhasil ditambahkan!";
    } elseif ($_POST['action'] == 'edit') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE testimonials SET name=?, role=?, content=?, rating=?, image=? WHERE id=?");
        $stmt->execute([$name, $role, $content, $rating, $imagePath, $id]);
        $success = "Testimoni berhasil diperbarui!";
    }
}

$stmt = $pdo->query("SELECT * FROM testimonials ORDER BY id DESC");
$testimonials = $stmt->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4 pb-2">
    <div>
        <h2 class="fw-bold mb-0">Ulasan Pelanggan 🗣️</h2>
        <p class="text-muted mt-1" style="font-size: 0.9rem;">Kelola testimoni yang tampil di halaman utama</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testiModal" onclick="document.getElementById('formAction').value='add'; document.getElementById('testiForm').reset(); document.getElementById('modalTitle').innerText='Tambah Testimoni';">
        <i class="bi bi-chat-quote me-1"></i> Tambah Testimoni
    </button>
</div>

<?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm"><i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($success) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card py-2 border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Foto Profil</th>
                        <th>Nama Pelanggan</th>
                        <th>Pekerjaan / Jabatan</th>
                        <th>Ulasan / Rating</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testimonials as $t): ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <img src="../<?= htmlspecialchars($t['image']) ?>" alt="" class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid white;">
                        </td>
                        <td class="fw-bold text-dark"><?= htmlspecialchars($t['name']) ?></td>
                        <td class="text-muted"><?= htmlspecialchars($t['role']) ?></td>
                        <td class="text-muted" style="font-size: 0.85rem;">
                            <div class="text-warning mb-1">
                                <?php for($i=0; $i<$t['rating']; $i++) echo '<i class="bi bi-star-fill"></i>'; ?>
                                <?php for($i=0; $i<(5-$t['rating']); $i++) echo '<i class="bi bi-star text-muted"></i>'; ?>
                            </div>
                            <span class="d-inline-block text-truncate" style="max-width: 250px;">"<?= htmlspecialchars($t['content']) ?>"</span>
                        </td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light rounded-circle shadow-sm text-primary me-2 shadow-hover" onclick="editTesti(<?= htmlspecialchars(json_encode($t)) ?>)" style="width:35px;height:35px">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="testimonials.php?delete=<?= $t['id'] ?>" class="btn btn-sm btn-light rounded-circle shadow-sm text-danger shadow-hover" onclick="return confirm('Hapus testimoni ini?');" style="width:35px;height:35px;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($testimonials)): ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada testimoni. Mintalah pendapat jujur dari pelanggan Anda!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="testiModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 10px 40px rgba(0,0,0,0.1)">
      <form method="post" enctype="multipart/form-data" id="testiForm">
          <div class="modal-header border-0 bg-light rounded-top" style="border-radius:20px 20px 0 0; padding:20px 25px;">
            <h5 class="modal-title fw-bold" id="modalTitle">Tambah Testimoni</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="id" id="testiId">
                <input type="hidden" name="current_image" id="currentImage">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nama Pelanggan</label>
                        <input type="text" name="name" id="testiName" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Jabatan / Pekerjaan</label>
                        <input type="text" name="role" id="testiRole" class="form-control" placeholder="Cth: Pegawai Bank" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Bintang Rating (1-5)</label>
                    <select name="rating" id="testiRating" class="form-select">
                        <option value="5">5 Bintang - Sangat Puas</option>
                        <option value="4">4 Bintang - Puas</option>
                        <option value="3">3 Bintang - Biasa</option>
                        <option value="2">2 Bintang - Buruk</option>
                        <option value="1">1 Bintang - Sangat Kecewa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Kesimpulan Ulasan</label>
                    <textarea name="content" id="testiContent" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Foto Profil Pelanggan</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
          </div>
          <div class="modal-footer border-0 p-4 pt-1">
            <button type="button" class="btn btn-light rounded px-4" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i> Simpan Testimoni</button>
          </div>
      </form>
    </div>
  </div>
</div>

<style>
    .shadow-hover:hover { box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important; transform: translateY(-2px); transition: 0.2s;}
</style>

<script>
function editTesti(t) {
    document.getElementById('modalTitle').innerText = 'Perbarui Testimoni';
    document.getElementById('formAction').value = 'edit';
    document.getElementById('testiId').value = t.id;
    document.getElementById('testiName').value = t.name;
    document.getElementById('testiRole').value = t.role;
    document.getElementById('testiRating').value = t.rating;
    document.getElementById('testiContent').value = t.content;
    document.getElementById('currentImage').value = t.image;
    
    var myModal = new bootstrap.Modal(document.getElementById('testiModal'));
    myModal.show();
}
</script>

<?php require_once 'includes/footer.php'; ?>
