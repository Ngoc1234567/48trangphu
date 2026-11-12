<?php
/** Apply the owner's 12 November review once; keep all subsequent admin edits. */
if (!defined('ABSPATH')) exit;
function tp48_apply_review_updates() {
    $key='tp48_review_20261112';
    $done=(array)get_option($key,[]);
    if (!empty($done['contacts']) && !empty($done['home']) && !empty($done['privacy']) && !empty($done['form'])) return;
    if (empty($done['contacts'])) {
        add_option($key.'_contact_backup',['phone'=>get_theme_mod('tp48_phone')],'',false);
        set_theme_mod('tp48_phone','0906126393');
        $done['contacts']=true;
    }
    $home=(int)get_option('page_on_front');
    if (empty($done['home']) && $home && function_exists('acf_get_field')) {
        $updates=[
            'identity'=>['title'=>'48 Trần Phú · Giữa lòng phố biển'],
            'gallery'=>['title'=>'48 Trần Phú qua hình ảnh'],
            'journal'=>['title'=>'Tiến độ công trình','button_label'=>'Xem tiến độ','mode'=>'page','button'=>['url'=>tp48_page_url('tien-do'),'title'=>'Xem tiến độ','target'=>'']],
            'location'=>['button'=>['url'=>tp48_page_url('vi-tri'),'title'=>'Khám phá vị trí','target'=>'']],
        ];
        $backup=[];
        foreach ($updates as $section=>$fields) foreach ($fields as $name=>$value) {
            $meta='tp48_home_'.$section.'_'.$name;
            $backup[$meta]=get_post_meta($home,$meta,true);
            update_post_meta($home,$meta,$value);
            update_post_meta($home,'_'.$meta,'field_'.$meta);
            acf_flush_value_cache($home,'tp48_home_'.$section);
            acf_flush_value_cache($home,$meta);
        }
        add_option($key.'_home_backup',$backup,'',false);
        $done['home']=true;
    }
    $privacy=get_page_by_path('chinh-sach-bao-mat');
    if (empty($done['privacy']) && $privacy) {
        $old=$privacy->post_content;
        $new=str_replace([
            'Form thu thập họ tên và email; số điện thoại là thông tin không bắt buộc.',
            'hongngocars197@gmail.com','0965625719','Bản local chưa bật Google Analytics. ',
            'email quản trị khi hệ thống gửi mail đã được cấu hình',
        ],[
            'Form thu thập họ tên và số điện thoại (bắt buộc); email là thông tin không bắt buộc. Bạn vẫn có thể gửi yêu cầu khi không nhập email.',
            'tranduyhung.man@gmail.com','0906126393','',
            'email nhận đăng ký đã cấu hình trong website khi hệ thống gửi mail hoạt động',
        ],$old);
        add_option($key.'_privacy_backup',$old,'',false);
        $result=$new===$old ? $privacy->ID:wp_update_post(['ID'=>$privacy->ID,'post_content'=>wp_slash($new)],true);
        if ($result && !is_wp_error($result)) $done['privacy']=true;
    }
    $form=tp48_cf7_form();
    if (empty($done['form']) && $form) {
        add_option($key.'_form_backup',$form->get_properties(),'',false);
        $mail=$form->prop('mail');
        $mail['recipient']=tp48_contact_recipient();
        $mail['additional_headers']=preg_replace('/^Reply-To:.*(?:\r?\n|$)/mi','',(string)$mail['additional_headers']);
        $form->set_properties(['form'=>tp48_cf7_form_markup(),'mail'=>$mail]);
        if ($form->save()) $done['form']=true;
    }
    if ($done!==get_option($key)) update_option($key,$done,false);
}
add_action('init','tp48_apply_review_updates',30);
