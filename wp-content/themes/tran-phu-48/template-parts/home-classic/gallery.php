<?php if (!defined('ABSPATH')) exit; ?>
<section class="gallery ruled" id="hinh-anh" aria-labelledby="gallery-title">
        <div class="gallery-copy"><h2 id="gallery-title">Hình ảnh</h2><p>Những khoảnh khắc tiêu biểu<br>về vị trí, cảnh quan và phố biển<br>Nha Trang.</p><button class="text-link" data-open-gallery>Xem hình ảnh <span aria-hidden="true">⟶</span></button></div>
        <div class="gallery-grid">
            <?php foreach ([['location','Đường bờ biển Nha Trang'],['hero','Tháp Trầm Hương về đêm'],['sunrise','Bình minh trên vịnh biển']] as $i => $photo): ?>
            <a class="gallery-item" href="<?php echo esc_url(tp48_image($photo[0])); ?>" data-gallery-index="<?php echo (int) $i; ?>" data-caption="<?php echo esc_attr($photo[1]); ?>" aria-label="Xem ảnh: <?php echo esc_attr($photo[1]); ?>"><img src="<?php echo esc_url(tp48_image($photo[0])); ?>" alt="<?php echo esc_attr($photo[1]); ?>" loading="lazy"><span aria-hidden="true">↗</span></a>
            <?php endforeach; ?>
        </div>
    </section>
