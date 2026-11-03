<?php if (!is_front_page() && !is_page_template('front-page.php')): ?>
<footer class="site-footer">
    <div><a class="footer-title" href="<?php echo esc_url(home_url('/')); ?>">48 TRẦN PHÚ <span>NHA TRANG</span></a><p>Website thông tin về dự án tại 48 Trần Phú, Nha Trang.</p><p class="fine-print">Thông tin dự án được cập nhật khi có xác nhận. Hình ảnh khu vực dùng để minh họa, không thể hiện thiết kế hay sản phẩm của dự án.</p></div>
    <div class="footer-contact"><p class="eyebrow">Trao đổi thông tin</p>
    <?php if (tp48_phone()): ?><a href="tel:<?php echo esc_attr(tp48_phone()); ?>"><?php echo esc_html(tp48_text('phone')); ?></a><?php endif; ?>
    <?php if (tp48_text('email')): ?><a href="mailto:<?php echo esc_attr(tp48_text('email')); ?>"><?php echo esc_html(tp48_text('email')); ?></a><?php endif; ?>
    </div>
    <div class="footer-bottom"><span>© <?php echo esc_html(wp_date('Y')); ?> 48 Trần Phú</span><a href="<?php echo esc_url(tp48_page_url('chinh-sach-bao-mat')); ?>">Quyền riêng tư</a><?php wp_nav_menu(['theme_location'=>'footer','container'=>false,'menu_class'=>'footer-nav','fallback_cb'=>false,'depth'=>1]); ?></div>
</footer>
<?php if (tp48_phone()): ?>
<nav class="contact-dock" aria-label="Liên hệ nhanh"><a href="tel:<?php echo esc_attr(tp48_phone()); ?>"><span aria-hidden="true">↗</span> Gọi điện</a><a href="<?php echo esc_url(tp48_zalo()); ?>" target="_blank" rel="noopener noreferrer">Zalo <span class="sr-only">(mở cửa sổ mới)</span></a><a href="<?php echo esc_url(tp48_page_url('lien-he')); ?>">Nhận cập nhật</a></nav>
<?php endif; ?>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
