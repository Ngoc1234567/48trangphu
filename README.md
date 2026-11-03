# Website 48 Trần Phú

Theme WordPress cho website thông tin dự án tại 48 Trần Phú, Nha Trang, triển khai theo tài liệu hướng dẫn thiết kế được cung cấp ngày 03/11/2026. Giao diện xanh biển/vàng champagne, ưu tiên điện thoại; không đưa thông số hoặc hình ảnh sản phẩm chưa được xác minh lên website.

## Chạy local

- Website: http://localhost:8080
- Quản trị: http://localhost:8080/wp-admin/
- Khởi động: chạy `.codex/local/start.ps1` bằng PowerShell. Apache của XAMPP phục vụ riêng cổng 8080; PHP 8.3 được cài riêng trong `.codex/local/php83`; MySQL dùng XAMPP.
- Database local: `48_tranphu`. Thông tin đăng nhập WordPress ở `.codex/local/credentials.txt`, không nằm trong Git.
- Bản local đặt `WP_ENVIRONMENT_TYPE=local`, `blog_public=0`, luôn noindex và không nạp GA4/GSC.

## Trang và template

| Trang | URL | Template |
| --- | --- | --- |
| Trang chủ | `/` | `front-page.php` |
| Tổng quan | `/tong-quan/` | `page-templates/tong-quan.php` |
| Vị trí | `/vi-tri/` | `page-templates/vi-tri.php` |
| Mặt bằng | `/mat-bang/` | `page-templates/mat-bang.php` |
| Tiện ích | `/tien-ich/` | `page-templates/tien-ich.php` |
| Tiến độ | `/tien-do/` | `page-templates/tien-do.php` |
| The Journal | `/the-journal/` | `page-templates/the-journal.php` |
| Liên hệ | `/lien-he/` | `page-templates/lien-he.php` |
| Quyền riêng tư | `/chinh-sach-bao-mat/` | `page.php` |

Chi tiết Journal dùng `single.php`; chi tiết Tiến độ dùng `single-tp48_journal.php`; danh mục dùng `category.php` và `archive.php`. Các URL `/dau-an/`, `/nhat-ky/`, `/hinh-anh/` cũ chuyển hướng 301 sang trang mới tương ứng. Template cũ giữ lại để tương thích các lựa chọn đã lưu.

## Quản trị không cần sửa code

- **Trang → Sửa trang**: nhập nội dung bằng các khối văn bản, ảnh, thư viện ảnh, video, bảng; chọn template tương ứng. Trang chưa có dữ liệu hiển thị “Chưa có thông tin chính thức – sẽ cập nhật”. Không dùng thông số, bản vẽ hoặc hình sản phẩm chưa xác thực.
- **Cài đặt → Đọc**: Trang chủ là trang tĩnh “Trang chủ”. Không chọn The Journal làm trang bài viết vì nó dùng template danh sách riêng.
- **Giao diện → Menu**: sửa thứ tự/tên/liên kết tại vị trí “Menu chính”; có thêm vị trí “Menu chân trang”.
- **Giao diện → Tùy biến → 48 Trần Phú — Hình ảnh & nội dung**: thay ảnh khu vực, tiêu đề, mô tả vị trí và video đầu trang từ Thư viện Media. Video không bắt buộc, có nút phát/tạm dừng và tôn trọng tùy chọn giảm chuyển động.
- **Tiến độ**: đăng bản cập nhật theo thời gian, nội dung, mô tả ngắn và ảnh đại diện. Danh sách tự phân trang, liên kết tới chi tiết.
- **The Journal**: đăng bài viết, chọn danh mục và ảnh đại diện. Danh mục chỉ hiện khi có bài công khai; bài liên quan lấy từ cùng danh mục.
- **Giao diện → Tùy biến → 48 Trần Phú — Liên hệ**: sửa điện thoại/Zalo và email nhận thông báo. Hiện dùng số/email do chủ website cung cấp trong phiên làm việc.
- **Yêu cầu nhận cập nhật**: xem dữ liệu form lưu riêng tư và trạng thái chuyển email. Form yêu cầu họ tên, email và đồng ý nhận liên hệ; điện thoại không bắt buộc. Có nonce, honeypot, kiểm tra phía máy chủ và giới hạn một yêu cầu/phút theo giá trị băm địa chỉ mạng.
- **Công cụ → Xuất dữ liệu cá nhân / Xóa dữ liệu cá nhân**: WordPress có bộ xuất/xóa các yêu cầu của theme theo email sau quy trình xác minh của WordPress. Kiểm tra yêu cầu trước khi xử lý.

## SEO và đo lường

Yoast SEO miễn phí đã cài/kích hoạt, với tiêu đề và mô tả cho các trang chính, Open Graph, ảnh chia sẻ, XML sitemap và canonical do Yoast quản lý. Yoast không xuất canonical cho trang noindex; đây là hành vi của plugin. Sitemap có thể bị ẩn khi toàn site chưa mở index.

