<?php
/** Editable interior pages and progress updates. Uses ACF Free field types. */
if (!defined('ABSPATH')) exit;

function tp48_detail_defaults() {
    return [
        'overview_heading'=>'Dự án tại 48 Trần Phú',
        'overview_facts'=>"Địa chỉ: 48 Trần Phú, Nha Trang.\nVị trí: đối diện Quảng trường 2/4, gần Tháp Trầm Hương.",
        'overview_intro'=>'Website giới thiệu thông tin về dự án tại 48 Trần Phú, Nha Trang; tập hợp nội dung tổng quan, vị trí và các cập nhật về tiến độ công trình. Thông tin chi tiết sẽ được bổ sung khi có tài liệu chính thức được xác nhận.',
        'overview_caption'=>'Hình ảnh minh họa ý tưởng, không phải phối cảnh chính thức của dự án.',
        'location_heading'=>'48 Trần Phú · Nha Trang',
        'location_relationship'=>'48 Trần Phú đối diện Quảng trường 2/4, gần Tháp Trầm Hương.',
        'map_query'=>'48 Tran Phu Nha Trang',
        'map_note'=>'Bản đồ tra cứu khu vực, không thể hiện ranh giới pháp lý của dự án.',
        'location_intro'=>'Địa chỉ dự án: 48 Trần Phú, Nha Trang. Thông tin lối tiếp cận và ảnh khảo sát hiện trạng sẽ được bổ sung sau khi xác nhận.',
        'location_photo_caption'=>'Ảnh khu vực tham khảo, không phải ảnh hiện trạng công trình.',
        'landmark_photo_caption'=>'Tháp Trầm Hương — điểm nhận diện khu vực quảng trường ven biển. Ảnh khu vực tham khảo.',
        'landmark_1_title'=>'Đường Trần Phú',
        'landmark_1_description'=>'Trục đường ven biển để nhận diện khu vực địa chỉ dự án.',
        'landmark_2_title'=>'Tháp Trầm Hương',
        'landmark_2_description'=>'Điểm nhận diện khu vực trung tâm ven biển Nha Trang. Tra cứu vị trí tương quan trên bản đồ.',
        'landmark_3_title'=>'Quảng trường 2/4 và cột cờ',
        'landmark_3_description'=>'Các điểm nhận diện để đối chiếu khi xem ảnh khu vực và khảo sát thực tế.',
        'progress_heading'=>'Tiến độ công trình',
        'progress_intro'=>'Các cập nhật và hình ảnh được đăng tải khi có thông tin xác nhận.',
        'progress_empty'=>'Chưa có bản cập nhật tiến độ được xác nhận. Các bản cập nhật sẽ được xếp mới nhất lên đầu, kèm ngày cập nhật, ảnh hoặc video và mô tả ngắn.',
        'progress_show_preview'=>1,
        'information_status'=>'waiting',
        'information_heading'=>'',
        'information_intro'=>'Thông tin sẽ được đăng tải khi có tài liệu chính thức được xác nhận.',
        'information_message'=>'Chưa có thông tin chính thức – sẽ cập nhật',
        'contact_heading'=>'Nhận cập nhật về dự án',
        'contact_intro'=>'Để lại thông tin để nhận các cập nhật về dự án, vị trí và tiến độ công trình.',
        'information_button_label'=>'Nhận cập nhật về dự án',
    ];
}
function tp48_detail_field($name,$id=0) {
    $id=$id ?: get_the_ID();
    if (function_exists('get_field') && metadata_exists('post',$id,'tp48_'.$name)) return get_field('tp48_'.$name,$id);
    return tp48_detail_defaults()[$name] ?? '';
}
function tp48_detail_text($name,$id=0) { return esc_html((string)tp48_detail_field($name,$id)); }
function tp48_detail_body($name,$id=0) { echo wp_kses_post(wpautop((string)tp48_detail_field($name,$id))); }
function tp48_progress_date($id=0,$format='d.m.Y') {
    $id=$id ?: get_the_ID();
    $date=tp48_detail_field('update_date',$id);
    $timestamp=$date ? strtotime($date.' 12:00:00'):false;
    return $timestamp ? wp_date($format,$timestamp):get_the_date($format,$id);
}
function tp48_progress_summary($id=0) {
    $id=$id ?: get_the_ID();
    $summary=tp48_detail_field('update_description',$id);
    echo $summary!=='' ? wp_kses_post(wpautop((string)$summary)):wp_kses_post(wpautop(get_the_excerpt($id)));
}
function tp48_interior_field_groups() {
    $defaults=tp48_detail_defaults();
    $field=function($name,$label,$type='text',$extra=[]) use ($defaults) {
        $base=['key'=>'field_tp48_'.$name,'name'=>'tp48_'.$name,'label'=>$label,'type'=>$type,'default_value'=>$defaults[$name] ?? ''];
        if ($type==='image') $base+=['return_format'=>'id','preview_size'=>'medium','library'=>'all'];
        if ($type==='wysiwyg') $base+=['tabs'=>'all','toolbar'=>'basic','media_upload'=>0];
        return array_merge($base,$extra);
    };
    $group=function($slug,$title,$fields,$location) { return ['key'=>'group_tp48_'.$slug,'title'=>$title,'fields'=>$fields,'location'=>$location,'position'=>'normal','style'=>'default','active'=>true,'description'=>'Chỉnh nội dung hiển thị trực tiếp trên website. Chỉ dùng thông tin và hình ảnh đã xác nhận.']; };
    $page=function($slug) { return [[['param'=>'page_template','operator'=>'==','value'=>'page-templates/'.$slug.'.php']]]; };
    $overview=$group('overview','48 Trần Phú — Tổng quan',[
        $field('overview_image','Ảnh lớn','image'),$field('overview_caption','Chú thích dưới ảnh','textarea'),
        $field('overview_heading','Tiêu đề giới thiệu'),$field('overview_intro','Giới thiệu ngắn','wysiwyg'),
        $field('overview_facts','Thông tin đã xác nhận','textarea',['instructions'=>'Chỉ nhập các thông tin đã xác nhận; mỗi ý một dòng. Để trống để ẩn mục này.']),
        $field('overview_button','Liên kết khám phá vị trí','link',['return_format'=>'array']),
    ],$page('tong-quan'));
    $location_fields=[
        $field('location_relationship','Vị trí và các điểm lân cận','textarea'),
        $field('location_heading','Tiêu đề vị trí'),$field('map_query','Địa chỉ tìm trên Google Maps','text',['instructions'=>'Nhập địa chỉ hoặc tên địa điểm; website tự tạo bản đồ và nút mở bản đồ. Không nhập mã iframe.']),
        $field('map_note','Chú thích bản đồ','textarea'),$field('location_photo','Ảnh khu vực / thực địa','image'),
        $field('location_photo_caption','Chú thích ảnh khu vực','textarea'),$field('location_intro','Giới thiệu vị trí','wysiwyg'),
        $field('landmark_photo','Ảnh các điểm nhận diện','image'),$field('landmark_photo_caption','Chú thích ảnh nhận diện','textarea'),
    ];
    for ($i=1;$i<=3;$i++) {
        $location_fields[]=$field('landmark_'.$i.'_title','Điểm nhận diện '.$i.' — Tên');
        $location_fields[]=$field('landmark_'.$i.'_description','Điểm nhận diện '.$i.' — Chú thích','textarea');
    }
    $location=$group('location','48 Trần Phú — Vị trí',$location_fields,$page('vi-tri'));
    $progress=$group('progress_page','48 Trần Phú — Trang tiến độ',[
        $field('progress_heading','Tiêu đề danh sách'),$field('progress_intro','Giới thiệu','textarea'),
        $field('progress_empty','Thông báo khi chưa có cập nhật','textarea'),$field('progress_show_preview','Hiện khung mẫu khi chưa có cập nhật','true_false',['ui'=>1]),
    ],$page('tien-do'));
    $information=$group('information','48 Trần Phú — Mặt bằng / Tiện ích',[
        $field('information_status','Trạng thái nội dung','select',['choices'=>['waiting'=>'Chờ thông tin chính thức','ready'=>'Đã có thông tin chính thức'],'allow_null'=>0]),
        $field('information_heading','Tiêu đề (để trống dùng tên trang)'),$field('information_intro','Giới thiệu ngắn','textarea'),
        $field('information_message','Thông báo chờ','textarea'),
        $field('information_image','Ảnh / sơ đồ chính thức','image',['conditional_logic'=>[[['field'=>'field_tp48_information_status','operator'=>'==','value'=>'ready']]]]),
        $field('information_caption','Chú thích ảnh'),
        $field('information_content','Nội dung chính thức','wysiwyg',['media_upload'=>1,'conditional_logic'=>[[['field'=>'field_tp48_information_status','operator'=>'==','value'=>'ready']]]]),
        $field('information_document','Tài liệu chính thức (PDF)','file',['return_format'=>'id','mime_types'=>'pdf']),
        $field('information_button_label','Tên nút nhận cập nhật'),
    ],array_merge($page('mat-bang'),$page('tien-ich')));
    $update=$group('progress_update','48 Trần Phú — Bản cập nhật tiến độ',[
        $field('update_is_demo','Video / nội dung mẫu để duyệt bố cục','true_false',['ui'=>1,'instructions'=>'Bật để hiện nhãn rõ đây là nội dung mẫu, không phải tiến độ thực tế.']),
        $field('update_date','Ngày cập nhật','date_picker',['display_format'=>'d/m/Y','return_format'=>'Y-m-d','instructions'=>'Để trống dùng ngày đăng. Danh sách xếp theo ngày cập nhật mới nhất.']),
        $field('update_image','Ảnh công trình','image'),
        $field('update_video','Video công trình (MP4 / WebM)','file',['return_format'=>'id','mime_types'=>'mp4,webm','instructions'=>'Khi có cả ảnh và video, video hiển thị trước; ảnh dùng làm ảnh đại diện video.']),
        $field('update_description','Mô tả ngắn','textarea',['rows'=>4]),
    ],[[['param'=>'post_type','operator'=>'==','value'=>'tp48_journal']]]);
    $contact=$group('contact_page','48 Trần Phú — Liên hệ',[
        $field('contact_heading','Tiêu đề form'),$field('contact_intro','Giới thiệu form','textarea'),
        $field('contact_recipient','Email nhận thông báo','email',['instructions'=>'Để trống dùng email liên hệ đã cấu hình. Email này không hiển thị ra ngoài website.']),
    ],$page('lien-he'));
    return [$overview,$location,$progress,$information,$update,$contact];
}
add_action('acf/init',function() {
    if (function_exists('acf_add_local_field_group')) foreach (tp48_interior_field_groups() as $group) acf_add_local_field_group($group);
});
add_filter('acf/update_value/key=field_tp48_update_date',function($value) {
    if (!$value) return '';
    $timestamp=strtotime((string)$value);
    return $timestamp ? gmdate('Ymd',$timestamp):'';
});
// Scope ordering to the progress list; undated legacy entries use their publication date.
add_filter('posts_clauses',function($clauses,$query) {
    if (!$query->get('tp48_progress_order')) return $clauses;
    global $wpdb;
    $clauses['join'].=$wpdb->prepare(" LEFT JOIN (SELECT post_id, MAX(meta_value) AS event_date FROM {$wpdb->postmeta} WHERE meta_key=%s GROUP BY post_id) tp48_dates ON {$wpdb->posts}.ID=tp48_dates.post_id ",'tp48_update_date');
    $clauses['orderby']="COALESCE(STR_TO_DATE(REPLACE(NULLIF(tp48_dates.event_date,''),'-',''),'%Y%m%d'), DATE({$wpdb->posts}.post_date)) DESC, {$wpdb->posts}.post_date DESC, {$wpdb->posts}.ID DESC";
    return $clauses;
},10,2);
