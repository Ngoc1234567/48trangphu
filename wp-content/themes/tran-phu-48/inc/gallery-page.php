<?php
if (!defined('ABSPATH')) exit;

function tp48_gallery_defaults() {
    return [
        'title'=>'Hình ảnh 48 Trần Phú Nha Trang',
        'intro'=>'Những góc nhìn về 48 Trần Phú, Quảng trường 2/4 và dải bờ biển trung tâm Nha Trang. Thư viện gồm ảnh tư liệu khu vực và hình mô phỏng ý tưởng.',
        'heading'=>'Ảnh thực tế và tư liệu',
        'ready'=>0,
        'seo_title'=>'Hình ảnh 48 Trần Phú Nha Trang | Ảnh khu vực và mô phỏng',
        'seo_description'=>'Xem hình ảnh 48 Trần Phú Nha Trang qua các góc nhìn về khu đất, Quảng trường 2/4, bờ biển trung tâm và hình mô phỏng ý tưởng.',
        '1_alt'=>'Hình mô phỏng 48 Trần Phú nhìn từ biển lúc hoàng hôn.',
        '1_caption'=>'Mô phỏng ý tưởng — không phải phối cảnh chính thức.',
        '2_alt'=>'Khu đất 48 Trần Phú bên đường ven biển nhìn từ trên cao.',
        '2_caption'=>'Ảnh tư liệu khu đất 48 Trần Phú trước khi thi công.',
        '3_alt'=>'Đường cong bờ biển Nha Trang và khu đất 48 Trần Phú nhìn từ trên cao.',
        '3_caption'=>'Dọc bờ biển Nha Trang, nhìn từ khu vực Quảng trường 2/4.',
        '4_alt'=>'Góc giao Trần Phú và Nguyễn Thị Minh Khai nhìn từ trên cao.',
        '4_caption'=>'Góc giao Trần Phú – Nguyễn Thị Minh Khai nhìn từ trên cao.',
        'location_label'=>'Khám phá vị trí',
        'progress_label'=>'Theo dõi tiến độ',
    ];
}
function tp48_gallery_field($name,$id=0) {
    $id=$id ?: get_queried_object_id();
    $key='tp48_gallery_'.$name;
    return function_exists('get_field') && metadata_exists('post',$id,$key) ? get_field($key,$id) : (tp48_gallery_defaults()[$name] ?? '');
}
function tp48_gallery_ready() {
    $page=get_page_by_path('hinh-anh');
    return $page && $page->post_status==='publish' && get_page_template_slug($page->ID)==='page-templates/hinh-anh.php' && tp48_gallery_field('ready',$page->ID);
}
add_action('acf/init',function() {
    if (!function_exists('acf_add_local_field_group')) return;
    $defaults=tp48_gallery_defaults();
    $fields=[];
    $add=function($name,$label,$type='text',$extra=[]) use (&$fields,$defaults) {
        $fields[]=array_merge(['key'=>'field_tp48_gallery_'.$name,'name'=>'tp48_gallery_'.$name,'label'=>$label,'type'=>$type,'default_value'=>$defaults[$name] ?? ''],$extra);
    };
    $add('opening','1. Nội dung đầu trang','tab');
    $add('title','Tiêu đề trang (H1)');
    $add('intro','Đoạn giới thiệu','textarea',['rows'=>3]);
    $add('heading','Đề mục ảnh tư liệu');
    foreach (['01-mo-phong-hoang-hon.webp','02-khu-dat-ven-bien.webp','03-doc-bo-bien-nha-trang.webp','04-goc-giao-hai-duong.webp'] as $i=>$file) {
        $n=$i+1;
        $add($n.'_tab','Ảnh 0'.$n,'tab');
        $add($n.'_image','Ảnh 0'.$n,'image',['return_format'=>'id','preview_size'=>'medium','library'=>'all','instructions'=>'Chọn tệp '.$file.'. '.($n===1 ? 'Hiển thị rộng toàn khung, giữ tỷ lệ gốc.':'Ảnh thu nhỏ tỷ lệ 4:3; bấm để xem ảnh đầy đủ.')]);
        $add($n.'_alt','ALT — mô tả ảnh');
        $add($n.'_caption','Chú thích dưới ảnh và trong cửa sổ xem ảnh','textarea',['rows'=>2]);
    }
    $add('settings','Liên kết và SEO','tab');
    $add('location_label','Chữ nút dẫn đến /vi-tri/');
    $add('progress_label','Chữ nút dẫn đến /tien-do/');
    $add('seo_title','SEO title');
    $add('seo_description','Meta description','textarea',['rows'=>3]);
    $add('ready','Trang đã sẵn sàng','true_false',['ui'=>1,'instructions'=>'Bật sau khi nhập đủ ảnh và kiểm tra trang. Liên kết Hình ảnh và Xem hình ảnh trên Trang chủ sẽ dẫn đến trang này; trang được phép lập chỉ mục trong môi trường production.']);
    acf_add_local_field_group(['key'=>'group_tp48_gallery_page','title'=>'48 Trần Phú — Hình ảnh','fields'=>$fields,'location'=>[[['param'=>'page_template','operator'=>'==','value'=>'page-templates/hinh-anh.php']]],'active'=>true]);
});
