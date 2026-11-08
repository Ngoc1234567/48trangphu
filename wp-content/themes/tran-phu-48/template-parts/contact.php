<?php if (!defined('ABSPATH')) exit; ?>
<section class="contact-section section-space ruled" id="kham-pha" aria-labelledby="contact-title">
<div class="contact-copy"><p class="eyebrow">Kết nối với 48 Trần Phú</p><h2 id="contact-title"><?php echo tp48_detail_text('contact_heading'); ?></h2><p><?php echo tp48_detail_text('contact_intro'); ?></p><p class="fine-print">Kênh liên hệ tiếp nhận nhu cầu tìm hiểu thông tin dự án.</p></div>
<div class="contact-panel">
<?php $messages=['success'=>'Cảm ơn bạn. Yêu cầu nhận cập nhật đã được ghi nhận.','invalid'=>'Vui lòng kiểm tra họ tên, email và số điện thoại (nếu có).','consent'=>'Vui lòng đồng ý nhận liên hệ và cập nhật trước khi gửi.','expired'=>'Phiên gửi đã hết hạn. Vui lòng tải lại trang và thử lại.','wait'=>'Bạn vừa gửi yêu cầu. Vui lòng chờ một phút trước khi gửi lại.','error'=>'Chưa thể ghi nhận yêu cầu. Vui lòng thử lại.']; $status=isset($_GET['contact']) && is_string($_GET['contact']) ? sanitize_key($_GET['contact']) : ''; if (isset($messages[$status])): ?><p class="form-status" role="status"><?php echo esc_html($messages[$status]); ?></p><?php endif; ?>
<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="contact-form">
<input type="hidden" name="action" value="tp48_contact"><input type="hidden" name="return_url" value="<?php echo esc_url(is_page() && !is_front_page() ? get_permalink() : home_url('/')); ?>"><?php wp_nonce_field('tp48_contact','tp48_nonce'); ?>
<div class="honeypot" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
<label for="full-name">Họ và tên <span aria-hidden="true">*</span><input id="full-name" name="full_name" autocomplete="name" maxlength="100" required></label>
<label for="email">Email <span aria-hidden="true">*</span><input id="email" name="email" type="email" autocomplete="email" maxlength="254" required></label>
<label class="full-width" for="phone">Số điện thoại <span class="optional">(không bắt buộc)</span><input id="phone" name="phone" type="tel" autocomplete="tel" pattern="[+0-9 ().-]{8,20}" maxlength="20"></label>
<label class="consent full-width"><input type="checkbox" name="consent" value="1" required><span>Tôi đồng ý để website liên hệ và gửi thông tin cập nhật theo <a href="<?php echo esc_url(tp48_page_url('chinh-sach-bao-mat')); ?>">chính sách quyền riêng tư</a>.</span></label>
<button class="button gold full-width" type="submit">Gửi yêu cầu nhận cập nhật <span aria-hidden="true">↗</span></button>
</form>
</div>
</section>
