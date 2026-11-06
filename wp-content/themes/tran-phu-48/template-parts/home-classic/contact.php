<?php if (!defined('ABSPATH')) exit;
$privacy=tp48_home_field('contact','privacy_link');$show_phone=(bool)tp48_home_field('contact','show_phone');$required_phone=$show_phone && tp48_home_field('contact','phone_required'); ?>
<section class="contact ruled<?php if (!$show_phone) echo ' is-phone-hidden'; ?>" id="kham-pha" aria-labelledby="contact-title">
<h2 id="contact-title"><?php echo tp48_home_text('contact','title',true); ?></h2>
<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="contact-form">
<input type="hidden" name="return_url" value="<?php echo esc_url(get_permalink(tp48_home_post_id())); ?>"><input type="hidden" name="action" value="tp48_contact"><input type="hidden" name="tp48_home_page" value="<?php echo (int)tp48_home_post_id(); ?>"><?php wp_nonce_field('tp48_contact','tp48_nonce'); wp_nonce_field('tp48_home_contact_'.tp48_home_post_id(),'tp48_home_nonce'); ?>
<div class="honeypot" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
<label class="sr-only" for="full-name"><?php echo tp48_home_text('contact','name_label'); ?></label><input id="full-name" name="full_name" placeholder="<?php echo esc_attr(tp48_home_field('contact','name_label')); ?>" autocomplete="name" maxlength="100" required>
<?php if ($show_phone): ?><label class="sr-only" for="phone"><?php echo tp48_home_text('contact','phone_label'); ?></label><input id="phone" name="phone" type="tel" placeholder="<?php echo esc_attr(tp48_home_field('contact','phone_label')); ?>" autocomplete="tel" pattern="[+0-9 ().-]{8,20}" maxlength="20"<?php if ($required_phone) echo ' required'; ?>><?php endif; ?>
<label class="sr-only" for="email"><?php echo tp48_home_text('contact','email_label'); ?></label><input id="email" name="email" type="email" placeholder="<?php echo esc_attr(tp48_home_field('contact','email_label')); ?>" autocomplete="email" maxlength="254" required>
<button class="button gold" type="submit"><?php echo tp48_home_text('contact','button_label'); ?> <span aria-hidden="true">⟶</span></button>
</form>
<?php $messages=['consent'=>'Vui lòng đồng ý nhận liên hệ và cập nhật trước khi gửi.','success'=>tp48_home_field('contact','success_message'),'invalid'=>'Vui lòng kiểm tra họ tên, email và số điện thoại (nếu có).','expired'=>'Phiên gửi đã hết hạn. Vui lòng tải lại trang và thử lại.','wait'=>'Bạn vừa gửi thông tin. Vui lòng chờ một phút trước khi gửi lại.','error'=>'Chưa thể gửi thông tin. Vui lòng thử lại.'];$status=isset($_GET['contact']) && is_string($_GET['contact']) ? sanitize_key($_GET['contact']):''; if (isset($messages[$status])): ?><p class="form-status" role="status"><?php echo esc_html($messages[$status]); ?></p><?php endif; ?>
</section>