Trên production, các trang Tổng quan/Vị trí/Mặt bằng/Tiện ích chỉ mở index khi đánh dấu **Tình trạng nội dung dự án → Nội dung đã xác minh và sẵn sàng lập chỉ mục** trong trình sửa trang. Danh sách Journal/Tiến độ rỗng và trang quyền riêng tư được noindex. Bản local luôn noindex dù đánh dấu sẵn sàng.

**Giao diện → Tùy biến → 48 Trần Phú — Đo lường** có chỗ nhập GA4 Measurement ID và mã xác minh Search Console. Chỉ nạp trên production; để trống thì không chèn mã. Dùng một nơi duy nhất để chèn GA4, không chèn thêm bằng Yoast/plugin khác. Cần cập nhật thông báo quyền riêng tư theo cấu hình đo lường thật trước khi bật.

## Những phần cần hosting/tài khoản chính thức

1. Bổ sung nội dung, ảnh/video đã xác minh và quyền sử dụng; ảnh hiện có chỉ minh họa khu vực, nguồn ở `ASSETS.md`.
2. Cấu hình SMTP bằng tài khoản do chủ website cấp quyền để gửi tới email quản trị; thử nhận email thật. Bản local đã kiểm tra lưu form và xử lý lỗi gửi mail, chưa xác nhận khả năng nhận email thực tế. `wp_mail()` trả true chỉ thể hiện hệ thống đã chấp nhận gửi, không đảm bảo thư đến hộp thư.
3. Sau khi duyệt demo, sao lưu và chuyển source/database/uploads lên hosting do chủ website quản lý. Cập nhật URL trong database bằng công cụ hỗ trợ dữ liệu serialized; thay `WP_HOME`, `WP_SITEURL`, thông tin DB và khóa/salt theo môi trường. Đổi `WP_ENVIRONMENT_TYPE` thành `production`.
4. Cấp SSL/HTTPS tự gia hạn trên hosting và bật chuyển hướng HTTP → HTTPS tại cấu hình hosting; không ép HTTPS cho localhost. Kiểm tra mixed content và mọi liên kết.
5. Trong Cài đặt → Đọc, bỏ chặn máy tìm kiếm khi website chính thức đủ nội dung. Kiểm tra lại từng trang; giữ noindex cho trang chưa sẵn sàng. Kiểm tra canonical/robots và `/sitemap_index.xml` trên tên miền thật.
6. Chủ website xác minh `48tranphu.vn` trong Search Console bằng tài khoản của mình, gửi sitemap, kiểm tra thu thập dữ liệu. Cần quyền truy cập phù hợp, chưa thực hiện trên local.
7. Nhập ID GA4 của chủ website, kiểm tra Realtime/DebugView trên tên miền thật; xác nhận không có mã đo lường trùng. Chưa có Measurement ID nên local không gắn GA4.
8. Xác nhận nguồn/giấy phép ảnh, font và plugin; kiểm tra cache, hiệu năng và email trên hosting thật. Bàn giao quyền Administrator và bản sao lưu; không đưa mật khẩu tài khoản Google/tên miền/hosting vào source.

## Mã nguồn và sao lưu

Theme nằm ở `wp-content/themes/tran-phu-48`, phần chức năng tách trong `inc/`, phần giao diện chung trong `template-parts/`. Yoast SEO ở `wp-content/plugins/wordpress-seo` (miễn phí, giấy phép theo file của plugin). Các plugin có sẵn: ACF, Classic Editor và Contact Form 7; form nhận cập nhật hiện dùng bộ xử lý của theme, không cần gán form CF7.

`.codex/local/` chứa bản sao lưu trước khi sửa, bản sao lưu sau triển khai và kết quả kiểm thử nội bộ. Không commit thư mục này, `wp-config.php`, SQL, dữ liệu cá nhân hoặc thông tin đăng nhập. Khi bàn giao giữa các máy, chuyển database/uploads và thiết lập PHP riêng; Git chỉ mang source, không tự mang các trang/menu trong database.

## Trang chủ giữ giao diện cũ

Theo yêu cầu cập nhật, trang chủ sử dụng lại bố cục trước khi triển khai tài liệu thiết kế: banner 48 Trần Phú, bốn biểu tượng, Vị trí, Dấu ấn Nha Trang, Hình ảnh, Nhật ký công trình và form cuối trang. Giao diện riêng ở `assets/home-classic.css`, các phần ở `template-parts/home-classic/`. Những trang chi tiết tiếp tục dùng giao diện mới và menu chính tám mục; trang chủ giữ thanh điều hướng theo bố cục cũ.

Sửa tiêu đề/phụ đề banner cũ trong **Giao diện → Tùy biến → 48 Trần Phú — Hình ảnh & nội dung → Trang chủ cũ — Tiêu đề / Phụ đề**. Form trang chủ vẫn yêu cầu đồng ý nhận liên hệ, dùng chung bộ xử lý lưu yêu cầu và chống spam hiện tại.
