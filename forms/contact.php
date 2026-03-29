<?php
// Validasi jika data tidak dikirim lewat POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(403);
  echo "Akses tidak valid.";
  exit;
}

// Ambil data dari form
$name    = htmlspecialchars($_POST['name']);
$email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars($_POST['subject']);
$message = htmlspecialchars($_POST['message']);

// Validasi wajib
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
  http_response_code(400);
  echo "Harap isi semua field.";
  exit;
}

// Email tujuan (GANTI dengan email kamu)
$to = "aikotanakae@gmail.com.com";

// Format email
$email_subject = "Pesan Baru dari $name: $subject";
$email_headers = "From: $name <$email>\r\n";
$email_headers .= "Reply-To: $email\r\n";
$email_headers .= "X-Mailer: PHP/" . phpversion();

$email_body = "Nama: $name\n";
$email_body .= "Email: $email\n";
$email_body .= "Subjek: $subject\n\n";
$email_body .= "Pesan:\n$message\n";

// Kirim email
if (mail($to, $email_subject, $email_body, $email_headers)) {
  http_response_code(200);
  echo "Pesan berhasil dikirim!";
} else {
  http_response_code(500);
  echo "Terjadi kesalahan saat mengirim pesan.";
}
?>
