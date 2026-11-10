<?php
if (!defined('ABSPATH')) exit;
$video_id=absint(tp48_detail_field('update_video'));
$video=$video_id && in_array(get_post_mime_type($video_id),['video/mp4','video/webm'],true) ? wp_get_attachment_url($video_id):'';
$video_type=$video ? get_post_mime_type($video_id):'';
$video_url=esc_url_raw(trim((string)tp48_detail_field('update_video_url')),['http','https']);
$youtube_embed=tp48_progress_youtube_embed($video_url);
if ($video_url) {
    $video=$video_url;
    $video_type='';
}
$image=tp48_detail_field('update_image');
$poster=tp48_home_image_data($image);
if ($video): ?>
<?php if ($youtube_embed): ?>
<iframe src="<?php echo esc_url($youtube_embed); ?>" title="<?php echo esc_attr('Video công trình — '.get_the_title()); ?>" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
<a class="text-link" href="<?php echo esc_url($video_url); ?>" target="_blank" rel="noopener noreferrer">Xem trên YouTube ↗</a>
<?php else: ?>
<video controls playsinline preload="metadata"<?php if ($poster): ?> poster="<?php echo esc_url($poster['url']); ?>"<?php endif; ?>><source src="<?php echo esc_url($video); ?>"<?php if ($video_type): ?> type="<?php echo esc_attr($video_type); ?>"<?php endif; ?>>Trình duyệt không hỗ trợ video. <a href="<?php echo esc_url($video); ?>">Tải video</a></video>
<?php endif; ?>
<?php if (tp48_detail_field('update_is_demo')): ?><p class="demo-notice">Video mẫu thử trình phát, không phải video công trình.</p><?php endif; ?>
<?php elseif ($image): echo tp48_home_image_html($image);
else:
    $find_video=function($blocks) use (&$find_video) {
        foreach ($blocks as $block) {
            if ($block['blockName']==='core/video') return render_block($block);
            if ($block['blockName']==='core/embed' && in_array($block['attrs']['providerNameSlug'] ?? '',['youtube','vimeo'],true)) return render_block($block);
            if (!empty($block['innerBlocks'])) { $found=$find_video($block['innerBlocks']); if ($found) return $found; }
        }
        return '';
    };
    $media=$find_video(parse_blocks(get_the_content()));
    if ($media) echo $media;
    elseif (has_post_thumbnail()) the_post_thumbnail('large',['loading'=>'lazy']);
    else echo '<p class="progress-media-empty">Ảnh hoặc video của bản cập nhật sẽ được bổ sung.</p>';
endif;
