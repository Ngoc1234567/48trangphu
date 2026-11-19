<?php
if (!defined('ABSPATH')) exit;
$mobile=tp48_home_image_data(tp48_home_field('identity','mobile_image'));
$mobile_dimensions=$mobile && $mobile['id'] ? wp_get_attachment_metadata($mobile['id']):[];
$description=trim((string)tp48_home_field('identity','description'));
$desktop_description=preg_replace('/\s+/u',' ',$description);
$mobile_description=trim((string)tp48_home_field('identity','mobile_description'));
if ($mobile_description==='') {
    // Keep each sentence together when space allows; prefer the requested break on phones.
    $parts=preg_split('/(?<=Biển phía trước\.)\s+/u',$desktop_description,2);
    $mobile_html=implode(' <wbr>',array_map(function($part) {
        return '<span class="identity-description-part">'.esc_html($part).'</span>';
    },$parts));
} else {
    $mobile_html=nl2br(esc_html($mobile_description),false);
}
?>
<section class="identity ruled" id="dau-an" aria-labelledby="identity-title">
    <picture class="identity-picture">
        <?php if ($mobile): ?><source media="(max-width: 700px)" srcset="<?php echo esc_url($mobile['url']); ?>"<?php if (!empty($mobile_dimensions['width']) && !empty($mobile_dimensions['height'])): ?> width="<?php echo absint($mobile_dimensions['width']); ?>" height="<?php echo absint($mobile_dimensions['height']); ?>"<?php endif; ?>><?php endif; ?>
        <?php echo tp48_home_image_html(tp48_home_field('identity','image'),tp48_home_field('identity','alt')); ?>
    </picture>
    <div class="identity-copy">
        <h2 id="identity-title"><?php echo tp48_home_text('identity','title'); ?></h2>
        <div class="short-line"></div>
        <?php if ($description!==''): ?><p class="identity-description-desktop"><?php echo esc_html($desktop_description); ?></p><?php endif; ?>
        <?php if ($mobile_html!==''): ?><p class="identity-description-mobile"><?php echo $mobile_html; ?></p><?php endif; ?>
    </div>
</section>
