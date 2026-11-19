<?php
/* Template Name: Tiến độ */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page progress-page">
<header class="page-heading progress-opening">
<h1><?php echo esc_html(tp48_detail_field('progress_title') ?: 'Tiến độ dự án 48 Trần Phú Nha Trang'); ?></h1>
<?php if (tp48_detail_field('progress_intro')): ?><div class="entry-content progress-intro"><?php tp48_detail_body('progress_intro'); ?></div><?php endif; ?>
</header>
<section class="section-space ruled" aria-label="Các bản cập nhật tiến độ">
<?php get_template_part('template-parts/progress-list'); ?>
</section>
</main>
<?php get_footer(); ?>
