<?php
/* Template Name: Tổng quan */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading'); ?>
<section class="section-space intro-section ruled"><div><p class="eyebrow">Về địa điểm</p><h2>Dự án tại<br>48 Trần Phú</h2><p class="muted">Nha Trang</p></div><div><?php tp48_page_content(); ?><a class="text-link" href="<?php echo esc_url(tp48_page_url('vi-tri')); ?>">Khám phá vị trí <span aria-hidden="true">↗</span></a></div></section>
<section id="gia-tri-ben-vung" class="section-space ruled"><div class="section-heading"><h2>Giá trị bền vững</h2></div><p>Thông tin về định hướng phát triển và các giá trị bền vững của dự án sẽ được cập nhật khi có tài liệu chính thức được xác minh.</p></section>
<?php get_template_part('template-parts/gallery'); ?>
</main>
<?php get_template_part('template-parts/lightbox'); ?>
<?php get_footer(); ?>
