<?php
/* Template Name: Vị trí */
if (!defined('ABSPATH')) exit;
get_header();
$query=trim((string)tp48_detail_field('map_query'));
$map_zoom=tp48_detail_field('map_zoom');
$map_zoom=is_numeric($map_zoom) ? max(1,min(21,(int)$map_zoom)):14;
$map_embed=tp48_map_embed_url(tp48_detail_field('map_embed'));
$map_src=$map_embed ?: ($query ? 'https://www.google.com/maps?q='.rawurlencode($query).'&z='.$map_zoom.'&output=embed':'');
$map_url=esc_url_raw((string)tp48_detail_field('map_link'),['http','https']) ?: ($map_embed ?: 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($query));
?>
<main id="main" class="section-page location-page">
<section class="section-space ruled map-section" aria-labelledby="map-title">
<div class="section-heading"><h2 id="map-title"><?php echo tp48_detail_text('location_heading'); ?></h2></div>
<p class="location-relationship"><?php echo tp48_detail_text('location_relationship'); ?></p>
<?php if ($map_src): ?>
<iframe class="location-map" title="<?php echo esc_attr($query ? 'Bản đồ: '.$query:'Bản đồ vị trí dự án'); ?>" src="<?php echo esc_url($map_src); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
<p class="muted map-note"><?php echo tp48_detail_text('map_note'); ?> <a class="text-link" href="<?php echo esc_url($map_url); ?>" target="_blank" rel="noopener noreferrer">Mở Google Maps ↗</a></p>
<?php endif; ?>
</section>
<?php $gallery_index=0;
foreach (['corner','sea'] as $view):
    $prefix='location_'.$view;
    $photo=tp48_detail_field($prefix.'_image');
    $photo_data=$photo ? tp48_home_image_data($photo,(string)tp48_detail_field($prefix.'_alt')):[];
    $photo_url=$photo_data ? (($photo_data['id'] ? wp_get_original_image_url($photo_data['id']):'') ?: $photo_data['url']):'';
    $heading=(string)tp48_detail_field($prefix.'_heading');
    $caption=(string)tp48_detail_field($prefix.'_caption');
    $note=(string)tp48_detail_field($prefix.'_note');
    if (!$heading && !$photo_data && !tp48_detail_field($prefix.'_description') && !$note) continue;
?>
<section class="section-space ruled location-view" aria-label="<?php echo esc_attr($heading ?: 'Ảnh vị trí'); ?>">
<?php if ($heading): ?><h2 class="location-view-title"><?php echo esc_html($heading); ?></h2><?php endif; ?>
<?php if ($photo_data): ?>
<figure class="location-reference">
<a class="location-photo-open" href="<?php echo esc_url($photo_url); ?>" data-gallery-index="<?php echo (int)$gallery_index++; ?>" data-caption="<?php echo esc_attr($caption); ?>" aria-label="<?php echo esc_attr('Mở ảnh đầy đủ: '.($heading ?: $photo_data['alt'])); ?>">
<?php echo tp48_home_image_html($photo,(string)tp48_detail_field($prefix.'_alt')); ?>
<span class="location-photo-hint">Xem ảnh đầy đủ ↗</span>
</a>
<?php if ($caption): ?><figcaption><?php echo nl2br(esc_html($caption)); ?></figcaption><?php endif; ?>
</figure>
<?php endif; ?>
<?php if ($note): ?><p class="map-note muted"><?php echo nl2br(esc_html($note)); ?></p><?php endif; ?>
<?php if (tp48_detail_field($prefix.'_description')): ?><div class="entry-content"><?php tp48_detail_body($prefix.'_description'); ?></div><?php endif; ?>
</section>
<?php endforeach; ?>
<nav class="section-space ruled overview-actions" aria-label="Tìm hiểu dự án">
<?php foreach (['overview','progress'] as $destination):
    $label=(string)tp48_detail_field('location_'.$destination.'_label');
    $path=(string)tp48_detail_field('location_'.$destination.'_path');
    if (!$label || !preg_match('~^/(?!/)[^\\\\\s]*$~D',$path)) continue;
?>
<a class="button outline" href="<?php echo esc_url($path); ?>"><?php echo esc_html($label); ?> <span aria-hidden="true">→</span></a>
<?php endforeach; ?>
</nav>
</main>
<?php if ($gallery_index) get_template_part('template-parts/lightbox'); ?>
<?php get_footer(); ?>
