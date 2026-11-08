<?php if (!defined('ABSPATH')) exit; $button=tp48_home_field('location','button'); ?>
<section class="location ruled" id="vi-tri" aria-labelledby="location-title">
    <span id="gioi-thieu" class="home-section-anchor" aria-hidden="true"></span>
    <?php echo tp48_home_image_html(tp48_home_field('location','image'),tp48_home_field('location','alt')); ?>
    <div class="location-copy"><h2 id="location-title"><span><?php echo tp48_home_text('location','eyebrow'); ?></span><?php echo tp48_home_text('location','title'); ?></h2><p><?php echo tp48_home_text('location','description',true); ?></p>
    <?php if (tp48_home_link_attributes($button)): ?><a class="text-link" <?php echo tp48_home_link_attributes($button); ?>><?php echo esc_html($button['title'] ?: 'Khám phá vị trí'); ?> <span aria-hidden="true">⟶</span></a><?php endif; ?></div>
</section>
