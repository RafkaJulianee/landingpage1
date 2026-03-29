<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$success = '';

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image FROM events WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    if($stmt->execute([$id])) {
        if($item && file_exists("../" . $item['image']) && strpos($item['image'], 'uploads/') !== false) {
             @unlink("../" . $item['image']);
        }
        $success = "Event berhasil dihapus!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    $imagePath = $_POST['current_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_name = 'event_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/uploads/' . $new_name)) {
                $imagePath = 'assets/img/uploads/' . $new_name;
            }
        }
    }
    
    if ($_POST['action'] == 'add') {
        if(empty($imagePath)) $imagePath = 'assets/img/events-1.jpg';
        $stmt = $pdo->prepare("INSERT INTO events (title, price, description, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $price, $description, $imagePath]);
        $success = "Event baru berhasil ditambahkan!";
    } elseif ($_POST['action'] == 'edit') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE events SET title=?, price=?, description=?, image=? WHERE id=?");
        $stmt->execute([$title, $price, $description, $imagePath, $id]);
        $success = "Event berhasil diperbarui!";
    }
}

$stmt = $pdo->query("SELECT * FROM events ORDER BY id DESC");
$events = $stmt->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Manage Events</h2>
    <button class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#eventModal" onclick="document.getElementById('formAction').value='add'; document.getElementById('eventForm').reset(); document.getElementById('modalTitle').innerText='Add New Event';">
        <i class="bi bi-plus-lg"></i> Add Event
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
                        <th>Title</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                    <tr>
                        <td class="ps-4">
                            <img src="../<?= htmlspecialchars($event['image']) ?>" alt="" class="rounded" style="width: 80px; height: 50px; object-fit: cover;">
                        </td>
                        <td class="fw-bold text-dark"><?= htmlspecialchars($event['title']) ?></td>
                        <td class="text-danger fw-bold">$<?= htmlspecialchars($event['price']) ?></td>
                        <td><small class="text-muted"><?= htmlspecialchars(substr($event['description'], 0, 60)) ?>...</small></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-outline-primary me-2" onclick="editEvent(<?= htmlspecialchars(json_encode($event)) ?>)">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <a href="events.php?delete=<?= $event['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Konfirmasi penghapusan?');">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($events)): ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">No event items found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <form method="post" enctype="multipart/form-data" id="eventForm">
          <div class="modal-header bg-dark text-white border-0">
            <h5 class="modal-title" id="modalTitle">Add Event</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body bg-light">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="id" id="eventId">
                <input type="hidden" name="current_image" id="currentImage">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Event Title</label>
                    <input type="text" name="title" id="eventTitle" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Ticket Price ($)</label>
                    <input type="number" step="1" name="price" id="eventPrice" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" id="eventDesc" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Upload Event Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted d-block mt-1">Leave empty to keep existing image. Recommended: JPG Landscape</small>
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
function editEvent(event) {
    document.getElementById('modalTitle').innerText = 'Edit Event';
    document.getElementById('formAction').value = 'edit';
    document.getElementById('eventId').value = event.id;
    document.getElementById('eventTitle').value = event.title;
    document.getElementById('eventPrice').value = event.price;
    document.getElementById('eventDesc').value = event.description;
    document.getElementById('currentImage').value = event.image;
    
    var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
    myModal.show();
}
</script>

<?php require_once 'includes/footer.php'; ?>
