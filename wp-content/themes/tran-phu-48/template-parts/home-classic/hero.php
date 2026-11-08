<?php if (!defined('ABSPATH')) exit;
$button=tp48_home_field('hero','button');$mobile=tp48_home_image_data(tp48_home_field('hero','mobile_image'));
$video_id=absint(tp48_home_field('hero','video'));$video=$video_id && in_array(get_post_mime_type($video_id),['video/mp4','video/webm'],true) ? wp_get_attachment_url($video_id):'';
?>
<figure class="hero-figure">
<section class="hero hero-concept" aria-labelledby="hero-title">
    <?php if ($mobile): ?><picture><source media="(max-width: 700px)" srcset="<?php echo esc_url($mobile['url']); ?>"><?php endif; ?>
    <?php echo tp48_home_image_html(tp48_home_field('hero','image'),tp48_home_field('hero','alt'),'hero-image',true); ?>
    <?php if ($mobile): ?></picture><?php endif; ?>
    <?php if ($video): ?><video class="hero-video" autoplay muted loop playsinline aria-label="Video giới thiệu"><source src="<?php echo esc_url($video); ?>" type="<?php echo esc_attr(get_post_mime_type($video_id)); ?>"></video><button class="video-toggle" type="button">Tạm dừng video</button><?php endif; ?>
    <div class="hero-content">
        <h1 id="hero-title"><span class="hero-title-line"><?php echo tp48_home_text('hero','number'); ?> <?php echo tp48_home_text('hero','name'); ?></span><span class="hero-title-separator"> · </span><span class="hero-city"><?php echo tp48_home_text('hero','city'); ?></span></h1>
        <?php if (tp48_home_field('hero','subtitle')): ?><p class="hero-subtitle"><?php echo tp48_home_text('hero','subtitle'); ?></p><?php endif; ?>
        <?php if (tp48_home_link_attributes($button)): ?><a class="button outline" <?php echo tp48_home_link_attributes($button); ?>><?php echo esc_html($button['title'] ?: 'Khám phá thêm'); ?> <span aria-hidden="true">⟶</span></a><?php endif; ?>
    </div>
</section>
<?php $caption=tp48_home_field('hero','caption'); if ($caption===null) $caption='Hình ảnh minh họa ý tưởng, không phải phối cảnh chính thức của dự án.'; if ($caption): ?><figcaption class="hero-caption"><?php echo esc_html($caption); ?></figcaption><?php endif; ?>
</figure>
