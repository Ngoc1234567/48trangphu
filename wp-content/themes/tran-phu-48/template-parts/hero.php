<?php if (!defined('ABSPATH')) exit; $video=wp_get_attachment_url(absint(tp48_text('hero_video'))); ?>
<section class="hero" aria-labelledby="hero-title">
    <img class="hero-image" src="<?php echo esc_url(tp48_image('hero')); ?>" alt="Hình ảnh minh họa khu vực Tháp Trầm Hương tại Nha Trang" fetchpriority="high" width="1920" height="1080">
    <?php if ($video): ?><video class="hero-video" autoplay muted loop playsinline poster="<?php echo esc_url(tp48_image('hero')); ?>" aria-label="Video giới thiệu địa điểm"><source src="<?php echo esc_url($video); ?>"></video><button class="video-toggle" type="button">Tạm dừng video</button><?php endif; ?>
    <div class="hero-content"><p class="eyebrow">48 TRẦN PHÚ · NHA TRANG</p><h1 id="hero-title"><?php echo esc_html(tp48_text('headline','Thông tin dự án tại 48 Trần Phú, Nha Trang')); ?></h1><div class="gold-line"></div><p><?php echo esc_html(tp48_text('subtitle','Tổng quan, vị trí và các cập nhật được công bố khi có thông tin xác nhận.')); ?></p><div class="hero-actions"><a class="button outline" href="<?php echo esc_url(tp48_page_url('tong-quan')); ?>">Tìm hiểu tổng quan <span aria-hidden="true">↗</span></a><a class="quiet-link" href="<?php echo esc_url(tp48_page_url('tien-do')); ?>">Theo dõi cập nhật</a></div></div>
    <span class="image-caption">Hình ảnh khu vực Nha Trang · Minh họa</span>
</section>
