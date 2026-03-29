<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$success = '';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM menu_items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
    if($stmt->execute([$id])) {
        if($item && file_exists("../" . $item['image']) && strpos($item['image'], 'uploads/') !== false) {
             @unlink("../" . $item['image']);
        }
        $success = "Menu berhasil dihapus!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    $imagePath = $_POST['current_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_name = 'menu_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/uploads/' . $new_name)) {
                $imagePath = 'assets/img/uploads/' . $new_name;
            }
        }
    }
    
    if ($_POST['action'] == 'add') {
        if(empty($imagePath)) $imagePath = 'assets/img/menu/menu-item-1.png';
        $stmt = $pdo->prepare("INSERT INTO menu_items (category, name, description, price, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$category, $name, $description, $price, $imagePath]);
        $success = "Menu baru berhasil ditambahkan!";
    } elseif ($_POST['action'] == 'edit') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE menu_items SET category=?, name=?, description=?, price=?, image=? WHERE id=?");
        $stmt->execute([$category, $name, $description, $price, $imagePath, $id]);
        $success = "Menu berhasil diperbarui!";
    }
}

$stmt = $pdo->query("SELECT * FROM menu_items ORDER BY id DESC");
$menus = $stmt->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Manage Menus</h2>
    <button class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#menuModal" onclick="document.getElementById('formAction').value='add'; document.getElementById('menuForm').reset(); document.getElementById('modalTitle').innerText='Add New Menu';">
        <i class="bi bi-plus-lg"></i> Add Menu
    </button>
</div>

<?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm"><i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($success) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $menu): ?>
                    <tr>
                        <td class="ps-4">
                            <img src="../<?= htmlspecialchars($menu['image']) ?>" alt="" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td class="fw-bold text-dark"><?= htmlspecialchars($menu['name']) ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($menu['category']) ?></span></td>
                        <td class="text-danger fw-bold">$<?= htmlspecialchars($menu['price']) ?></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-primary me-2" onclick="editMenu(<?= htmlspecialchars(json_encode($menu)) ?>)">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <a href="menus.php?delete=<?= $menu['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Konfirmasi penghapusan?');">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($menus)): ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">No menu items found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="menuModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <form method="post" enctype="multipart/form-data" id="menuForm">
          <div class="modal-header bg-dark text-white border-0">
            <h5 class="modal-title" id="modalTitle">Add Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body bg-light">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="id" id="menuId">
                <input type="hidden" name="current_image" id="currentImage">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Menu Name</label>
                    <input type="text" name="name" id="menuName" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category" id="menuCategory" class="form-select">
                            <option value="starters">Starters</option>
                            <option value="breakfast">Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="dinner">Dinner</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Price ($)</label>
                        <input type="number" step="0.01" name="price" id="menuPrice" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description Ingredients</label>
                    <textarea name="description" id="menuDesc" class="form-control" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Upload Food Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Leave empty to keep existing image</small>
                </div>
          </div>
          <div class="modal-footer border-0 bg-light">
            <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger w-25 shadow-sm">Save</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
function editMenu(menu) {
    document.getElementById('modalTitle').innerText = 'Edit Menu';
    document.getElementById('formAction').value = 'edit';
    document.getElementById('menuId').value = menu.id;
    document.getElementById('menuName').value = menu.name;
    document.getElementById('menuCategory').value = menu.category;
    document.getElementById('menuPrice').value = menu.price;
    document.getElementById('menuDesc').value = menu.description;
    document.getElementById('currentImage').value = menu.image;
    
    var myModal = new bootstrap.Modal(document.getElementById('menuModal'));
    myModal.show();
}
</script>

<?php require_once 'includes/footer.php'; ?>
