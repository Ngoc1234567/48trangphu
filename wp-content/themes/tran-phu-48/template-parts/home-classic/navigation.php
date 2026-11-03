    <nav id="main-nav" aria-label="Điều hướng chính">
        <?php foreach (['vi-tri' => 'Vị trí', 'tong-quan' => 'Dấu ấn Nha Trang', 'hinh-anh' => 'Hình ảnh', 'tien-do' => 'Nhật ký công trình', 'lien-he' => 'Liên hệ'] as $slug => $label): ?>
        <a href="<?php echo esc_url(tp48_page_url($slug)); ?>"<?php if (is_page($slug)) echo ' aria-current="page"'; ?>><?php echo esc_html($label); ?></a>
        <?php endforeach; ?>
    </nav>
