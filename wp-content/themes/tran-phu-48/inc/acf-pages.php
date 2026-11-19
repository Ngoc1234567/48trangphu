<?php
/** Editable interior pages and progress updates. Uses ACF Free field types. */
if (!defined('ABSPATH')) exit;

function tp48_detail_defaults() {
    return [
        'overview_heading'=>'Dự án tại 48 Trần Phú',
        'overview_facts'=>'',
        'overview_intro'=>'',
        'overview_caption'=>'',
        'location_heading'=>'48 Trần Phú · Nha Trang',
        'location_relationship'=>'48 Trần Phú đối diện Quảng trường 2/4, gần Tháp Trầm Hương.',
        'map_query'=>'48 Tran Phu Nha Trang',
        'map_note'=>'Bản đồ tra cứu khu vực, không thể hiện ranh giới pháp lý của dự án.',
        'location_corner_heading'=>'Hai mặt đường tại góc giao trung tâm',
        'location_corner_alt'=>'Khu đất 48 Trần Phú tại góc giao Nguyễn Thị Minh Khai nhìn từ trên cao.',
        'location_sea_heading'=>'Nhìn từ biển vào',
        'location_sea_alt'=>'Vị trí khu đất 48 Trần Phú nhìn từ biển, cạnh Quảng trường 2/4 và Tháp Trầm Hương.',
        'location_sea_note'=>'Đường viền đỏ chỉ là dấu nhận diện, không dùng làm ranh giới địa chính.',
        'location_overview_label'=>'Xem tổng quan dự án',
        'location_overview_path'=>'/tong-quan/',
        'location_progress_label'=>'Theo dõi tiến độ',
        'location_progress_path'=>'/tien-do/',
        'progress_title'=>'Tiến độ dự án 48 Trần Phú Nha Trang',
        'progress_heading'=>'Tiến độ công trình',
        'progress_intro'=>'',
        'update_button_label'=>'Xem cập nhật chi tiết',
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
function tp48_detail_body($name,$id=0) {
    $html=wp_kses_post(wpautop((string)tp48_detail_field($name,$id)));
    if ($name==='overview_direction') {
        $processor=new WP_HTML_Tag_Processor($html);
        while ($processor->next_tag('A')) {
            if (!$processor->get_attribute('href')) continue;
            $processor->set_attribute('target','_blank');
            $rel=preg_split('/\s+/',trim((string)$processor->get_attribute('rel')),-1,PREG_SPLIT_NO_EMPTY);
            $processor->set_attribute('rel',implode(' ',array_unique(array_merge($rel,['noopener','noreferrer']))));
        }
        $html=$processor->get_updated_html();
    }
    echo $html;
}
function tp48_progress_youtube_embed($url) {
    $parts=wp_parse_url($url);
    if (!$parts || !in_array(strtolower($parts['scheme'] ?? ''),['http','https'],true)) return '';
    $host=strtolower($parts['host'] ?? '');
    $path=trim($parts['path'] ?? '','/');
    $id='';
    if (in_array($host,['youtu.be','www.youtu.be'],true)) {
        $id=$path;
    } elseif (in_array($host,['youtube.com','www.youtube.com','m.youtube.com','youtube-nocookie.com','www.youtube-nocookie.com'],true)) {
        if ($path==='watch') {
            parse_str($parts['query'] ?? '',$query);
            $id=$query['v'] ?? '';
        } elseif (preg_match('~^(?:shorts|embed|live)/([A-Za-z0-9_-]{11})$~',$path,$matches)) {
            $id=$matches[1];
        }
    }
    return is_string($id) && preg_match('/^[A-Za-z0-9_-]{11}$/',$id) ? 'https://www.youtube.com/embed/'.$id.'?playsinline=1' : '';
}
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
        $field('overview_title','1. Tiêu đề đầu trang (H1)','text',['default_value'=>'Tổng quan dự án 48 Trần Phú Nha Trang']),
        $field('overview_intro','1. Giới thiệu ngay dưới H1','textarea',['default_value'=>'','rows'=>5,'instructions'=>'Nhập đoạn giới thiệu theo file 01.']),
        $field('overview_facts','2. Bảng thông tin dự án','textarea',['default_value'=>'','rows'=>10,'instructions'=>'Mỗi dòng một cặp Nhãn: Giá trị. Ví dụ định dạng: Địa chỉ: … Website tách ở dấu hai chấm đầu tiên. Để trống để ẩn bảng.']),
        $field('overview_image','2. Ảnh thực tế bên cạnh bảng','image',['instructions'=>'Máy tính: ảnh bên trái 45%. Điện thoại: ảnh sau bảng. Để trống để ẩn ảnh.']),
        $field('overview_caption','2. Chú thích ảnh thực tế','textarea',['default_value'=>'','rows'=>2]),
        $field('overview_direction','3. Định hướng công trình','wysiwyg',['instructions'=>'Nhập khối chữ ngắn theo file 01. Bôi đen chữ rồi bấm biểu tượng liên kết hoặc Ctrl + K để chèn link. Để trống để ẩn khối.']),
        $field('overview_source_text','4. Dòng nguồn quy hoạch','textarea',['rows'=>2]),
        $field('overview_source_link','4. Liên kết nguồn quy hoạch','link',['return_format'=>'array','instructions'=>'Nhập URL và chữ liên kết. Luôn mở tab mới.']),
        $field('overview_actions_help','5. Nút điều hướng','message',['message'=>'Hai nút cố định: Khám phá vị trí → /vi-tri/ và Theo dõi tiến độ → /tien-do/.']),
    ],$page('tong-quan'));
    $location_fields=[
        $field('location_map_tab','1. Bản đồ','tab'),
        $field('location_help','Cách nhập trang Vị trí','message',['message'=>'Nhập lần lượt theo 4 tab, cùng thứ tự hiển thị trên trang. Tiêu đề đầu trang dùng tên Trang ở phía trên. Hai ảnh mới thay ảnh demo; chưa chọn ảnh thì website ẩn ảnh. Nhập xong bấm Cập nhật và Xem trang.']),
        $field('location_heading','Tiêu đề phần bản đồ'),
        $field('location_relationship','Giới thiệu vị trí','textarea',['rows'=>3]),
        $field('map_query','Địa chỉ tìm trên Google Maps','text',['instructions'=>'Nhập địa chỉ hoặc tên địa điểm; website tự tạo bản đồ. Không nhập mã iframe.']),
        $field('map_link','Link ghim Google Maps','url',['instructions'=>'Dán link ghim chính xác. Để trống dùng tìm kiếm theo địa chỉ ở trên.']),
        $field('map_note','Chú thích bản đồ','textarea',['rows'=>2]),
    ];
    foreach (['corner'=>['2. Góc giao hai đường','01-goc-giao-hai-duong.webp','Giữ cả hai nhãn tên đường trên ảnh. Ảnh hiển thị nguyên tỷ lệ, không cắt khung.'],
              'sea'=>['3. Nhìn từ biển','02-vi-tri-nhin-tu-bien.webp','Giữ trong khung cả khu đất đánh dấu, quảng trường và Tháp Trầm Hương. Ảnh hiển thị nguyên tỷ lệ, không cắt khung.']] as $key=>$config) {
        $prefix='location_'.$key;
        $location_fields[]=$field($prefix.'_tab',$config[0],'tab');
        $location_fields[]=$field($prefix.'_heading','Tiêu đề mục');
        $location_fields[]=$field($prefix.'_image','Ảnh','image',['instructions'=>'Chọn tệp '.$config[1].'. '.$config[2]]);
        $location_fields[]=$field($prefix.'_alt','ALT — mô tả ảnh cho trình đọc màn hình','text',['instructions'=>'Đã điền theo yêu cầu khách hàng. Có thể sửa trực tiếp tại đây, không cần vào Thư viện.']);
        $location_fields[]=$field($prefix.'_caption','Chú thích ngay dưới ảnh','textarea',['rows'=>3,'instructions'=>'Chỉ dán nội dung chú thích. Không dán nhãn “Chú thích ảnh 01/02” từ file nội dung. Để trống để ẩn chú thích.']);
        $location_fields[]=$field($prefix.'_description','Đoạn mô tả','wysiwyg',['instructions'=>'Dán đoạn mô tả tương ứng trong file nội dung. Hiển thị dưới chú thích ảnh. Để trống để ẩn.']);
        if ($key==='sea') $location_fields[]=$field($prefix.'_note','Lưu ý về đường viền đỏ','textarea',['rows'=>2,'instructions'=>'Hiển thị dưới ảnh, trước đoạn mô tả.']);
    }
    $location_fields[]=$field('location_actions_tab','4. Liên kết cuối trang','tab');
    foreach (['overview'=>'Nút tổng quan','progress'=>'Nút tiến độ'] as $key=>$label) {
        $location_fields[]=$field('location_'.$key.'_label',$label.' — Chữ hiển thị','text',['wrapper'=>['width'=>'50']]);
        $location_fields[]=$field('location_'.$key.'_path',$label.' — Đường dẫn','text',['wrapper'=>['width'=>'50'],'instructions'=>'Dùng liên kết tương đối bắt đầu bằng /, ví dụ /tong-quan/. Không nhập tên miền.']);
    }
    $location=$group('location','48 Trần Phú — Vị trí',$location_fields,$page('vi-tri'));
    $progress=$group('progress_page','48 Trần Phú — Trang tiến độ',[
        $field('progress_title','1. Tiêu đề đầu trang (H1)'),
        $field('progress_intro','1. Giới thiệu ngay dưới H1','textarea',['rows'=>5,'instructions'=>'Dán đoạn giới thiệu trong file 01-NOI-DUNG-DANG-WEB.txt.']),
        $field('progress_updates_help','2. Các bản cập nhật','message',['message'=>'Vào menu Tiến độ → Thêm cập nhật tiến độ để nhập từng bản cập nhật. Chọn ngày trong tháng 11/2026 cho khối tháng 11/2026. Website tự hiện nhãn tháng theo ngày cập nhật và xếp mới nhất trước. Máy tính: ảnh trái, nội dung phải. Điện thoại: ảnh trên, nội dung dưới. Nút Xem chi tiết mở bài cập nhật tương ứng.']),
        $field('progress_empty','Thông báo khi chưa có cập nhật','textarea'),
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
        $field('update_title','Tiêu đề khối cập nhật (H2)','text',['instructions'=>'Để trống dùng tiêu đề bài cập nhật ở phía trên.']),
        $field('update_image','Ảnh công trình','image',['instructions'=>'Hiện bên trái trên máy tính, bên trên trên điện thoại. Danh sách ưu tiên ảnh này; video vẫn hiển thị trong trang chi tiết.']),
        $field('update_image_alt','ALT — mô tả ảnh','text',['instructions'=>'Để trống dùng ALT trong Thư viện. Ví dụ: Công trường dự án 48 Trần Phú Nha Trang tháng 11/2026.']),
        $field('update_image_caption','Chú thích ngay dưới ảnh','textarea',['rows'=>3,'instructions'=>'Dán chú thích ảnh trong file nội dung. Để trống để ẩn.']),
        $field('update_video','Video công trình (MP4 / WebM)','file',['return_format'=>'id','mime_types'=>'mp4,webm','required'=>0,'instructions'=>'Tải file hoặc nhập URL video bên dưới, chỉ cần một trong hai. Khi có cả ảnh và video, ảnh dùng làm ảnh đại diện video.']),
        $field('update_video_url','URL video công trình (YouTube / MP4 / WebM)','url',['required'=>0,'instructions'=>'Nhập link YouTube (bao gồm Shorts, youtu.be) hoặc liên kết trực tiếp đến video MP4 / WebM. Trang danh sách chỉ tải ảnh tĩnh và hiện nút “Xem video công trường” mở video trong tab mới. Nếu có cả file và URL, ưu tiên URL.']),
        $field('update_description','Mô tả ngắn','textarea',['rows'=>4]),
        $field('update_button_label','Chữ trên nút xem chi tiết'),
    ],[[['param'=>'post_type','operator'=>'==','value'=>'tp48_journal']]]);
    $contact=$group('contact_page','48 Trần Phú — Liên hệ',[
        $field('contact_heading','Tiêu đề form'),$field('contact_intro','Giới thiệu form','textarea'),
    ],$page('lien-he'));
    return [$overview,$location,$progress,$information,$update,$contact];
}
add_action('acf/init',function() {
    if (function_exists('acf_add_local_field_group')) foreach (tp48_interior_field_groups() as $group) acf_add_local_field_group($group);
});
// Use the selected progress photo as the featured image only when none exists.
add_action('acf/save_post',function($post_id) {
    if (!is_numeric($post_id) || get_post_type((int)$post_id)!=='tp48_journal' || has_post_thumbnail((int)$post_id)) return;
    $image=absint(get_post_meta((int)$post_id,'tp48_update_image',true));
    if ($image && wp_attachment_is_image($image)) set_post_thumbnail((int)$post_id,$image);
},20);
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

// Keep the location page's editable navigation on this site with relative paths.
foreach (['overview','progress'] as $destination) {
    add_filter('acf/validate_value/key=field_tp48_location_'.$destination.'_path',function($valid,$value) {
        if ($valid!==true || $value==='') return $valid;
        return preg_match('~^/(?!/)[^\\\\\s]*$~D',(string)$value) ? true:'Nhập đường dẫn tương đối bắt đầu bằng một dấu /, ví dụ /tong-quan/.';
    },10,2);
}
