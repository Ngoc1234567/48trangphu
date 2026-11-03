<?php
/* Template Name: Tiến độ */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading'); ?>
<section class="section-space ruled"><div class="section-heading"><div><p class="eyebrow">Cập nhật theo thời gian</p><h2>Tiến độ dự án</h2></div><p class="muted">Các cập nhật và hình ảnh được đăng tải<br>khi có thông tin xác nhận.</p></div><?php while (have_posts()): the_post(); if (trim(get_the_content())): ?><div class="entry-content page-body"><?php the_content(); ?></div><?php endif; endwhile; tp48_cards('tp48_journal',6,true); ?></section>
</main>

<?php get_footer(); ?>
