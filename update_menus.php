<?php
$file = 'index.php';
$content = file_get_contents($file);

$replacement = <<< 'HTML'
        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
          <?php
            $stmt = $pdo->query("SELECT * FROM menu_items");
            $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categories = [
                'starters' => 'Starters',
                'breakfast' => 'Breakfast',
                'lunch' => 'Lunch',
                'dinner' => 'Dinner'
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
HTML;

// Find position exactly using logic
$pattern = '/<div class="tab-content"[^>]*>([\s\S]*?)<\/div>\s*<\/div>\s*<\/section><!-- End Menu Section -->/i';
$matches = [];
if (preg_match($pattern, $content, $matches)) {
    $fullMatch = $matches[0];
    
    // Construct the replacement exactly as it should fit
    // We want to replace `<div class="tab-content"...>...</div>` and leave the rest
    // Actually simpler:
    $targetStart = '<div class="tab-content" data-aos="fade-up" data-aos-delay="300">';
    $targetEnd = '<!-- End Menu Section -->';
    
    // Instead of regex, split on the specific lines
    $lines = explode("\n", $content);
    $newLines = [];
    $inTabContent = false;
    foreach ($lines as $line) {
        if (strpos($line, '<div class="tab-content" data-aos="fade-up" data-aos-delay="300">') !== false) {
            $inTabContent = true;
            $newLines[] = $replacement;
        }
        
        if ($inTabContent && strpos($line, '</section><!-- End Menu Section -->') !== false) {
            $inTabContent = false;
            // Need to insert closing divs that were removed
            $newLines[] = "      </div>";
            $newLines[] = "    </section><!-- End Menu Section -->";
            continue; // Skip the line itself as we just added it
        }
        
        if (!$inTabContent) {
            $newLines[] = $line;
        }
    }
    
    file_put_contents($file, implode("\n", $newLines));
    echo "Replacements done.";
} else {
    echo "Regex failed too.";
}
?>
