<?php
/* Template Name: Tổng quan */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading');
$cover=tp48_detail_field('overview_image');
if (!$cover) $cover=has_post_thumbnail() ? get_post_thumbnail_id():tp48_home_field('hero','image');
?>
<figure class="overview-cover">
<?php echo tp48_home_image_html($cover,'','',true); ?>
<?php if (tp48_detail_field('overview_caption')): ?><figcaption class="hero-caption"><?php echo tp48_detail_text('overview_caption'); ?></figcaption><?php endif; ?>
</figure>
<section class="section-space intro-section ruled">
<div><p class="eyebrow">Tổng quan dự án</p><h2><?php echo tp48_detail_text('overview_heading'); ?></h2><p class="muted">Nha Trang</p></div>
<div><div class="entry-content page-body"><?php tp48_detail_body('overview_intro'); ?></div>
<?php if (tp48_detail_field('overview_facts')): ?><div class="overview-facts"><h3>Thông tin đã xác nhận</h3><p><?php echo nl2br(tp48_detail_text('overview_facts')); ?></p></div><?php endif; ?>
<?php $button=tp48_detail_field('overview_button'); if (!is_array($button)) $button=['url'=>tp48_page_url('vi-tri'),'title'=>'Khám phá vị trí']; ?>
<?php if (tp48_home_link_attributes($button)): ?><a class="text-link" <?php echo tp48_home_link_attributes($button); ?>><?php echo esc_html($button['title'] ?? 'Khám phá vị trí'); ?> ↗</a><?php endif; ?>
</div></section>
</main>
<?php get_footer(); ?>
