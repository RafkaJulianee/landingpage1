<?php
$file = 'index.php';
$content = file_get_contents($file);

$replacements = [
    // Navbar
    'Home</a>' => 'Beranda</a>',
    'About</a>' => 'Tentang Kami</a>',
    'Menu</a>' => 'Menu</a>',
    'Events</a>' => 'Acara</a>',
    'Chefs</a>' => 'Koki</a>',
    'Gallery</a>' => 'Galeri</a>',
    'Drop Down' => 'Menu Utama',
    'Deep Drop Down' => 'Sub Menu',
    'Contact</a>' => 'Kontak</a>',
    'Book a Table' => 'Pesan Meja',

    // Hero
    'Enjoy Your Healthy<br>Delicious Food' => 'Nikmati Makanan Sehat<br>& Lezat Kami',
    'Watch Video' => 'Tonton Video',

    // About
    '<h2>About Us</h2>' => '<h2>Tentang Kami</h2>',
    'Learn More <span>About Us</span>' => 'Pelajari Lebih Lanjut <span>Tentang Kami</span>',
    'Lorem ipsum dolor sit amet' => 'Kami percaya bahwa makanan bukan sekadar pengisi perut, melainkan pengalaman yang patut dirayakan.',
    'Ullamco laboris nisi ut aliquip ex ea commodo consequat.' => 'Bahan-bahan segar yang dimasak dengan penuh cinta dan dedikasi.',
    'Duis aute irure dolor in reprehenderit in voluptate velit.' => 'Suasana restoran yang nyaman untuk setiap perayaan Anda.',
    'Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.' => 'Pelayanan ramah yang siap menyambut Anda bagaikan di rumah sendiri.',

    // Stats
    '<p>Clients</p>' => '<p>Pelanggan</p>',
    '<p>Projects</p>' => '<p>Proyek</p>',
    '<p>Hours Of Support</p>' => '<p>Jam Layanan</p>',
    '<p>Workers</p>' => '<p>Karyawan</p>',

    // Menu section
    '<h2>Our Menu</h2>' => '<h2>Menu Kami</h2>',
    'Check Our <span>Yummy Menu</span>' => 'Cek <span>Menu Lezat Kami</span>',
    '<h4>Starters</h4>' => '<h4>Camilan</h4>',
    '<h4>Breakfast</h4>' => '<h4>Sarapan</h4>',
    '<h4>Lunch</h4>' => '<h4>Makan Siang</h4>',
    '<h4>Dinner</h4>' => '<h4>Makan Malam</h4>',
    '<p>Menu</p>' => '<p>Menu</p>',
    '\'starters\' => \'Starters\'' => '\'starters\' => \'Camilan\'',
    '\'breakfast\' => \'Breakfast\'' => '\'breakfast\' => \'Sarapan\'',
    '\'lunch\' => \'Lunch\'' => '\'lunch\' => \'Makan Siang\'',
    '\'dinner\' => \'Dinner\'' => '\'dinner\' => \'Makan Malam\'',

    // Testimonials
    '<h2>Testimonials</h2>' => '<h2>Testimoni</h2>',
    'What Are They <span>Saying About Us</span>' => 'Apa yang Mereka <span>Katakan Tentang Kami</span>',

    // Events
    '<h2>Events</h2>' => '<h2>Acara</h2>',
    'Share <span>Your Moments</span> In Our Restaurant' => 'Bagikan <span>Momen Anda</span> di Restoran Kami',

    // Chefs
    '<h2>Chefs</h2>' => '<h2>Koki</h2>',
    'Our <span>Proffesional</span> Chefs' => 'Koki <span>Profesional</span> Kami',
    'Master Chef' => 'Koki Utama',
    'Patissier' => 'Ahli Pastry',
    'Cook' => 'Koki',

    // Book table
    '<h2>Book A Table</h2>' => '<h2>Pesan Meja</h2>',
    'Book <span>Your Stay</span> With Us' => 'Pesan <span>Tempat Anda</span> Bersama Kami',
    'Your Name' => 'Nama Anda',
    'Your Email' => 'Email Anda',
    'Your Phone' => 'Telepon Anda',
    'Date' => 'Tanggal',
    'Time' => 'Waktu',
    '# of people' => 'Jml Orang',
    'Message' => 'Pesan Tambahan',
    'Your booking request was sent.' => 'Permintaan pesanan Anda telah terkirim.',

    // Gallery
    '<h2>gallery</h2>' => '<h2>Galeri</h2>',
    'Check <span>Our Gallery</span>' => 'Lihat <span>Galeri Kami</span>',

    // Contact
    '<h2>Contact</h2>' => '<h2>Kontak</h2>',
    'Need Help? <span>Contact Us</span>' => 'Butuh Bantuan? <span>Hubungi Kami</span>',
    '<h3>Our Address</h3>' => '<h3>Alamat Kami</h3>',
    '<h3>Email Us</h3>' => '<h3>Email Kami</h3>',
    '<h3>Call Us</h3>' => '<h3>Hubungi Kami</h3>',
    '<h3>Opening Hours</h3>' => '<h3>Jam Buka</h3>',
    'Subject' => 'Subjek',
    'Send Message' => 'Kirim Pesan',
    'Your message has been sent. Thank you!' => 'Pesan Anda telah dikirim. Terima kasih!',

    // Footer
    '<h4>Address</h4>' => '<h4>Alamat</h4>',
    '<h4>Reservations</h4>' => '<h4>Reservasi</h4>',
    '<h4>Opening Hours</h4>' => '<h4>Jam Buka</h4>',
    '<h4>Follow Us</h4>' => '<h4>Ikuti Kami</h4>',
    '<strong>Phone:</strong>' => '<strong>Telepon:</strong>',
    '<strong>Email:</strong>' => '<strong>Email:</strong>',
    'Sunday: Closed' => 'Minggu: Tutup',
    'All Rights Reserved' => 'Hak Cipta Dilindungi',
    'Designed by' => 'Didesain oleh'
];

foreach ($replacements as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}

file_put_contents($file, $content);
echo "Frontend translation complete.";
?>
