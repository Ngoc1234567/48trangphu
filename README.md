# 48 Trần Phú — WordPress

Bộ WordPress đầy đủ cùng theme `wp-content/themes/tran-phu-48`. Không cần Elementor hoặc plugin dựng trang. Theme có giao diện desktop/mobile, thư viện ảnh, nhật ký công trình và form liên hệ.

## Cài đặt

1. Đặt mã nguồn vào web root của hosting có PHP và MySQL/MariaDB.
2. Tạo database và tài khoản database.
3. Điền `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_HOST` vào `wp-config.php`. Nếu clone từ Git, sao chép `wp-config-sample.php` thành `wp-config.php` và thay các khóa/salt bằng giá trị ngẫu nhiên riêng.
4. Mở website để hoàn tất trình cài đặt WordPress và tạo tài khoản quản trị.
5. Vào **Giao diện → Giao diện**, kích hoạt **48 Trần Phú**. Trang chủ tự hiển thị bố cục đã dựng.

Không kèm database hoặc nội dung chạy thử. `wp-config.php` trên máy hiện tại chứa các giá trị database mẫu, cần điền thông tin thật trước khi chạy. Không còn địa chỉ localhost cố định hoặc phụ thuộc socket/database của môi trường thử nghiệm.

## Quản lý nội dung

- **Giao diện → Tùy biến → 48 Trần Phú — Trang chủ**: thay ảnh nền, tiêu đề, phụ đề và mô tả.
- **Nhật ký công trình**: đăng bài cập nhật tiến độ. Trang chủ hiển thị tối đa sáu bài mới nhất khi mở phần nhật ký.
- **Liên hệ từ website**: xem liên hệ được lưu riêng tư. Form có kiểm tra dữ liệu, nonce, honeypot và giới hạn gửi. Email thông báo gửi đến email quản trị; cần cấu hình gửi mail trên hosting để nhận email.

Ảnh hiện là ảnh minh họa thay thế, chưa phải bộ ảnh gốc của mẫu. Nguồn ảnh nằm trong [ASSETS.md](wp-content/themes/tran-phu-48/ASSETS.md). Logo được dựng bằng chữ, font Playfair Display và Inter tải qua Google Fonts.

## Git

Theo dõi WordPress core và theme tùy chỉnh. Không commit `wp-config.php`, file SQL, uploads, cache hoặc bản sao lưu. Database và ảnh do người quản trị tải lên cần được chuyển riêng giữa các môi trường.

Theme đã kiểm tra trên WordPress/PHP 8.3 với sáu chiều rộng màn hình, menu mobile, thư viện ảnh, mở nhật ký và lưu liên hệ. Sau khi cài lên hosting cần kiểm tra lại kết nối database, permalink và email trên môi trường đó.
