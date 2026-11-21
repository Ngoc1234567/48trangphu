<?php
/* Template Name: Tổng quan */
if (!defined('ABSPATH')) exit;
get_header();
$title=tp48_detail_field('overview_title') ?: 'Tổng quan dự án 48 Trần Phú Nha Trang';
$photo=tp48_detail_field('overview_image');
$photo_html=$photo ? tp48_home_image_html($photo):'';
$photo_data=$photo_html ? tp48_home_image_data($photo):[];
$photo_url=$photo_data ? (($photo_data['id'] ? wp_get_original_image_url($photo_data['id']):'') ?: $photo_data['url']):'';
$rows=[];
foreach (preg_split('/\R/u',(string)tp48_detail_field('overview_facts')) as $line) {
    $parts=explode(':',$line,2);
    if (count($parts)===2 && trim($parts[0])!=='' && trim($parts[1])!=='') {
        $rows[]=['label'=>trim($parts[0]),'value'=>trim($parts[1])];
    }
}
?>
<main id="main" class="section-page overview-page">
<header class="page-heading overview-opening">
<h1><?php echo esc_html($title); ?></h1>
<?php if (tp48_detail_field('overview_intro')): ?><div class="entry-content overview-intro"><?php tp48_detail_body('overview_intro'); ?></div><?php endif; ?>
</header>
<?php if ($rows || $photo_html): ?>
<section class="section-space ruled overview-project" aria-labelledby="overview-project-title">
<h2 id="overview-project-title">Thông tin dự án</h2>
<div class="overview-project-grid<?php echo !$photo_html || !$rows ? ' overview-project-single':''; ?>">
<?php if ($rows): ?>
<dl class="overview-project-facts">
<?php foreach ($rows as $row): ?><div><dt><?php echo esc_html($row['label']); ?></dt><dd><?php echo esc_html($row['value']); ?></dd></div><?php endforeach; ?>
</dl>
<?php endif; ?>
<?php if ($photo_html): ?><figure class="overview-project-photo">
<a class="overview-photo-open" href="<?php echo esc_url($photo_url); ?>" data-gallery-index="0" data-caption="<?php echo esc_attr(tp48_detail_field('overview_caption') ?: ($photo_data['alt'] ?? 'Ảnh thực tế dự án')); ?>" aria-label="Mở ảnh thực tế đầy đủ"><?php echo $photo_html; ?><span class="overview-photo-hint">Xem ảnh đầy đủ ↗</span></a>
<?php if (tp48_detail_field('overview_caption')): ?><figcaption><?php echo nl2br(tp48_detail_text('overview_caption')); ?></figcaption><?php endif; ?>
</figure><?php endif; ?>
</div>
</section>
<?php endif; ?>
<?php if (tp48_detail_field('overview_direction')): ?>
<section class="section-space ruled overview-direction" aria-labelledby="overview-direction-title">
<h2 id="overview-direction-title">Định hướng công trình</h2>
<div class="entry-content"><?php tp48_detail_body('overview_direction'); ?></div>
</section>
<?php endif; ?>
<div class="section-space ruled overview-closing">
<?php $source=tp48_detail_field('overview_source_link');
if (tp48_detail_field('overview_source_text') || (is_array($source) && !empty($source['url']))): ?>
<p class="overview-planning-source"><?php echo nl2br(tp48_detail_text('overview_source_text')); ?>
<?php if (is_array($source) && !empty($source['url'])): ?><a href="<?php echo esc_url($source['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html(!empty($source['title']) ? $source['title']:'Xem nguồn quy hoạch'); ?><span class="sr-only"> (mở tab mới)</span></a><?php endif; ?>
</p><?php endif; ?>
<nav class="overview-actions" aria-label="Tìm hiểu dự án">
<a class="button outline" href="<?php echo esc_url(tp48_page_url('vi-tri')); ?>">Khám phá vị trí <span aria-hidden="true">→</span></a>
<a class="button outline" href="<?php echo esc_url(tp48_page_url('tien-do')); ?>">Theo dõi tiến độ <span aria-hidden="true">→</span></a>
</nav>
</div>
</main>
<?php if ($photo_html) get_template_part('template-parts/lightbox'); ?>
<?php get_footer(); ?>
