<?php
require_once 'includes/db.php';
// Fetch general settings
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
<title><?= htmlspecialchars($settings['site_title'] ?? 'Zifood') ?></title>
<meta content="" name="description">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="Shift.jpeg" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
  href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
  rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">


</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-lg-0">
        
        <h1><?= htmlspecialchars($settings['site_title'] ?? 'Zifood') ?><span>.</span></h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="#hero"><?= htmlspecialchars($settings['text_nav_home'] ?? 'Beranda') ?></a></li>
          <li><a href="#about"><?= htmlspecialchars($settings['text_nav_about'] ?? 'Tentang Kami') ?></a></li>
          <li><a href="#menu"><?= htmlspecialchars($settings['text_nav_menu'] ?? 'Menu') ?></a></li>
          <li><a href="#events"><?= htmlspecialchars($settings['text_nav_events'] ?? 'Acara') ?></a></li>
          <li><a href="#chefs"><?= htmlspecialchars($settings['text_nav_chefs'] ?? 'Koki') ?></a></li>
          <li><a href="#gallery"><?= htmlspecialchars($settings['text_nav_gallery'] ?? 'Galeri') ?></a></li>
          <li class="dropdown"><a href="#"><span>Menu Utama</span> <i
                class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="#">Menu Utama 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Menu Utama</span> <i
                    class="bi bi-chevron-down dropdown-indicator"></i></a>
                <ul>
                  <li><a href="#">Deep Menu Utama 1</a></li>
                  <li><a href="#">Deep Menu Utama 2</a></li>
                  <li><a href="#">Deep Menu Utama 3</a></li>
                  <li><a href="#">Deep Menu Utama 4</a></li>
                  <li><a href="#">Deep Menu Utama 5</a></li>
                </ul>
              </li>
              <li><a href="#">Menu Utama 2</a></li>
              <li><a href="#">Menu Utama 3</a></li>
              <li><a href="#">Menu Utama 4</a></li>
            </ul>
          </li>
          <li><a href="#contact"><?= htmlspecialchars($settings['text_nav_contact'] ?? 'Kontak') ?></a></li>
        </ul>
      </nav><!-- .navbar -->

      <a class="btn-book-a-table" href="#book-a-table"><?= htmlspecialchars($settings['text_nav_book'] ?? 'Pesan Meja') ?></a>
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center section-bg">
    <div class="container">
      <div class="row justify-content-between gy-5">
        <div
          class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
          <h2 data-aos="fade-up"><?= $settings['hero_title'] ?? '<?= $settings['hero_title'] ?? 'Nikmati Makanan Sehat<br>& Lezat Kami' ?>' ?></h2>
          <p data-aos="fade-up" data-aos-delay="100"><?= htmlspecialchars($settings['hero_subtitle'] ?? '') ?></p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <a href="#book-a-table" class="btn-book-a-table"><?= htmlspecialchars($settings['text_nav_book'] ?? 'Pesan Meja') ?></a>
            <a href="<?= htmlspecialchars($settings['about_video_link'] ?? 'https://www.youtube.com/watch?v=LXb3EKWsInQ') ?>"
              class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch
                Video</span></a>
          </div>
        </div>
        <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">
          <?php $hero_img_path = !empty($settings['hero_img']) ? $settings['hero_img'] : 'assets/img/hero-img.png'; ?>
          <img src="<?= htmlspecialchars($hero_img_path) ?>" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="300">
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2><?= htmlspecialchars($settings['text_nav_about'] ?? 'Tentang Kami') ?></h2>
          <p>Pelajari Lebih Lanjut <span>Tentang Kami</span></p>
        </div>

        <div class="row gy-4">
          <?php $about_img_path = !empty($settings['about_img']) ? $settings['about_img'] : 'assets/img/about.jpg'; ?>
          <div class="col-lg-7 position-relative about-img" style="background-image: url(<?= htmlspecialchars($about_img_path) ?>) ;"
            data-aos="fade-up" data-aos-delay="150">
            <div class="call-us position-absolute">
              <h4><?= htmlspecialchars($settings['text_nav_book'] ?? 'Pesan Meja') ?></h4>
              <p><?= htmlspecialchars($settings['contact_phone'] ?? '+1 5589 55488 55') ?></p>
            </div>
          </div>
          <div class="col-lg-5 d-flex align-items-end" data-aos="fade-up" data-aos-delay="300">
            <div class="content ps-0 ps-lg-5">
              <p class="fst-italic">
                Kami percaya bahwa makanan bukan sekadar pengisi perut, melainkan pengalaman yang patut dirayakan., consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore
                magna aliqua.
              </p>
              <ul>
                <li><i class="bi bi-check2-all"></i> <?= htmlspecialchars($settings['about_point_1'] ?? 'Bahan-bahan segar yang dimasak dengan penuh cinta dan dedikasi.') ?></li>
                <li><i class="bi bi-check2-all"></i> <?= htmlspecialchars($settings['about_point_2'] ?? 'Suasana restoran yang nyaman untuk setiap perayaan Anda.') ?></li>
                <li><i class="bi bi-check2-all"></i> <?= htmlspecialchars($settings['about_point_1'] ?? 'Bahan-bahan segar yang dimasak dengan penuh cinta dan dedikasi.') ?> Duis aute
                  irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla
                  pariatur.</li>
              </ul>
              <p>
                <?= nl2br(htmlspecialchars($settings['about_text'] ?? '')) ?>
              </p>

              <div class="position-relative mt-4">
                <img src="assets/img/about-2.jpg" class="img-fluid" alt="">
                <a href="<?= htmlspecialchars($settings['about_video_link'] ?? 'https://www.youtube.com/watch?v=LXb3EKWsInQ') ?>" class="glightbox play-btn"></a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us section-bg">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="why-box">
              <h3><?= htmlspecialchars($settings['why_us_title'] ?? 'Mengapa Memilih Kami?') ?></h3>
              <p>
                Kami percaya bahwa makanan bukan sekadar pengisi perut, melainkan pengalaman yang patut dirayakan., consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Duis aute irure dolor in reprehenderit
                Asperiores dolores sed et. Tenetur quia eos. Autem tempore quibusdam vel necessitatibus optio ad
                corporis.
              </p>
              <div class="text-center">
                <a href="#" class="more-btn">Learn More <i class="bx bx-chevron-right"></i></a>
              </div>
            </div>
          </div><!-- End Why Box -->

          <div class="col-lg-8 d-flex align-items-center">
            <div class="row gy-4">

              <div class="col-xl-4" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <i class="bi bi-clipboard-data"></i>
                  <h4><?= htmlspecialchars($settings['why_us_box1_title'] ?? 'Kualitas Premium') ?></h4>
                  <p><?= htmlspecialchars($settings['why_us_box1_desc'] ?? 'Hanya bahan terbaik.') ?></p>
                </div>
              </div><!-- End Icon Box -->

              <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <i class="bi bi-gem"></i>
                  <h4><?= htmlspecialchars($settings['why_us_box2_title'] ?? 'Resep Asli') ?></h4>
                  <p><?= htmlspecialchars($settings['why_us_box2_desc'] ?? 'Rahasia turun temurun.') ?></p>
                </div>
              </div><!-- End Icon Box -->

              <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                  <i class="bi bi-inboxes"></i>
                  <h4><?= htmlspecialchars($settings['why_us_box3_title'] ?? 'Koki Handal') ?></h4>
                  <p><?= htmlspecialchars($settings['why_us_box3_desc'] ?? 'Profesional bersertifikasi.') ?></p>
                </div>
              </div><!-- End Icon Box -->

            </div>
          </div>

        </div>

      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= Stats Counter Section ======= -->
    <section id="stats-counter" class="stats-counter">
      <div class="container" data-aos="zoom-out">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="<?= (int)($settings['stats_1_num'] ?? 232) ?>" data-purecounter-duration="1"
                class="purecounter"></span>
              <p><?= htmlspecialchars($settings['stats_1_label'] ?? 'Pelanggan') ?></p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="<?= (int)($settings['stats_2_num'] ?? 521) ?>" data-purecounter-duration="1"
                class="purecounter"></span>
              <p><?= htmlspecialchars($settings['stats_2_label'] ?? 'Proyek') ?></p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="<?= (int)($settings['stats_3_num'] ?? 1453) ?>" data-purecounter-duration="1"
                class="purecounter"></span>
              <p><?= htmlspecialchars($settings['stats_3_label'] ?? 'Jam Layanan') ?></p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="<?= (int)($settings['stats_4_num'] ?? 32) ?>" data-purecounter-duration="1"
                class="purecounter"></span>
              <p><?= htmlspecialchars($settings['stats_4_label'] ?? 'Karyawan Penuh') ?></p>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>
    </section><!-- End Stats Counter Section -->

    <!-- ======= Menu Section ======= -->
    <section id="menu" class="menu">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Menu Kami</h2>
          <p>Cek <span>Menu Lezat Kami</span></p>
        </div>

        <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">

          <li class="nav-item">
            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#menu-starters">
              <h4>Camilan</h4>
            </a>
          </li><!-- End tab nav item -->

          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-breakfast">
              <h4>Sarapan</h4>
            </a><!-- End tab nav item -->

          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-lunch">
              <h4>Makan Siang</h4>
            </a>
          </li><!-- End tab nav item -->

          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-dinner">
              <h4>Makan Malam</h4>
            </a>
          </li><!-- End tab nav item -->

        </ul>

        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
          <?php
            $stmt = $pdo->query("SELECT * FROM menu_items");
            $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categories = [
                'starters' => 'Camilan',
                'breakfast' => 'Sarapan',
                'lunch' => 'Makan Siang',
                'dinner' => 'Makan Malam'
            ];
            $first = true;
          ?>
          <?php foreach ($categories as $cat_key => $cat_name): ?>
          <div class="tab-pane fade <?= $first ? 'active show' : '' ?>" id="menu-<?= $cat_key ?>">
            <div class="tab-header text-center">
              <p>Menu</p>
              <h3><?= htmlspecialchars($cat_name) ?></h3>
            </div>
            <div class="row gy-5">
              <?php foreach ($menus as $menu): ?>
                <?php if ($menu['category'] == $cat_key): ?>
                <div class="col-lg-4 menu-item">
                  <a href="<?= htmlspecialchars($menu['image']) ?>" class="glightbox"><img src="<?= htmlspecialchars($menu['image']) ?>"
                      class="menu-img img-fluid" style="height:200px; object-fit:cover;" alt=""></a>
                  <h4><?= htmlspecialchars($menu['name']) ?></h4>
                  <p class="ingredients">
                    <?= htmlspecialchars($menu['description']) ?>
                  </p>
                  <p class="price">
                    $<?= htmlspecialchars($menu['price']) ?>
                  </p>
                </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
          <?php $first = false; endforeach; ?>

        </div>
      </div>
    </section><!-- End Menu Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Testimoni</h2>
          <p>Apa yang Mereka <span>Katakan Tentang Kami</span></p>
        </div>

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

      </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Events Section ======= -->
    <section id="events" class="events">
      <div class="container-fluid" data-aos="fade-up">

        <div class="section-header">
          <h2>Acara</h2>
          <p>Bagikan <span>Momen Anda</span> di Restoran Kami</p>
        </div>

        <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper-wrapper">
          <?php
            $stmt_ev = $pdo->query("SELECT * FROM events");
            $events = $stmt_ev->fetchAll(PDO::FETCH_ASSOC);
          ?>
          <?php foreach ($events as $event): ?>
          <div class="swiper-slide event-item d-flex flex-column justify-content-end"
            style="background-image: url(<?= htmlspecialchars($event['image']) ?>)">
            <h3><?= htmlspecialchars($event['title']) ?></h3>
            <div class="price align-self-start">$<?= htmlspecialchars($event['price']) ?></div>
            <p class="description">
              <?= htmlspecialchars($event['description']) ?>
            </p>
          </div><!-- End Event item -->
          <?php endforeach; ?>
        </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Events Section -->

    <!-- ======= Chefs Section ======= -->
    <section id="chefs" class="chefs section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Koki</h2>
          <p>Koki <span>Profesional</span> Kami</p>
        </div>

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

    <!-- ======= Book A Table Section ======= -->
    <section id="book-a-table" class="book-a-table">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Pesan Meja</h2>
          <p>Pesan <span>Tempat Anda</span> Bersama Kami</p>
        </div>

        <div class="row g-0">

          <div class="col-lg-4 reservation-img" style="background-image: url(assets/img/reservation.jpg);"
            data-aos="zoom-out" data-aos-delay="200"></div>

          <div class="col-lg-8 d-flex align-items-center reservation-form-bg">
            <form action="forms/book-a-table.php" method="post" role="form" class="php-email-form" data-aos="fade-up"
              data-aos-delay="100">
              <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Nama Anda"
                    data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                  <div class="validate"></div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email Anda"
                    data-rule="email" data-msg="Please enter a valid email">
                  <div class="validate"></div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Telepon Anda"
                    data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                  <div class="validate"></div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="date" class="form-control" id="date" placeholder="Tanggal" data-rule="minlen:4"
                    data-msg="Please enter at least 4 chars">
                  <div class="validate"></div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <input type="text" class="form-control" name="time" id="time" placeholder="Waktu" data-rule="minlen:4"
                    data-msg="Please enter at least 4 chars">
                  <div class="validate"></div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <input type="number" class="form-control" name="people" id="people" placeholder="Jml Orang"
                    data-rule="minlen:1" data-msg="Please enter at least 1 chars">
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Pesan Tambahan"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Permintaan pesanan Anda telah terkirim. We will call back or send an Email to confirm
                  your reservation. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Pesan Meja</button></div>
            </form>
          </div><!-- End Reservation Form -->

        </div>

      </div>
    </section><!-- End Book A Table Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Galeri</h2>
          <p>Lihat <span>Galeri Kami</span></p>
        </div>

        <div class="gallery-slider swiper">
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
        </div>

      </div>
    </section><!-- End Gallery Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Kontak</h2>
          <p>Butuh Bantuan? <span>Hubungi Kami</span></p>
        </div>

        <div class="mb-3">
          <iframe style="border:0; width: 100%; height: 350px;"
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
            frameborder="0" allowfullscreen></iframe>
        </div><!-- End Google Maps -->

        <div class="row gy-4">

          <div class="col-md-6">
            <div class="info-item  d-flex align-items-center">
              <i class="icon bi bi-map flex-shrink-0"></i>
              <div>
                <h3>Alamat Kami</h3>
                <p><?= nl2br(htmlspecialchars($settings['contact_address'] ?? '')) ?></p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center">
              <i class="icon bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Kami</h3>
                <p><?= htmlspecialchars($settings['contact_email'] ?? '') ?></p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item  d-flex align-items-center">
              <i class="icon bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Hubungi Kami</h3>
                <p><?= htmlspecialchars($settings['contact_phone'] ?? '') ?></p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item  d-flex align-items-center">
              <i class="icon bi bi-share flex-shrink-0"></i>
              <div>
                <h3>Jam Buka</h3>
                <div><?= htmlspecialchars($settings['contact_opening_hours'] ?? 'Mon-Sat: 11AM - 23PM') ?></div>
              </div>
            </div>
          </div><!-- End Info Item -->

        </div>

        <form action="forms/contact.php" method="post" role="form" class="php-email-form p-3 p-md-4">
          <div class="row">
            <div class="col-xl-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Nama Anda" required>
            </div>
            <div class="col-xl-6 form-group">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email Anda" required>
            </div>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subjek" required>
          </div>
          <div class="form-group">
            <textarea class="form-control" name="message" rows="5" placeholder="Pesan Tambahan" required></textarea>
          </div>
          <div class="my-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Pesan Anda telah dikirim. Terima kasih!</div>
          </div>
          <div class="text-center"><button type="submit">Send Pesan Tambahan</button></div>
        </form><!--End Contact Form -->

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div>
            <h4>Alamat</h4>
            <p>
              <?= nl2br(htmlspecialchars($settings['contact_address'] ?? '')) ?><br>
            </p>
          </div>

        </div>

        <div class="col-lg-3 col-md-6 footer-links d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
            <h4>Reservasi</h4>
            <p>
              <strong>Telepon:</strong> <?= htmlspecialchars($settings['contact_phone'] ?? '') ?><br>
              <strong>Email:</strong> <?= htmlspecialchars($settings['contact_email'] ?? '') ?><br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>Jam Buka</h4>
            <p>
              <strong>Mon-Sat: 11AM</strong> - 23PM<br>
              Minggu: Tutup
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Ikuti Kami</h4>
          <div class="social-links d-flex">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span><?= htmlspecialchars($settings['footer_copyright'] ?? 'Yummy') ?></span></strong>. Hak Cipta Dilindungi
      </div>
      <div class="credits">

        <?= htmlspecialchars($settings['footer_slogan'] ?? 'Kami menanti kedatangan Anda kembali.') ?>
      </div>
    </div>

  </footer><!-- End Footer -->
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>