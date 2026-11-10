<?php
if (!defined('ABSPATH')) exit;
$ready=tp48_detail_field('information_status')==='ready';
if (!$ready) {
    echo '<section class="section-space ruled"><p class="muted">Chờ thông tin chính thức</p></section>';
    return;
}
?>
<section class="section-space ruled information-page">
<div class="information-intro"><p class="eyebrow">Thông tin chính thức</p><p class="muted"><?php echo nl2br(tp48_detail_text('information_intro')); ?></p></div>
<div>
<?php if (tp48_detail_field('information_image')): ?><figure class="location-reference"><?php echo tp48_home_image_html(tp48_detail_field('information_image')); ?><figcaption><?php echo tp48_detail_text('information_caption'); ?></figcaption></figure><?php endif; ?>
<div class="entry-content"><?php tp48_detail_body('information_content'); ?></div>
<?php $document=absint(tp48_detail_field('information_document')); if ($document && get_post_mime_type($document)==='application/pdf'): ?><a class="text-link" href="<?php echo esc_url(wp_get_attachment_url($document)); ?>">Xem tài liệu chính thức (PDF) ↗</a><?php endif; ?>
</div></section>
<section class="section-space ruled update-invite"><h2>Theo dõi thông tin mới</h2><p>Đăng ký nhận cập nhật khi có nội dung chính thức được công bố.</p><a class="button outline" href="<?php echo esc_url(home_url('/#kham-pha')); ?>"><?php echo tp48_detail_text('information_button_label'); ?> ↗</a></section>
