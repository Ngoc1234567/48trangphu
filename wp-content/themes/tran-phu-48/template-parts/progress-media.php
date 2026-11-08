<?php
if (!defined('ABSPATH')) exit;
$video_id=absint(tp48_detail_field('update_video'));
$video=$video_id && in_array(get_post_mime_type($video_id),['video/mp4','video/webm'],true) ? wp_get_attachment_url($video_id):'';
$image=tp48_detail_field('update_image');
$poster=tp48_home_image_data($image);
if ($video): ?>
<video controls playsinline preload="metadata"<?php if ($poster): ?> poster="<?php echo esc_url($poster['url']); ?>"<?php endif; ?>><source src="<?php echo esc_url($video); ?>" type="<?php echo esc_attr(get_post_mime_type($video_id)); ?>">Trình duyệt không hỗ trợ video. <a href="<?php echo esc_url($video); ?>">Tải video</a></video>
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
