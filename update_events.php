<?php
$file = 'index.php';
$content = file_get_contents($file);

$replacement = <<< 'HTML'
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
HTML;

    $lines = explode("\n", $content);
    $newLines = [];
    $inSwiperWrapper = false;
    foreach ($lines as $line) {
        if (strpos($line, '<section id="events"') !== false) {
             // Let's just catch the full block
        }
        if (strpos($line, '<div class="swiper-wrapper">') !== false) {
            $inSwiperWrapper = true;
            $newLines[] = $replacement;
            continue;
        }
        
        if ($inSwiperWrapper && strpos($line, '<div class="swiper-pagination"></div>') !== false) {
            $inSwiperWrapper = false;
            $newLines[] = $line;
            continue; 
        }
        
        if (!$inSwiperWrapper) {
            $newLines[] = $line;
        }
    }
    
    file_put_contents($file, implode("\n", $newLines));
    echo "Events replacements done.";
?>
