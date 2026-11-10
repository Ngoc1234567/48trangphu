<?php
if (!defined('ABSPATH')) exit;
function tp48_post_value($key) { return isset($_POST[$key]) && is_string($_POST[$key]) ? wp_unslash($_POST[$key]) : ''; }
function tp48_contact_recipient() {
    $email=trim((string)tp48_text('email'));
    return is_email($email) ? $email:sanitize_email(get_option('admin_email'));
}
function tp48_contact() {
    $back=wp_validate_redirect(esc_url_raw(tp48_post_value('return_url')),tp48_page_url('lien-he'));
    $finish=function ($state) use ($back) { wp_safe_redirect(add_query_arg('contact',$state,$back).'#kham-pha',303); exit; };
    if (($_SERVER['REQUEST_METHOD'] ?? '')!=='POST') $finish('invalid');
    if (!wp_verify_nonce(tp48_post_value('tp48_nonce'),'tp48_contact')) $finish('expired');
    if (tp48_post_value('website')) $finish('error');
    $home_id=absint(tp48_post_value('tp48_home_page'));
    if ($home_id && (!(get_post_status($home_id)==='publish' && ($home_id===(int)get_option('page_on_front') || get_page_template_slug($home_id)==='front-page.php')) || !wp_verify_nonce(tp48_post_value('tp48_home_nonce'),'tp48_home_contact_'.$home_id))) $finish('expired');
    $name=sanitize_text_field(tp48_post_value('full_name'));
    $email=sanitize_email(tp48_post_value('email'));
    $phone=sanitize_text_field(tp48_post_value('phone'));
    if (!$name || mb_strlen($name)>100 || !is_email($email) || strlen($email)>254 || ($phone && !preg_match('/^[+0-9 ().-]{8,20}$/',$phone))) $finish('invalid');
    $consented=tp48_post_value('consent')==='1';
    if (!$home_id && !$consented) $finish('consent');
    $consent_note=$consented ? 'Đồng ý nhận liên hệ và cập nhật: Có' : 'Khách gửi yêu cầu nhận thông tin qua form trang chủ; không thu thập xác nhận đồng ý nhận cập nhật.';
    $rate_key='tp48_'.hash_hmac('sha256',($_SERVER['REMOTE_ADDR'] ?? 'local'),wp_salt());
    if (get_transient($rate_key)) $finish('wait');
    $id=wp_insert_post(['post_type'=>'tp48_inquiry','post_status'=>'private','post_title'=>$name,'post_content'=>"Họ và tên: $name\nEmail: $email\nSố điện thoại: $phone\n$consent_note\nThời điểm: ".current_time('mysql')],true);
    if (is_wp_error($id) || !$id) $finish('error');
    update_post_meta($id,'_tp48_email',$email);
    if ($consented) {
        update_post_meta($id,'_tp48_consent_at',gmdate('c'));
        update_post_meta($id,'_tp48_consent_version','2026-11-03');
    }
    set_transient($rate_key,1,MINUTE_IN_SECONDS);
    $recipient=tp48_contact_recipient();
    $sent=wp_mail($recipient,'Yêu cầu nhận cập nhật — 48 Trần Phú',"Họ và tên: $name\nEmail: $email\nSố điện thoại: $phone\n$consent_note\nXem yêu cầu: ".admin_url('post.php?post='.$id.'&action=edit'));
    update_post_meta($id,'_tp48_mail_sent',$sent ? '1':'0');
    $finish($sent ? 'success':'saved');
}
add_action('admin_post_tp48_contact','tp48_contact');
add_action('admin_post_nopriv_tp48_contact','tp48_contact');
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
