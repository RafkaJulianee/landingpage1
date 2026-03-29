<?php
$host = 'localhost';
// Saya mengasumsikan nama database Anda adalah landingpage1 karena Anda mengubah nama file SQL-nya
// Jika salah, ubah 'landingpage1' menjadi nama database yang tepat di Laragon Anda
$dbname = 'landingpage1';
$username = 'root'; // Default Laragon
$password = '';     // Default Laragon

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal. Pastikan database '$dbname' sudah dibuat di Laragon dan MySQL menyala. Error: " . $e->getMessage());
}
?>
