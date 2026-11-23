<?php
if (!defined('ABSPATH')) exit;
$photos=tp48_home_gallery();
$gallery_ready=tp48_gallery_ready();
$third_caption=trim((string)tp48_home_field('gallery','third_image_caption'));
?>
<section class="gallery ruled" id="hinh-anh" aria-labelledby="gallery-title">
<div class="gallery-copy"><h2 id="gallery-title"><?php if ($gallery_ready): ?><a href="<?php echo esc_url(tp48_page_url('hinh-anh')); ?>"><?php endif; ?><?php echo tp48_home_text('gallery','title'); ?><?php if ($gallery_ready): ?></a><?php endif; ?></h2><p><?php echo tp48_home_text('gallery','description',true); ?></p><?php if (tp48_home_field('gallery','button_label')): ?><a class="text-link" href="<?php echo esc_url(tp48_page_url('hinh-anh')); ?>"><?php echo tp48_home_text('gallery','button_label'); ?> <span aria-hidden="true">⟶</span></a><?php endif; ?></div>
<div class="gallery-grid" style="--tp48-gallery-columns:<?php echo max(1,min(3,count($photos))); ?>">
<?php foreach ($photos as $i=>$photo):
    $caption=$photo['caption'];
    if ($i===2 && $third_caption!=='' && strpos($caption,$third_caption)===false) {
        $caption=trim($caption."\n".$third_caption);
    }
?>
<figure class="gallery-photo">
<a class="gallery-item" href="<?php echo esc_url($photo['url']); ?>" data-gallery-index="<?php echo (int)$i; ?>" data-caption="<?php echo esc_attr($caption); ?>" aria-label="<?php echo esc_attr('Xem ảnh: '.$photo['alt']); ?>"><?php echo tp48_home_image_html($photo['id'] ?: $photo,$photo['alt']); ?><span aria-hidden="true">↗</span></a>
</figure>
<?php endforeach; ?>
<?php if (!$photos): ?><p><?php echo tp48_home_text('gallery','empty_message'); ?></p><?php endif; ?>
</div>
</section>
