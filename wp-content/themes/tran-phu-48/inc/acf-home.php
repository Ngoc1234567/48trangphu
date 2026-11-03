<?php
/** ACF-backed homepage data. All defaults preserve the classic homepage. */
if (!defined('ABSPATH')) exit;
function tp48_home_defaults() {
    static $defaults=null;
    if ($defaults!==null) return $defaults;
    $defaults=[
        'brand'=>['logo'=>0,'number'=>'48','name'=>'TRẦN PHÚ','city'=>'NHA TRANG','show_menu'=>1,'menu'=>0],
        'hero'=>['enabled'=>1,'order'=>10,'image'=>tp48_image('hero'),'mobile_image'=>0,'alt'=>'Tháp Trầm Hương bên bờ biển Nha Trang khi thành phố lên đèn','video'=>0,'number'=>'48','name'=>'TRẦN PHÚ','city'=>'NHA TRANG','headline'=>tp48_text('classic_headline','Dấu ấn mới bên vịnh biển'),'subtitle'=>tp48_text('classic_subtitle','A New Landmark on Nha Trang Bay'),'button'=>['url'=>'#vi-tri','title'=>'Discover more','target'=>'']],
        'pillars'=>['enabled'=>1,'order'=>20,
            'item_1'=>['enabled'=>1,'title'=>'Vị trí đắc địa','icon'=>'pin','image'=>0,'link'=>['url'=>'#vi-tri','title'=>'','target'=>'']],
            'item_2'=>['enabled'=>1,'title'=>'Bên vịnh biển','icon'=>'waves','image'=>0,'link'=>['url'=>'#dau-an','title'=>'','target'=>'']],
            'item_3'=>['enabled'=>1,'title'=>'Dấu ấn đô thị','icon'=>'star','image'=>0,'link'=>['url'=>'#dau-an','title'=>'','target'=>'']],
            'item_4'=>['enabled'=>1,'title'=>'Giá trị bền vững','icon'=>'diamond','image'=>0,'link'=>['url'=>'#kham-pha','title'=>'','target'=>'']],
        ],
        'location'=>['enabled'=>1,'order'=>30,'image'=>tp48_image('location'),'alt'=>'Toàn cảnh đường Trần Phú và đường cong vịnh Nha Trang','eyebrow'=>'Vị trí','title'=>'48 Trần Phú','description'=>tp48_text('location','Địa điểm dự án: 48 Trần Phú, Nha Trang. Thông tin chi tiết sẽ được cập nhật khi có xác nhận.'),'button'=>['url'=>'https://www.google.com/maps/search/?api=1&query=48+Tran+Phu+Nha+Trang','title'=>'Khám phá vị trí','target'=>'_blank']],
        'identity'=>['enabled'=>1,'order'=>40,'image'=>tp48_image('sunrise'),'alt'=>'Ánh bình minh trên vịnh biển Nha Trang','title'=>"Dấu ấn\nNha Trang",'description'=>tp48_text('identity','Thành phố của biển, ánh sáng và những giá trị sống đặc trưng.')],
        'gallery'=>['enabled'=>1,'order'=>50,'title'=>'Hình ảnh','description'=>"Những khoảnh khắc tiêu biểu\nvề vị trí, cảnh quan và phố biển\nNha Trang.",'button_label'=>'Xem hình ảnh','images'=>[['url'=>tp48_image('location'),'alt'=>'Đường bờ biển Nha Trang','caption'=>'Đường bờ biển Nha Trang'],['url'=>tp48_image('hero'),'alt'=>'Tháp Trầm Hương về đêm','caption'=>'Tháp Trầm Hương về đêm'],['url'=>tp48_image('sunrise'),'alt'=>'Bình minh trên vịnh biển','caption'=>'Bình minh trên vịnh biển']],'empty_message'=>'Hình ảnh sẽ được cập nhật.'],
        'journal'=>['enabled'=>1,'order'=>60,'image'=>tp48_image('journal'),'alt'=>'Ảnh minh họa hoạt động xây dựng, không phải ảnh tiến độ thực tế của dự án','image_note'=>'Ảnh minh họa hoạt động xây dựng','title'=>"Nhật ký\ncông trình",'description'=>"Cập nhật tiến độ thi công, hình ảnh thực tế\nvà những dấu mốc quan trọng của dự án.",'button_label'=>'Theo dõi nhật ký','mode'=>'toggle','button'=>['url'=>tp48_page_url('tien-do'),'title'=>'Theo dõi nhật ký','target'=>''],'posts'=>[],'limit'=>6,'show_date'=>1,'show_excerpt'=>1,'empty_message'=>'Nhật ký công trình sẽ được cập nhật tại đây khi có thông tin chính thức.'],
        'contact'=>['enabled'=>1,'order'=>70,'title'=>"Khám phá thêm\nvề 48 Trần Phú",'name_label'=>'Họ và tên','phone_label'=>'Số điện thoại','email_label'=>'Email','show_phone'=>1,'phone_required'=>0,'button_label'=>'Discover more','consent_text'=>'Tôi đồng ý nhận liên hệ/cập nhật theo','privacy_link'=>['url'=>tp48_page_url('chinh-sach-bao-mat'),'title'=>'chính sách quyền riêng tư','target'=>''],'note'=>'Thông tin được sử dụng để phản hồi yêu cầu tìm hiểu của bạn.','success_message'=>'Cảm ơn bạn. Thông tin của bạn đã được ghi nhận.','recipient'=>''],
    ];
    return $defaults;
}
function tp48_home_post_id() {
    if (is_singular('page') && (is_front_page() || is_page_template('front-page.php'))) return (int)get_queried_object_id();
    return (int)get_option('page_on_front');
}
function tp48_home_field($section,$name,$post_id=0) {
    $defaults=tp48_home_defaults(); $id=$post_id ? absint($post_id):tp48_home_post_id();
    if ($id && function_exists('get_field') && did_action('acf/init') && metadata_exists('post',$id,'tp48_home_'.$section.'_'.$name)) {
        $group=get_field('tp48_home_'.$section,$id);
        if (is_array($group) && array_key_exists($name,$group)) return $group[$name];
    }
    return $defaults[$section][$name] ?? null;
}
function tp48_home_text($section,$name,$breaks=false) {
    $value=tp48_home_field($section,$name);
    $text=is_scalar($value) ? esc_html((string)$value) : '';
    return $breaks ? nl2br($text,false) : $text;
}
function tp48_home_sections() {
    $sections=['hero','pillars','location','identity','gallery','journal','contact'];
    $sections=array_filter($sections,function($section) { return (bool)tp48_home_field($section,'enabled'); });
    $positions=array_flip(['hero','pillars','location','identity','gallery','journal','contact']);
    usort($sections,function($a,$b) use ($positions) { $result=(int)tp48_home_field($a,'order')<=>(int)tp48_home_field($b,'order'); return $result ?: $positions[$a]<=>$positions[$b]; });
    return $sections;
}
function tp48_home_image_data($value,$alt='') {
    if (is_numeric($value) && (int)$value>0) {
        $id=(int)$value;$url=wp_get_attachment_image_url($id,'full');
        if (!$url) return [];
        $media_alt=get_post_meta($id,'_wp_attachment_image_alt',true);
        return ['id'=>$id,'url'=>$url,'alt'=>$alt ?: ($media_alt ?: get_the_title($id)),'caption'=>wp_get_attachment_caption($id) ?: ($media_alt ?: get_the_title($id))];
    }
    if (is_array($value)) {
        if (!empty($value['ID'])) return tp48_home_image_data($value['ID'],$alt ?: ($value['alt'] ?? ''));
        if (!empty($value['url'])) return ['id'=>0,'url'=>$value['url'],'alt'=>$alt ?: ($value['alt'] ?? ''),'caption'=>$value['caption'] ?? ($value['alt'] ?? '')];
    }
    return is_string($value) && $value ? ['id'=>0,'url'=>$value,'alt'=>$alt,'caption'=>$alt] : [];
}
function tp48_home_image_html($value,$alt='',$class='',$priority=false) {
    $data=tp48_home_image_data($value,$alt);
    if (!$data) return '';
    $attributes=['class'=>$class,'alt'=>$data['alt'],'loading'=>$priority ? 'eager':'lazy'];
    if ($priority) $attributes['fetchpriority']='high';
    if ($data['id']) return wp_get_attachment_image($data['id'],'full',false,$attributes);
    return '<img src="'.esc_url($data['url']).'" alt="'.esc_attr($data['alt']).'" class="'.esc_attr($class).'" loading="'.($priority ? 'eager':'lazy').'"'.($priority ? ' fetchpriority="high"':'').'>';
}
function tp48_home_link_attributes($link) {
    if (!is_array($link) || empty($link['url'])) return '';
    return 'href="'.esc_url($link['url']).'"'.(($link['target'] ?? '')==='_blank' ? ' target="_blank" rel="noopener noreferrer"':'');
}
function tp48_home_gallery() {
    $images=tp48_home_field('gallery','images');$result=[];
    foreach (is_array($images) ? $images:[] as $value) { $data=tp48_home_image_data($value); if ($data) $result[]=$data; }
    return $result;
}
add_filter('acf/load_field/key=field_tp48_home_brand_menu',function($field) {
    $field['choices']=[];
    foreach (wp_get_nav_menus() as $menu) $field['choices'][$menu->term_id]=$menu->name;
    return $field;
});
add_filter('acf/fields/relationship/query/key=field_tp48_home_gallery_images',function($args) {
    $args['post_type']=['attachment'];$args['post_status']=['inherit'];$args['post_mime_type']='image';return $args;
});
add_filter('acf/fields/relationship/result/key=field_tp48_home_gallery_images',function($title,$post) {
    return wp_get_attachment_image($post->ID,'thumbnail',false,['style'=>'width:40px;height:30px;object-fit:cover;vertical-align:middle;margin-right:8px;']).esc_html(get_the_title($post));
},10,2);
add_action('admin_notices',function() {
    if (current_user_can('activate_plugins') && !function_exists('get_field')) echo '<div class="notice notice-warning"><p>48 Trần Phú: kích hoạt Advanced Custom Fields để chỉnh các field Trang chủ. Website vẫn hiển thị bằng dữ liệu dự phòng.</p></div>';
});

add_filter('body_class',function($classes) {
    if (is_front_page() || is_page_template('front-page.php')) {
        $sections=tp48_home_sections();
        if (!$sections || reset($sections)!=='hero') $classes[]='tp48-home-without-leading-hero';
    }
    return $classes;
});
