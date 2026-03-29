<?php
require_once 'includes/db.php';

// Check if chefs empty
$stmt = $pdo->query("SELECT COUNT(*) FROM chefs");
$count = $stmt->fetchColumn();
if ($count == 0) {
    $sql = "INSERT INTO chefs (name, role, description, image) VALUES 
    ('Walter White', 'Master Chef', 'Velit aut quia fugit et et. Dolorum ea voluptate vel tempore tenetur.', 'assets/img/chefs/chefs-1.jpg'),
    ('Sarah Jhonson', 'Patissier', 'Quo esse repellendus quia id. Est eum et accusantium pariatur fugit.', 'assets/img/chefs/chefs-2.jpg'),
    ('William Anderson', 'Cook', 'Vero omnis enim consequatur. Voluptas consectetur unde qui molestiae.', 'assets/img/chefs/chefs-3.jpg')";
    $pdo->exec($sql);
}

// Check if gallery empty
$stmt = $pdo->query("SELECT COUNT(*) FROM gallery");
$count = $stmt->fetchColumn();
if ($count == 0) {
    $sql = "INSERT INTO gallery (image) VALUES 
    ('assets/img/gallery/gallery-1.jpg'),
    ('assets/img/gallery/gallery-2.jpg'),
    ('assets/img/gallery/gallery-3.jpg'),
    ('assets/img/gallery/gallery-4.jpg'),
    ('assets/img/gallery/gallery-5.jpg'),
    ('assets/img/gallery/gallery-6.jpg'),
    ('assets/img/gallery/gallery-7.jpg'),
    ('assets/img/gallery/gallery-8.jpg')";
    $pdo->exec($sql);
}

// Check if testimonials empty
$stmt = $pdo->query("SELECT COUNT(*) FROM testimonials");
$count = $stmt->fetchColumn();
if ($count == 0) {
    $sql = "INSERT INTO testimonials (name, role, content, rating, image) VALUES 
    ('Saul Goodman', 'Freelancer', 'Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit.', 5, 'assets/img/testimonials/testimonials-1.jpg'),
    ('Sara Wilsson', 'Designer', 'Export tempor illum tamen malis malis eram quae irure esse labore.', 4, 'assets/img/testimonials/testimonials-2.jpg'),
    ('Jena Karlis', 'Store Owner', 'Enim nisi quem export duis labore cillum quae magna enim sint.', 5, 'assets/img/testimonials/testimonials-3.jpg')";
    $pdo->exec($sql);
}

echo "Dummy data populated.";
?>
