<?php
/* Template Name: Tiến độ */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading'); ?>
<section class="section-space ruled">
<div class="section-heading"><div><p class="eyebrow">Cập nhật theo thời gian</p><h2><?php echo tp48_detail_text('progress_heading'); ?></h2></div><p class="muted"><?php echo nl2br(tp48_detail_text('progress_intro')); ?></p></div>
<?php get_template_part('template-parts/progress-list'); ?>
</section>
</main>
<?php get_footer(); ?>