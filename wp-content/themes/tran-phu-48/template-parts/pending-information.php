<?php if (!defined('ABSPATH')) exit; ?>
<div class="pending-information">
<p class="eyebrow">Chờ thông tin chính thức</p>
<h3>Nội dung đang được cập nhật</h3>
<p><?php echo nl2br(tp48_detail_text('information_message')); ?></p>
<div class="pending-slots" aria-label="Các nội dung sẽ cập nhật">
<?php if (is_page_template('page-templates/mat-bang.php')): ?>
<div>Sơ đồ mặt bằng tổng thể</div><div>Bản vẽ và chú thích</div><div>Tài liệu mặt bằng</div>
<?php else: ?>
<div>Danh mục tiện ích</div><div>Hình ảnh và mô tả</div><div>Thông tin sử dụng</div>
<?php endif; ?>
</div>
</div>
