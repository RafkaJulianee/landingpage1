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
        $success = "Event deleted successfully!";
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
        if(empty($imagePath)) $imagePath = 'assets/img/events-1.jpg'; // default
        $stmt = $pdo->prepare("INSERT INTO events (title, price, description, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $price, $description, $imagePath]);
        $success = "New Event added successfully!";
    } elseif ($_POST['action'] == 'edit') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE events SET title=?, price=?, description=?, image=? WHERE id=?");
        $stmt->execute([$title, $price, $description, $imagePath, $id]);
        $success = "Event updated!";
    }
}

$stmt = $pdo->query("SELECT * FROM events ORDER BY id DESC");
$events = $stmt->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-4 pb-2">
    <div>
        <h2 class="fw-bold mb-0">Events Schedule 🗓️</h2>
        <p class="text-muted mt-1" style="font-size: 0.9rem;">Maintain special occasions easily</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal" onclick="document.getElementById('formAction').value='add'; document.getElementById('eventForm').reset(); document.getElementById('modalTitle').innerText='Create New Event';">
        <i class="bi bi-calendar-plus me-1"></i> Add Event
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
                        <th class="ps-4">Banner Preview</th>
                        <th>Event Title</th>
                        <th>Pricing Scheme</th>
                        <th>Brief description</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <img src="../<?= htmlspecialchars($event['image']) ?>" alt="" class="rounded shadow-sm" style="width: 80px; height: 50px; object-fit: cover; border: 2px solid white;">
                        </td>
                        <td class="fw-bold text-dark w-25"><?= htmlspecialchars($event['title']) ?></td>
                        <td class="fw-bold text-primary">$<?= htmlspecialchars($event['price']) ?></td>
                        <td class="text-muted" style="font-size: 0.85rem;"><span class="d-inline-block text-truncate" style="max-width: 200px;"><?= htmlspecialchars($event['description']) ?></span></td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light rounded-circle shadow-sm text-primary me-2 shadow-hover" onclick="editEvent(<?= htmlspecialchars(json_encode($event)) ?>)" style="width:35px;height:35px">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="events.php?delete=<?= $event['id'] ?>" class="btn btn-sm btn-light rounded-circle shadow-sm text-danger shadow-hover" onclick="return confirm('Silakan konfirmasi penghapusan data ini.');" style="width:35px;height:35px;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($events)): ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted">No events found. Time to organize a party!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px; border:none; box-shadow:0 10px 40px rgba(0,0,0,0.1)">
      <form method="post" enctype="multipart/form-data" id="eventForm">
          <div class="modal-header border-0 bg-light rounded-top" style="border-radius:20px 20px 0 0; padding:20px 25px;">
            <h5 class="modal-title fw-bold" id="modalTitle">Add Event</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="id" id="eventId">
                <input type="hidden" name="current_image" id="currentImage">
                
                <div class="mb-4">
                    <label class="form-label text-muted">Event Title</label>
                    <input type="text" name="title" id="eventTitle" class="form-control" placeholder="e.g. Birthday Bash" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted">Ticket Price / Package ($)</label>
                    <input type="number" step="1" name="price" id="eventPrice" class="form-control" placeholder="0 if free" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted">Description & Details</label>
                    <textarea name="description" id="eventDesc" class="form-control" rows="4" placeholder="Briefly describe the occasion..." required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Event Photo Banner</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted mt-2 d-block">Optimized for wide/landscape resolutions</small>
                </div>
          </div>
          <div class="modal-footer border-0 p-4 pt-1">
            <button type="button" class="btn btn-light rounded px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-calendar-check me-2"></i> Save Event</button>
          </div>
      </form>
    </div>
  </div>
</div>

<style>
    .shadow-hover:hover { box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important; transform: translateY(-2px); transition: 0.2s;}
</style>

<script>
function editEvent(event) {
    document.getElementById('modalTitle').innerText = 'Update Event Details';
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
