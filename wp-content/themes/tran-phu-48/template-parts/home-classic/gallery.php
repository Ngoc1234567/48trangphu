<?php if (!defined('ABSPATH')) exit; $photos=tp48_home_gallery(); ?>
<section class="gallery ruled" id="hinh-anh" aria-labelledby="gallery-title">
<div class="gallery-copy"><h2 id="gallery-title"><?php echo tp48_home_text('gallery','title'); ?></h2><p><?php echo tp48_home_text('gallery','description',true); ?></p><?php if ($photos && tp48_home_field('gallery','button_label')): ?><button type="button" class="text-link" data-open-gallery><?php echo tp48_home_text('gallery','button_label'); ?> <span aria-hidden="true">⟶</span></button><?php endif; ?></div>
<div class="gallery-grid" style="--tp48-gallery-columns:<?php echo max(1,min(3,count($photos))); ?>">
<?php foreach ($photos as $i=>$photo): ?><a class="gallery-item" href="<?php echo esc_url($photo['url']); ?>" data-gallery-index="<?php echo (int)$i; ?>" data-caption="<?php echo esc_attr($photo['caption']); ?>" aria-label="<?php echo esc_attr('Xem ảnh: '.$photo['alt']); ?>"><?php echo tp48_home_image_html($photo['id'] ?: $photo,$photo['alt']); ?><span aria-hidden="true">↗</span></a><?php endforeach; ?>
<?php if (!$photos): ?><p><?php echo tp48_home_text('gallery','empty_message'); ?></p><?php endif; ?>
</div>
</section>
