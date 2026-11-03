<?php
/* Template Name: Vị trí */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading'); ?>
<section class="location-section ruled"><div class="location-photo"><img src="<?php echo esc_url(has_post_thumbnail() ? get_the_post_thumbnail_url(null,'full') : tp48_image('location')); ?>" alt="<?php echo esc_attr(has_post_thumbnail() ? get_post_meta(get_post_thumbnail_id(),'_wp_attachment_image_alt',true) : 'Ảnh minh họa khu vực ven biển Nha Trang'); ?>" loading="lazy" width="1440" height="960"><?php if (!has_post_thumbnail()): ?><span class="image-caption">Ảnh minh họa khu vực</span><?php endif; ?></div><div class="location-copy"><p class="eyebrow">Địa điểm dự án</p><h2>48 Trần Phú<br>Nha Trang</h2><p><?php echo esc_html(tp48_text('location','Địa điểm dự án: 48 Trần Phú, Nha Trang. Thông tin chi tiết sẽ được cập nhật khi có xác nhận.')); ?></p><a class="text-link" href="https://www.google.com/maps/search/?api=1&amp;query=48+Tran+Phu+Nha+Trang" target="_blank" rel="noopener noreferrer">Xem khu vực trên bản đồ <span aria-hidden="true">↗</span><span class="sr-only">(mở cửa sổ mới)</span></a></div></section>
<section class="section-space ruled"><div class="section-heading"><h2>Thông tin vị trí</h2></div><?php tp48_page_content(); ?></section>
</main>

<?php get_footer(); ?>
