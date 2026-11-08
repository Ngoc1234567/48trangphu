<?php
/* Template Name: Vị trí */
if (!defined('ABSPATH')) exit;
get_header();
$query=trim((string)tp48_detail_field('map_query'));
$map_url='https://www.google.com/maps/search/?api=1&query='.rawurlencode($query);
?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading'); ?>
<section class="section-space ruled map-section" aria-labelledby="map-title">
<div class="section-heading"><h2 id="map-title"><?php echo tp48_detail_text('location_heading'); ?></h2></div>
<p class="location-relationship"><?php echo tp48_detail_text('location_relationship'); ?></p>
<?php if ($query): ?>
<iframe class="location-map" title="<?php echo esc_attr('Bản đồ: '.$query); ?>" src="<?php echo esc_url('https://www.google.com/maps?q='.rawurlencode($query).'&output=embed'); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
<p class="muted map-note"><?php echo tp48_detail_text('map_note'); ?> <a class="text-link" href="<?php echo esc_url($map_url); ?>" target="_blank" rel="noopener noreferrer">Mở Google Maps ↗</a></p>
<?php endif; ?>
</section>
<section id="ben-vinh-bien" class="location-section ruled">
<figure class="location-photo location-reference">
<?php echo tp48_home_image_html(tp48_detail_field('location_photo') ?: tp48_image('location')); ?>
<figcaption><?php echo tp48_detail_text('location_photo_caption'); ?></figcaption>
</figure>
<div class="location-copy"><p class="eyebrow">Địa điểm dự án</p><h2><?php echo tp48_detail_text('location_heading'); ?></h2><div class="entry-content"><?php tp48_detail_body('location_intro'); ?></div></div>
</section>
<section class="section-space ruled"><div class="section-heading"><h2>Các điểm nhận diện</h2></div>
<figure class="location-reference">
<?php echo tp48_home_image_html(tp48_detail_field('landmark_photo') ?: tp48_image('hero')); ?>
<figcaption><?php echo tp48_detail_text('landmark_photo_caption'); ?></figcaption>
</figure>
<div class="landmark-grid">
<?php for ($i=1;$i<=3;$i++): if (!tp48_detail_field('landmark_'.$i.'_title')) continue; ?>
<article><span class="eyebrow"><?php echo esc_html(sprintf('%02d',$i)); ?></span><h3><?php echo tp48_detail_text('landmark_'.$i.'_title'); ?></h3><p><?php echo nl2br(tp48_detail_text('landmark_'.$i.'_description')); ?></p></article>
<?php endfor; ?>
</div>
</section>
</main>
<?php get_footer(); ?>
