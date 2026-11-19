<?php
if (!defined('ABSPATH')) exit;
$image=tp48_detail_field('update_image') ?: get_post_thumbnail_id();
$image_html=$image ? tp48_home_image_html($image,(string)tp48_detail_field('update_image_alt')):'';
$caption=trim((string)tp48_detail_field('update_image_caption'));
$video_url=esc_url_raw(trim((string)tp48_detail_field('update_video_url')),['http','https']);
if (!$video_url) {
    $video_id=absint(tp48_detail_field('update_video'));
    if ($video_id && in_array(get_post_mime_type($video_id),['video/mp4','video/webm'],true)) $video_url=wp_get_attachment_url($video_id);
}
?>
<figure class="progress-cover">
<div class="progress-cover-image">
<?php if ($image_html): echo $image_html; else: ?>
<p class="progress-media-empty">Ảnh công trình sẽ được bổ sung.</p>
<?php endif; ?>
<?php if ($video_url): ?>
<a class="progress-video-link" href="<?php echo esc_url($video_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Xem video công trường (mở trong tab mới)">
<span class="progress-play-icon" aria-hidden="true">▶</span>
<span>Xem video công trường</span>
</a>
<?php endif; ?>
</div>
<?php if ($image_html && $caption!==''): ?><figcaption><?php echo nl2br(esc_html($caption)); ?></figcaption><?php endif; ?>
</figure>
