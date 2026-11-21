<?php
/* Template Name: Hình ảnh */
if (!defined('ABSPATH')) exit;
get_header();
?>
<main id="main" class="section-page images-page">
<header class="page-heading">
<h1><?php echo esc_html(tp48_gallery_field('title')); ?></h1>
<div class="entry-content images-intro"><?php echo wp_kses_post(wpautop(tp48_gallery_field('intro'))); ?></div>
</header>
<?php for ($n=1;$n<=4;$n++):
    if ($n===2): ?><section class="section-space ruled images-archive"><h2><?php echo esc_html(tp48_gallery_field('heading')); ?></h2><div class="images-grid"><?php endif;
    $image=tp48_gallery_field($n.'_image');
    $alt=tp48_gallery_field($n.'_alt');
    $caption=tp48_gallery_field($n.'_caption');
    $data=$image ? tp48_home_image_data($image,$alt):[];
    if (!$data) continue;
    $url=wp_get_original_image_url($data['id']) ?: $data['url'];
?>
<figure class="images-photo<?php echo $n===1 ? ' images-featured section-space':''; ?>">
<a href="<?php echo esc_url($url); ?>" data-gallery-index="<?php echo (int)$n-1; ?>" data-caption="<?php echo esc_attr($caption); ?>" aria-label="<?php echo esc_attr('Xem ảnh: '.$data['alt']); ?>"><?php echo tp48_home_image_html($image,$alt,'',$n===1); ?></a>
<?php if ($caption!==''): ?><figcaption><?php echo nl2br(esc_html($caption)); ?></figcaption><?php endif; ?>
</figure>
<?php endfor; ?>
</div></section>
<nav class="section-space ruled overview-actions" aria-label="Tìm hiểu dự án">
<a class="button outline" href="<?php echo esc_url(tp48_page_url('vi-tri')); ?>"><?php echo esc_html(tp48_gallery_field('location_label')); ?></a>
<a class="button outline" href="<?php echo esc_url(tp48_page_url('tien-do')); ?>"><?php echo esc_html(tp48_gallery_field('progress_label')); ?></a>
</nav>
</main>
<?php get_template_part('template-parts/lightbox'); get_footer(); ?>
