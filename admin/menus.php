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
        $success = "Menu deleted successfully!";
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
        if(empty($imagePath)) $imagePath = 'assets/img/menu/menu-item-1.png'; // Default
        $stmt = $pdo->prepare("INSERT INTO menu_items (category, name, description, price, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$category, $name, $description, $price, $imagePath]);
        $success = "New menu added!";
    } elseif ($_POST['action'] == 'edit') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE menu_items SET category=?, name=?, description=?, price=?, image=? WHERE id=?");
        $stmt->execute([$category, $name, $description, $price, $imagePath, $id]);
        $success = "Menu updated!";
    }
}

$stmt = $pdo->query("SELECT * FROM menu_items ORDER BY id DESC");
$menus = $stmt->fetchAll();

// Dynamic CSS styles for the pill badges
$catColors = [
    'starters' => 'badge-soft-primary',
    'breakfast' => 'badge-soft-warning',
    'lunch' => 'badge-soft-success',
    'dinner' => 'bg-secondary'
];
?>
<div class="d-flex justify-content-between align-items-center mb-4 pb-2">
    <div>
        <h2 class="fw-bold mb-0">Menu List 🙌</h2>
        <p class="text-muted mt-1" style="font-size: 0.9rem;">Manage offering lists efficiently</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#menuModal" onclick="document.getElementById('formAction').value='add'; document.getElementById('menuForm').reset(); document.getElementById('modalTitle').innerText='Add New Order';">
        <i class="bi bi-plus-lg me-1"></i> Add Menu
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
                        <th class="ps-4">Preview</th>
                        <th>Menu Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $menu): ?>
                    <?php $colorBadge = isset($catColors[$menu['category']]) ? $catColors[$menu['category']] : 'bg-secondary'; ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <img src="../<?= htmlspecialchars($menu['image']) ?>" alt="" class="rounded-circle shadow-sm" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid white;">
                        </td>
                        <td class="fw-bold text-dark"><?= htmlspecialchars($menu['name']) ?></td>
                        <td><span class="badge <?= $colorBadge ?> rounded-pill px-3"><?= htmlspecialchars(ucfirst($menu['category'])) ?></span></td>
                        <td class="fw-bold" style="color:var(--text-main);">$ <?= htmlspecialchars($menu['price']) ?></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light rounded-circle shadow-sm text-primary me-2 shadow-hover" onclick="editMenu(<?= htmlspecialchars(json_encode($menu)) ?>)" style="width:35px;height:35px">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="menus.php?delete=<?= $menu['id'] ?>" class="btn btn-sm btn-light rounded-circle shadow-sm text-danger shadow-hover" onclick="return confirm('Silakan konfirmasi penghapusan data ini.');" style="width:35px;height:35px;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($menus)): ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted">No menu items found. Get started by adding one.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="menuModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 10px 40px rgba(0,0,0,0.1)">
      <form method="post" enctype="multipart/form-data" id="menuForm">
          <div class="modal-header border-0 bg-light rounded-top" style="border-radius:20px 20px 0 0; padding:20px 25px;">
            <h5 class="modal-title fw-bold" id="modalTitle">Add Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="id" id="menuId">
                <input type="hidden" name="current_image" id="currentImage">
                
                <div class="mb-3">
                    <label class="form-label text-muted">Menu Name</label>
                    <input type="text" name="name" id="menuName" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Category</label>
                        <select name="category" id="menuCategory" class="form-select text-capitalize">
                            <option value="starters">Starters</option>
                            <option value="breakfast">Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="dinner">Dinner</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Price ($)</label>
                        <input type="number" step="0.01" name="price" id="menuPrice" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Description</label>
                    <textarea name="description" id="menuDesc" class="form-control" rows="2"></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted">Image</label>
                    <div class="input-group">
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
          </div>
          <div class="modal-footer border-0 p-4 pt-1">
            <button type="button" class="btn btn-light rounded px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i> Confirm</button>
          </div>
      </form>
    </div>
  </div>
</div>

<style>
    .shadow-hover:hover { box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important; transform: translateY(-2px); transition: 0.2s;}
</style>

<script>
function editMenu(menu) {
    document.getElementById('modalTitle').innerText = 'Update Menu details';
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
