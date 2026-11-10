<?php
if (!defined('ABSPATH')) exit;
add_action('customize_register',function ($c) {
    $c->add_section('tp48_home',['title'=>'48 Trần Phú — Ảnh mặc định / trang chi tiết','description'=>'Nội dung Trang chủ hiện chỉnh tại Trang → Trang chủ → nhóm field ACF. Các thiết lập này dùng cho trang chi tiết và dữ liệu dự phòng.','priority'=>30]);
    foreach (['hero'=>'Ảnh đầu trang (khu vực)','location'=>'Ảnh khu vực đường Trần Phú','sunrise'=>'Ảnh khu vực vịnh Nha Trang'] as $key=>$label) {
        $c->add_setting('tp48_image_'.$key,['default'=>tp48_image($key),'sanitize_callback'=>'esc_url_raw']);
        $c->add_control(new WP_Customize_Image_Control($c,'tp48_image_'.$key,['label'=>$label,'section'=>'tp48_home']));
    }
    foreach (['location'=>['Giới thiệu vị trí','Địa điểm dự án: 48 Trần Phú, Nha Trang. Thông tin chi tiết sẽ được cập nhật khi có xác nhận.']] as $key=>$field) {
        $c->add_setting('tp48_'.$key,['default'=>$field[1],'sanitize_callback'=>'sanitize_textarea_field']);
        $c->add_control('tp48_'.$key,['label'=>$field[0],'section'=>'tp48_home','type'=>'textarea']);
    }
    $c->add_section('tp48_contact',['title'=>'48 Trần Phú — Liên hệ','priority'=>31]);
    foreach (['phone'=>['Số điện thoại / Zalo','text','sanitize_text_field'],'email'=>['Email nhận yêu cầu','email','sanitize_email']] as $key=>$field) {
        $c->add_setting('tp48_'.$key,['default'=>$key==='phone' ? '0906126393':'tranduyhung.man@gmail.com','sanitize_callback'=>$field[2]]);
        $c->add_control('tp48_'.$key,['label'=>$field[0],'type'=>$field[1],'section'=>'tp48_contact']);
    }
    $c->add_section('tp48_tracking',['title'=>'48 Trần Phú — Đo lường','description'=>'Chỉ bật trên website chính thức. Không chèn lại GA4 bằng plugin khác khi dùng mục này.','priority'=>32]);
    $c->add_setting('tp48_messenger',['sanitize_callback'=>'esc_url_raw']);
    $c->add_control('tp48_messenger',['label'=>'Liên kết Messenger','description'=>'Nhập link https://m.me/ten-fanpage. Để trống để ẩn nút khi chưa có fanpage.','type'=>'url','section'=>'tp48_contact']);
    $c->add_setting('tp48_facebook',['sanitize_callback'=>'esc_url_raw']);
    $c->add_control('tp48_facebook',['label'=>'Liên kết Facebook (để trống để ẩn icon)','type'=>'url','section'=>'tp48_contact']);
    $c->add_setting('tp48_ga4',['sanitize_callback'=>function ($v) { return preg_match('/^G-[A-Z0-9]+$/',trim($v)) ? trim($v) : ''; }]);
    $c->add_control('tp48_ga4',['label'=>'GA4 Measurement ID (G-...)','section'=>'tp48_tracking']);
    $c->add_setting('tp48_gsc',['sanitize_callback'=>function ($v) { return preg_replace('/[^a-zA-Z0-9_-]/','',$v); }]);
    $c->add_control('tp48_gsc',['label'=>'Search Console: mã xác minh HTML','section'=>'tp48_tracking']);
});
add_action('add_meta_boxes_page',function () {
    add_meta_box('tp48_readiness','Tình trạng nội dung dự án',function ($post) {
        wp_nonce_field('tp48_readiness','tp48_readiness_nonce');
        echo '<p><label><input type="checkbox" name="tp48_ready" value="1" '.checked(get_post_meta($post->ID,'_tp48_ready',true),'1',false).'> Nội dung đã xác minh và sẵn sàng lập chỉ mục</label></p><p>Chỉ đánh dấu khi nội dung/ảnh đã được xác nhận. Trang chưa sẵn sàng sẽ được noindex. Môi trường local luôn noindex.</p>';
    },'page','side');
});
add_action('save_post_page',function ($id) {
    if (!isset($_POST['tp48_readiness_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tp48_readiness_nonce'])),'tp48_readiness') || !current_user_can('edit_post',$id) || wp_is_post_revision($id) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) return;
    update_post_meta($id,'_tp48_ready',!empty($_POST['tp48_ready']) ? '1':'0');
});
add_filter('manage_tp48_inquiry_posts_columns',function ($cols) { $cols['tp48_mail']='Email thông báo'; return $cols; });
add_action('manage_tp48_inquiry_posts_custom_column',function ($col,$id) { if ($col==='tp48_mail') echo esc_html(get_post_meta($id,'_tp48_mail_sent',true)==='1' ? 'Đã chuyển tới hệ thống gửi mail' : 'Chưa gửi được — kiểm tra SMTP'); },10,2);
