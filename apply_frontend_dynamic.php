<?php
// Script to replace all static text in index.php with dynamic variables from $settings
$content = file_get_contents('index.php');

$replacements = [
    // Navbar
    'Beranda</a>' => "<?= htmlspecialchars(\$settings['text_nav_home'] ?? 'Beranda') ?></a>",
    'Tentang Kami</a>' => "<?= htmlspecialchars(\$settings['text_nav_about'] ?? 'Tentang Kami') ?></a>",
    'Menu</a>' => "<?= htmlspecialchars(\$settings['text_nav_menu'] ?? 'Menu') ?></a>",
    'Acara</a>' => "<?= htmlspecialchars(\$settings['text_nav_events'] ?? 'Acara') ?></a>",
    'Koki</a>' => "<?= htmlspecialchars(\$settings['text_nav_chefs'] ?? 'Koki') ?></a>",
    'Galeri</a>' => "<?= htmlspecialchars(\$settings['text_nav_gallery'] ?? 'Galeri') ?></a>",
    'Kontak</a>' => "<?= htmlspecialchars(\$settings['text_nav_contact'] ?? 'Kontak') ?></a>",
    'Pesan Meja</a>' => "<?= htmlspecialchars(\$settings['text_nav_book'] ?? 'Pesan Meja') ?></a>",
    'class="btn-book-a-table">Pesan Meja</a>' => 'class="btn-book-a-table"><?= htmlspecialchars($settings[\'text_nav_book\'] ?? \'Pesan Meja\') ?></a>',

    // Hero
    'Nikmati Makanan Sehat<br>& Lezat Kami' => '<?= $settings[\'hero_title\'] ?? \'Nikmati Makanan Sehat<br>& Lezat Kami\' ?>',
    'Tonton Video' => '<?= htmlspecialchars($settings[\'text_watch_video\'] ?? \'Tonton Video\') ?>',

    // About
    '<h2>Tentang Kami</h2>' => '<h2><?= htmlspecialchars($settings[\'text_nav_about\'] ?? \'Tentang Kami\') ?></h2>',
    'Bahan-bahan segar yang dimasak dengan penuh cinta dan dedikasi.' => '<?= htmlspecialchars($settings[\'about_point_1\'] ?? \'Bahan-bahan segar yang dimasak dengan penuh cinta dan dedikasi.\') ?>',
    'Suasana restoran yang nyaman untuk setiap perayaan Anda.' => '<?= htmlspecialchars($settings[\'about_point_2\'] ?? \'Suasana restoran yang nyaman untuk setiap perayaan Anda.\') ?>',
    'Pelayanan ramah yang siap menyambut Anda bagaikan di rumah sendiri.' => '<?= htmlspecialchars($settings[\'about_point_3\'] ?? \'Pelayanan ramah yang siap menyambut Anda bagaikan di rumah sendiri.\') ?>',
    'https://www.youtube.com/watch?v=LXb3EKWsInQ' => '<?= htmlspecialchars($settings[\'about_video_link\'] ?? \'https://www.youtube.com/watch?v=LXb3EKWsInQ\') ?>',
    '<h4>Pesan Meja</h4>' => '<h4><?= htmlspecialchars($settings[\'text_nav_book\'] ?? \'Pesan Meja\') ?></h4>',
    '<p>+1 5589 55488 55</p>' => '<p><?= htmlspecialchars($settings[\'contact_phone\'] ?? \'+1 5589 55488 55\') ?></p>',

    // Why Us
    '<h3>Why Choose Yummy?</h3>' => '<h3><?= htmlspecialchars($settings[\'why_us_title\'] ?? \'Mengapa Memilih Kami?\') ?></h3>',
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Duis aute irure dolor in reprehenderit
                Asperiores dolores sed et. Tenetur quia eos. Autem tempore quibusdam vel necessitatibus optio ad
                corporis.' => '<?= nl2br(htmlspecialchars($settings[\'why_us_desc\'] ?? \'Kami menyajikan yang terbaik untuk Anda.\')) ?>',
    '<h4>Corporis voluptates officia eiusmod</h4>' => '<h4><?= htmlspecialchars($settings[\'why_us_box1_title\'] ?? \'Kualitas Premium\') ?></h4>',
    '<p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>' => '<p><?= htmlspecialchars($settings[\'why_us_box1_desc\'] ?? \'Hanya bahan terbaik.\') ?></p>',
    
    '<h4>Ullamco laboris ladore pan</h4>' => '<h4><?= htmlspecialchars($settings[\'why_us_box2_title\'] ?? \'Resep Asli\') ?></h4>',
    '<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>' => '<p><?= htmlspecialchars($settings[\'why_us_box2_desc\'] ?? \'Rahasia turun temurun.\') ?></p>',
    
    '<h4>Labore consequatur incidid dolore</h4>' => '<h4><?= htmlspecialchars($settings[\'why_us_box3_title\'] ?? \'Koki Handal\') ?></h4>',
    '<p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>' => '<p><?= htmlspecialchars($settings[\'why_us_box3_desc\'] ?? \'Profesional bersertifikasi.\') ?></p>',

    // Stats
    'data-purecounter-end="232"' => 'data-purecounter-end="<?= (int)($settings[\'stats_1_num\'] ?? 232) ?>"',
    '<p>Pelanggan</p>' => '<p><?= htmlspecialchars($settings[\'stats_1_label\'] ?? \'Pelanggan\') ?></p>',
    
    'data-purecounter-end="521"' => 'data-purecounter-end="<?= (int)($settings[\'stats_2_num\'] ?? 521) ?>"',
    '<p>Proyek</p>' => '<p><?= htmlspecialchars($settings[\'stats_2_label\'] ?? \'Proyek\') ?></p>',
    
    'data-purecounter-end="1453"' => 'data-purecounter-end="<?= (int)($settings[\'stats_3_num\'] ?? 1453) ?>"',
    '<p>Jam Layanan</p>' => '<p><?= htmlspecialchars($settings[\'stats_3_label\'] ?? \'Jam Layanan\') ?></p>',
    
    'data-purecounter-end="32"' => 'data-purecounter-end="<?= (int)($settings[\'stats_4_num\'] ?? 32) ?>"',
    '<p>Karyawan</p>' => '<p><?= htmlspecialchars($settings[\'stats_4_label\'] ?? \'Karyawan Penuh\') ?></p>',

    // Footer
    '&copy; Copyright <strong><span>Yummy</span></strong>. Hak Cipta Dilindungi' => '&copy; Copyright <strong><span><?= htmlspecialchars($settings[\'footer_copyright\'] ?? \'Yummy\') ?></span></strong>. Hak Cipta Dilindungi',
    'Didesain oleh <a href="https://bootstrapmade.com/">Webdevelopment657</a>' => '<?= htmlspecialchars($settings[\'footer_slogan\'] ?? \'Kami menanti kedatangan Anda kembali.\') ?>'

];

// Simple Text Replacements
foreach ($replacements as $search => $replace) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
    }
}

// Complex Array Replacements for Testimonials, Chefs, Gallery
// 1. CHEFS
$chefs_pattern = '/<div class="row gy-4">\s*(<div class="col-lg-4 col-md-6 d-flex align-items-stretch"[\s\S]*?)<\/div>\s*<\/div>\s*<\/section><!-- End Chefs Section -->/i';
$chefs_replacement = <<< 'HTML'
<div class="row gy-4">
          <?php
            $stmt = $pdo->query("SELECT * FROM chefs ORDER BY id ASC");
            $chefs = $stmt->fetchAll();
          ?>
          <?php foreach($chefs as $chef): ?>
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="chef-member">
              <div class="member-img">
                <img src="<?= htmlspecialchars($chef['image']) ?>" class="img-fluid" alt="">
                <div class="social">
                  <?php if($chef['social_twitter']): ?><a href="<?= htmlspecialchars($chef['social_twitter']) ?>"><i class="bi bi-twitter"></i></a><?php endif; ?>
                  <?php if($chef['social_fb']): ?><a href="<?= htmlspecialchars($chef['social_fb']) ?>"><i class="bi bi-facebook"></i></a><?php endif; ?>
                  <?php if($chef['social_ig']): ?><a href="<?= htmlspecialchars($chef['social_ig']) ?>"><i class="bi bi-instagram"></i></a><?php endif; ?>
                  <?php if($chef['social_linkedin']): ?><a href="<?= htmlspecialchars($chef['social_linkedin']) ?>"><i class="bi bi-linkedin"></i></a><?php endif; ?>
                </div>
              </div>
              <div class="member-info">
                <h4><?= htmlspecialchars($chef['name']) ?></h4>
                <span><?= htmlspecialchars($chef['role']) ?></span>
                <p><?= htmlspecialchars($chef['description']) ?></p>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

      </div>
    </section><!-- End Chefs Section -->
HTML;
$content = preg_replace($chefs_pattern, $chefs_replacement, $content);

// 2. GALLERY
$gallery_pattern = '/<div class="swiper-wrapper align-items-center">\s*(<div class="swiper-slide">[\s\S]*?)<\/div>\s*<div class="swiper-pagination"><\/div>/i';
$gallery_replacement = <<< 'HTML'
<div class="swiper-wrapper align-items-center">
            <?php
              $stmt = $pdo->query("SELECT * FROM gallery ORDER BY id DESC");
              $galleries = $stmt->fetchAll();
            ?>
            <?php foreach($galleries as $g): ?>
            <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="<?= htmlspecialchars($g['image']) ?>"><img src="<?= htmlspecialchars($g['image']) ?>" class="img-fluid" alt=""></a></div>
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
HTML;
$content = preg_replace($gallery_pattern, $gallery_replacement, $content);

// 3. TESTIMONIALS (Currently mapped to events by accident, let's fix)
// We need to carefully target the Testimonials swiper wrapper
// Look for <!-- ======= Testimonials Section ======= --> and replace the inner content
$testi_pattern = '/<div class="slides-1 swiper" data-aos="fade-up" data-aos-delay="100">\s*<div class="swiper-wrapper">[\s\S]*?<\/div>\s*<div class="swiper-pagination"><\/div>\s*<\/div>/i';
$testi_replacement = <<< 'HTML'
<div class="slides-1 swiper" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper-wrapper">
          <?php
            $stmt = $pdo->query("SELECT * FROM testimonials");
            $testimonials = $stmt->fetchAll();
          ?>
          <?php foreach ($testimonials as $t): ?>
          <div class="swiper-slide">
            <div class="testimonial-item">
              <div class="row gy-4 justify-content-center">
                <div class="col-lg-6">
                  <div class="testimonial-content">
                    <p>
                      <i class="bi bi-quote quote-icon-left"></i>
                      <?= htmlspecialchars($t['content']) ?>
                      <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                    <h3><?= htmlspecialchars($t['name']) ?></h3>
                    <h4><?= htmlspecialchars($t['role']) ?></h4>
                    <div class="stars">
                      <?php for($i=0; $i<$t['rating']; $i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-2 text-center">
                  <img src="<?= htmlspecialchars($t['image']) ?>" class="img-fluid testimonial-img" alt="" style="border-radius: 50%; border: 4px solid rgba(255, 255, 255, 0.2); width: 120px; height: 120px; object-fit: cover;">
                </div>
              </div>
            </div>
          </div><!-- End testimonial item -->
          <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
HTML;
$content = preg_replace($testi_pattern, $testi_replacement, $content);

file_put_contents('index.php', $content);
echo "index.php successfully made 100% dynamic.\n";
?>
