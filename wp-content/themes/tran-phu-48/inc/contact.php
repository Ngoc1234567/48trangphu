<?php
if (!defined('ABSPATH')) exit;
function tp48_contact_recipient() {
    $email=trim((string)tp48_text('email'));
    return is_email($email) ? $email:sanitize_email(get_option('admin_email'));
}
add_filter('wp_privacy_personal_data_exporters',function ($exporters) {
 $exporters['tp48-inquiries']=['exporter_friendly_name'=>'Yêu cầu nhận cập nhật 48 Trần Phú','callback'=>function ($email,$page=1) {
    $posts=get_posts(['post_type'=>'tp48_inquiry','post_status'=>'private','posts_per_page'=>50,'paged'=>$page,'meta_key'=>'_tp48_email','meta_value'=>$email,'orderby'=>'ID','order'=>'ASC']);
    $data=[];
    foreach ($posts as $post) $data[]=['group_id'=>'tp48-inquiries','group_label'=>'Yêu cầu nhận cập nhật','item_id'=>'tp48-'.$post->ID,'data'=>[['name'=>'Yêu cầu','value'=>$post->post_content],['name'=>'Đồng ý lúc','value'=>get_post_meta($post->ID,'_tp48_consent_at',true)]]];
    return ['data'=>$data,'done'=>count($posts)<50];
 }]; return $exporters;
});
add_filter('wp_privacy_personal_data_erasers',function ($erasers) {
 $erasers['tp48-inquiries']=['eraser_friendly_name'=>'Yêu cầu nhận cập nhật 48 Trần Phú','callback'=>function ($email,$page=1) {
    $posts=get_posts(['post_type'=>'tp48_inquiry','post_status'=>['private','trash'],'posts_per_page'=>50,'meta_key'=>'_tp48_email','meta_value'=>$email]);
    $removed=false;$retained=false;
    foreach ($posts as $post) { if (wp_delete_post($post->ID,true)) $removed=true; else $retained=true; }
    return ['items_removed'=>$removed,'items_retained'=>$retained,'messages'=>[],'done'=>count($posts)<50];
 }]; return $erasers;
});
