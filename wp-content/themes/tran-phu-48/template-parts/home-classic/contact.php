<?php if (!defined('ABSPATH')) exit; ?>
<section class="contact ruled" id="kham-pha" aria-labelledby="contact-title">
        <h2 id="contact-title">Khám phá thêm<br>về 48 Trần Phú</h2>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="contact-form">
            <input type="hidden" name="return_url" value="<?php echo esc_url(is_page() ? get_permalink() : home_url('/')); ?>">
            <input type="hidden" name="action" value="tp48_contact"><?php wp_nonce_field('tp48_contact', 'tp48_nonce'); ?>
            <div class="honeypot" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
            <label class="sr-only" for="full-name">Họ và tên</label><input id="full-name" name="full_name" placeholder="Họ và tên" autocomplete="name" maxlength="100" required>
            <label class="sr-only" for="phone">Số điện thoại</label><input id="phone" name="phone" type="tel" placeholder="Số điện thoại" autocomplete="tel" pattern="[+0-9 \(\)\.\-]{8,20}" maxlength="20">
            <label class="sr-only" for="email">Email</label><input id="email" name="email" type="email" placeholder="Email" autocomplete="email" maxlength="254" required>
            <button class="button gold" type="submit">Discover more <span aria-hidden="true">⟶</span></button>
            <label class="classic-consent"><input type="checkbox" name="consent" value="1" required><span>Tôi đồng ý nhận liên hệ/cập nhật theo <a href="<?php echo esc_url(tp48_page_url('chinh-sach-bao-mat')); ?>">chính sách quyền riêng tư</a>.</span></label>
            <span class="form-note">Thông tin được sử dụng để phản hồi yêu cầu tìm hiểu của bạn.</span>
        </form>
        <?php $messages = ['consent' => 'Vui lòng đồng ý nhận liên hệ và cập nhật trước khi gửi.', 'success' => 'Cảm ơn bạn. Thông tin của bạn đã được ghi nhận.', 'invalid' => 'Vui lòng nhập đầy đủ họ tên, số điện thoại và email hợp lệ.', 'expired' => 'Phiên gửi đã hết hạn. Vui lòng tải lại trang và thử lại.', 'wait' => 'Bạn vừa gửi thông tin. Vui lòng chờ một phút trước khi gửi lại.', 'error' => 'Chưa thể gửi thông tin. Vui lòng thử lại.']; $status = isset($_GET['contact']) && is_string($_GET['contact']) ? sanitize_key($_GET['contact']) : ''; if (isset($messages[$status])): ?>
        <p class="form-status" role="status"><?php echo esc_html($messages[$status]); ?></p>
        <?php endif; ?>
    </section>
