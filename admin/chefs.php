<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$success = '';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM chefs WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    $stmt = $pdo->prepare("DELETE FROM chefs WHERE id = ?");
    if($stmt->execute([$id])) {
        if($item && file_exists("../" . $item['image']) && strpos($item['image'], 'uploads/') !== false) {
             @unlink("../" . $item['image']);
        }
        $success = "Koki berhasil dihapus!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $description = $_POST['description'];
    $tw = $_POST['social_twitter'];
    $fb = $_POST['social_fb'];
    $ig = $_POST['social_ig'];
    $in = $_POST['social_linkedin'];
    
    $imagePath = $_POST['current_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_name = 'chef_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/uploads/' . $new_name)) {
                $imagePath = 'assets/img/uploads/' . $new_name;
            }
        }
    }
    
    if ($_POST['action'] == 'add') {
        if(empty($imagePath)) $imagePath = 'assets/img/chefs/chefs-1.jpg'; // default
        $stmt = $pdo->prepare("INSERT INTO chefs (name, role, description, social_twitter, social_fb, social_ig, social_linkedin, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $role, $description, $tw, $fb, $ig, $in, $imagePath]);
        $success = "Koki baru berhasil ditambahkan!";
    } elseif ($_POST['action'] == 'edit') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE chefs SET name=?, role=?, description=?, social_twitter=?, social_fb=?, social_ig=?, social_linkedin=?, image=? WHERE id=?");
        $stmt->execute([$name, $role, $description, $tw, $fb, $ig, $in, $imagePath, $id]);
        $success = "Data koki berhasil diperbarui!";
    }
}

$stmt = $pdo->query("SELECT * FROM chefs ORDER BY id ASC");
$chefs = $stmt->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4 pb-2">
    <div>
        <h2 class="fw-bold mb-0">Daftar Koki 👨‍🍳</h2>
        <p class="text-muted mt-1" style="font-size: 0.9rem;">Kelola staf ahli dan juru masak Anda</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#chefModal" onclick="document.getElementById('formAction').value='add'; document.getElementById('chefForm').reset(); document.getElementById('modalTitle').innerText='Tambah Koki';">
        <i class="bi bi-person-plus me-1"></i> Tambah Koki
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
                        <th class="ps-4">Foto / Profil</th>
                        <th>Nama & Posisi</th>
                        <th>Sosial Media (Tautan)</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chefs as $c): ?>
                    <tr>
                        <td class="ps-4 py-3 text-center" style="width:100px;">
                            <img src="../<?= htmlspecialchars($c['image']) ?>" alt="" class="rounded shadow-sm" style="width: 70px; height: 75px; object-fit: cover; border: 2px solid white;">
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($c['name']) ?></div>
                            <div class="text-primary fw-semibold" style="font-size:0.85rem;"><?= htmlspecialchars($c['role']) ?></div>
                            <div class="text-muted mt-1" style="font-size: 0.8rem;"><span class="d-inline-block text-truncate" style="max-width: 250px;"><?= htmlspecialchars($c['description']) ?></span></div>
                        </td>
                        <td>
                            <?php if($c['social_twitter']): ?><i class="bi bi-twitter text-info me-2 fs-5"></i><?php endif; ?>
                            <?php if($c['social_fb']): ?><i class="bi bi-facebook text-primary me-2 fs-5"></i><?php endif; ?>
                            <?php if($c['social_ig']): ?><i class="bi bi-instagram text-danger me-2 fs-5"></i><?php endif; ?>
                            <?php if($c['social_linkedin']): ?><i class="bi bi-linkedin text-primary me-2 fs-5"></i><?php endif; ?>
                            <?php if(!$c['social_twitter'] && !$c['social_fb'] && !$c['social_ig'] && !$c['social_linkedin']): ?>
                                <span class="text-muted small">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light rounded-circle shadow-sm text-primary me-2 shadow-hover" onclick="editChef(<?= htmlspecialchars(json_encode($c)) ?>)" style="width:35px;height:35px">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="chefs.php?delete=<?= $c['id'] ?>" class="btn btn-sm btn-light rounded-circle shadow-sm text-danger shadow-hover" onclick="return confirm('Hapus profile koki ini?');" style="width:35px;height:35px;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($chefs)): ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada tim koki yang ditambahkan. Silakan rekrut anggota baru!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="chefModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 10px 40px rgba(0,0,0,0.1)">
      <form method="post" enctype="multipart/form-data" id="chefForm">
          <div class="modal-header border-0 bg-light rounded-top" style="border-radius:20px 20px 0 0; padding:20px 25px;">
            <h5 class="modal-title fw-bold" id="modalTitle">Tambah Staf Koki</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="id" id="chefId">
                <input type="hidden" name="current_image" id="currentImage">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nama Lengkap</label>
                        <input type="text" name="name" id="chefName" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Posisi / Jabatan</label>
                        <input type="text" name="role" id="chefRole" class="form-control" placeholder="Cth: Master Chef" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label text-muted">Biografi Singkat (Tentang Koki)</label>
                        <textarea name="description" id="chefDesc" class="form-control" rows="2" required></textarea>
                    </div>
                </div>
                
                <hr class="text-secondary opacity-25">
                <h6 class="text-muted fw-bold mb-3 mt-2"><i class="bi bi-link-45deg me-1"></i> Tautan Sosial Media (Opsional)</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light text-info"><i class="bi bi-twitter"></i></span>
                            <input type="url" name="social_twitter" id="chefTw" class="form-control" placeholder="https://twitter.com/...">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light text-primary"><i class="bi bi-facebook"></i></span>
                            <input type="url" name="social_fb" id="chefFb" class="form-control" placeholder="https://facebook.com/...">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light text-danger"><i class="bi bi-instagram"></i></span>
                            <input type="url" name="social_ig" id="chefIg" class="form-control" placeholder="https://instagram.com/...">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light text-primary"><i class="bi bi-linkedin"></i></span>
                            <input type="url" name="social_linkedin" id="chefIn" class="form-control" placeholder="https://linkedin.com/...">
                        </div>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label text-muted">Foto Profesional (Potrait)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
          </div>
          <div class="modal-footer border-0 p-4 pt-1">
            <button type="button" class="btn btn-light rounded px-4" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i> Simpan Data</button>
          </div>
      </form>
    </div>
  </div>
</div>

<style>
    .shadow-hover:hover { box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important; transform: translateY(-2px); transition: 0.2s;}
</style>

<script>
function editChef(c) {
    document.getElementById('modalTitle').innerText = 'Perbarui Profil Koki';
    document.getElementById('formAction').value = 'edit';
    document.getElementById('chefId').value = c.id;
    document.getElementById('chefName').value = c.name;
    document.getElementById('chefRole').value = c.role;
    document.getElementById('chefDesc').value = c.description;
    
    document.getElementById('chefTw').value = c.social_twitter || '';
    document.getElementById('chefFb').value = c.social_fb || '';
    document.getElementById('chefIg').value = c.social_ig || '';
    document.getElementById('chefIn').value = c.social_linkedin || '';
    
    document.getElementById('currentImage').value = c.image;
    
    var myModal = new bootstrap.Modal(document.getElementById('chefModal'));
    myModal.show();
}
</script>

<?php require_once 'includes/footer.php'; ?>
