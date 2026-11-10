<footer class="project-footer">
    <div class="project-footer-main">
        <div><a class="project-footer-brand" href="<?php echo esc_url(home_url('/')); ?>">48 TRẦN PHÚ<span>NHA TRANG</span></a><p>Thông tin dự án, vị trí và tiến độ công trình.</p></div>
        <nav class="project-footer-social" aria-label="Kết nối với dự án">
            <?php if (tp48_phone()): ?>
            <a href="tel:<?php echo esc_attr(tp48_phone()); ?>" aria-label="Gọi điện" title="Gọi điện"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m7 3 3 5-2 2c1 3 3 5 6 6l2-2 5 3-1 3c-1 3-7 0-11-4S2 6 4 4Z"/></svg></a>
            <a href="<?php echo esc_url(tp48_zalo()); ?>" target="_blank" rel="noopener noreferrer" aria-label="Chat Zalo (mở tab mới)" title="Zalo"><span>Zalo</span></a>
            <?php endif; ?>
            <?php if (tp48_text('facebook')): ?><a href="<?php echo esc_url(tp48_text('facebook')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook (mở tab mới)" title="Facebook"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 22v-9h3l.5-4H14V7c0-1 .3-2 2-2h2V1.5L15 1c-3 0-5 2-5 5v3H7v4h3v9Z"/></svg></a><?php endif; ?>
            <?php if (tp48_messenger()): ?><a class="messenger-link" href="<?php echo esc_url(tp48_messenger()); ?>" target="_blank" rel="noopener noreferrer" aria-label="Nhắn tin Messenger (mở tab mới)" title="Messenger">Messenger</a><?php endif; ?>
        </nav>
    </div>
    <div class="project-footer-bottom"><span>© <?php echo esc_html(wp_date('Y')); ?> 48 Trần Phú</span><a href="<?php echo esc_url(tp48_page_url('chinh-sach-bao-mat')); ?>">Quyền riêng tư</a></div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
