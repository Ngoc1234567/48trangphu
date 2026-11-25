<?php
if (!defined('ABSPATH')) exit;

function tp48_cf7_form() {
    $id=(int)get_option('tp48_cf7_form_id');
    return $id && function_exists('wpcf7_contact_form') ? wpcf7_contact_form($id):null;
}
function tp48_is_cf7_form($form) {
    return $form && (int)$form->id()===(int)get_option('tp48_cf7_form_id');
}
function tp48_cf7_honeypot_tag() {
    return '[text tp48_hp_check tabindex:-1 autocomplete:off readonly]';
}
// Normalize only the trap in the existing saved form, including REST/schema requests.
// Do not replace the form layout or mail settings edited in WordPress Admin.
function tp48_cf7_honeypot_properties($properties,$form) {
    if (tp48_is_cf7_form($form) && isset($properties['form'])) {
        $properties['form']=preg_replace('/\[text\s+(?:website|tp48_hp_check)(?=[\s\]])[^\]]*\]/',tp48_cf7_honeypot_tag(),$properties['form']);
    }
    return $properties;
}
add_filter('wpcf7_contact_form_properties','tp48_cf7_honeypot_properties',10,2);
function tp48_cf7_honeypot_attributes($html) {
    if (!tp48_is_cf7_form(wpcf7_get_current_contact_form()) || !class_exists('WP_HTML_Tag_Processor')) return $html;
    $processor=new WP_HTML_Tag_Processor($html);
    while ($processor->next_tag('INPUT')) {
        if ($processor->get_attribute('name')!=='tp48_hp_check') continue;
        // These are hints for password managers; readonly also prevents normal Autofill.
        foreach (['autocomplete'=>'off','tabindex'=>'-1','readonly'=>true,'aria-hidden'=>'true','spellcheck'=>'false','data-lpignore'=>'true','data-1p-ignore'=>'true','data-bwignore'=>'true'] as $name=>$value) {
            $processor->set_attribute($name,$value);
        }
    }
    return $processor->get_updated_html();
}
add_filter('wpcf7_form_elements','tp48_cf7_honeypot_attributes',20);
function tp48_cf7_form_markup() {
    $privacy=esc_url(tp48_page_url('chinh-sach-bao-mat'));
    return '<div class="contact-form tp48-cf7-fields">'
        .'<label>Họ và tên *[text* full-name maxlength:100 autocomplete:name placeholder "Họ và tên"]</label>'
        .'<label class="tp48-phone-field">Số điện thoại *[tel* phone maxlength:20 autocomplete:tel placeholder "Số điện thoại"]</label>'
        .'<label class="tp48-email-field">Email (không bắt buộc)[email email maxlength:254 autocomplete:email placeholder "Email (không bắt buộc)"]</label>'
        .'<div class="full-width tp48-acceptance">[acceptance consent]Tôi đồng ý nhận liên hệ và cập nhật theo <a href="'.$privacy.'">chính sách quyền riêng tư</a>.[/acceptance]</div>'
        .'<div class="honeypot" aria-hidden="true">'.tp48_cf7_honeypot_tag().'</div>'
        .'<div class="tp48-submit">[submit class:button class:gold "Nhận cập nhật"]</div></div>';
}
// Resolve the homepage during both page rendering and CF7 REST submissions.
function tp48_cf7_home_id() {
    if (!tp48_is_cf7_form(wpcf7_get_current_contact_form())) return 0;
    if (is_front_page() || is_page_template('front-page.php')) return tp48_home_post_id();
    $submission=class_exists('WPCF7_Submission') ? WPCF7_Submission::get_instance():null;
    $id=$submission ? (int)$submission->get_meta('container_post_id'):0;
    return $id && ($id===(int)get_option('page_on_front') || get_page_template_slug($id)==='front-page.php') ? $id:0;
}
function tp48_cf7_home_text($name,$id) {
    $value=tp48_home_field('contact',$name,$id);
    return is_scalar($value) ? trim(wp_strip_all_tags((string)$value)):'';
}
add_filter('wpcf7_form_tag',function ($tag,$replace) {
    if ($replace && is_page_template('page-templates/lien-he.php') && tp48_is_cf7_form(wpcf7_get_current_contact_form()) && ($tag['basetype'] ?? '')==='submit') {
        $label='Nhận cập nhật';
        $tag['values']=[$label];$tag['labels']=[$label];$tag['raw_values']=[$label];
    }
    $id=$replace ? tp48_cf7_home_id():0;
    if (!$id) return $tag;
    $fields=['full-name'=>'name_label','phone'=>'phone_label','email'=>'email_label'];
    if (isset($fields[$tag['name'] ?? ''])) {
        $label=tp48_cf7_home_text($fields[$tag['name']],$id);
        if (in_array('placeholder',$tag['options'],true) || in_array('watermark',$tag['options'],true)) {
            $tag['values']=[$label];$tag['labels']=[$label];$tag['raw_values']=[$label];
        }
    }
    if (($tag['basetype'] ?? '')==='submit') {
        $label=tp48_cf7_home_text('button_label',$id);
        $tag['values']=[$label];$tag['labels']=[$label];$tag['raw_values']=[$label];
    }
    if (($tag['basetype'] ?? '')==='acceptance' && ($tag['name'] ?? '')==='consent') {
        $privacy=tp48_home_field('contact','privacy_link',$id);
        $tag['content']=esc_html(tp48_cf7_home_text('consent_text',$id));
        if (tp48_home_link_attributes($privacy)) {
            $tag['content'].=' <a '.tp48_home_link_attributes($privacy).'>'.esc_html($privacy['title'] ?? '').'</a>';
        }
    }
    return $tag;
},10,2);
add_filter('wpcf7_form_elements',function ($html) {
    $id=tp48_cf7_home_id();
    if (!$id) return $html;
    // Preserve CF7 controls, validation and administrator edits to the form layout.
    foreach (['full-name'=>'name_label','phone'=>'phone_label','email'=>'email_label'] as $name=>$field) {
        $label=esc_html(tp48_cf7_home_text($field,$id));
        $pattern='~(<label\\b[^>]*>)[^<]*(?=<(?:span|input)\\b[^>]*(?:data-name|name)=["\']'.preg_quote($name,'~').'["\'])~i';
        $required=$name==='email' ? ' (không bắt buộc)':' *';
        $html=preg_replace_callback($pattern,function($matches) use ($label,$required) { return $matches[1].$label.$required; },$html);
    }
    $note=tp48_cf7_home_text('note',$id);
    if ($note!=='') $html.='<p class="fine-print tp48-contact-note">'.nl2br(esc_html($note)).'</p>';
    return $html;
});
add_filter('wpcf7_display_message',function ($message,$status) {
    $id=$status==='mail_sent_ok' ? tp48_cf7_home_id():0;
    return $id ? tp48_cf7_home_text('success_message',$id):$message;
},10,2);
// Create once in admin; never overwrite subsequent edits in Contact Form 7.
add_action('admin_init',function () {
    if (!class_exists('WPCF7_ContactForm') || !current_user_can('manage_options') || tp48_cf7_form()) return;
    $form=WPCF7_ContactForm::get_template(['title'=>'48 Trần Phú — Nhận đăng ký','locale'=>'vi']);
    $markup=tp48_cf7_form_markup();
    $mail=$form->prop('mail');
    $mail['recipient']=tp48_contact_recipient();
    $mail['subject']='Yêu cầu nhận cập nhật — 48 Trần Phú';
    $mail['body']="Họ và tên: [full-name]\nSố điện thoại: [phone]\nEmail: [email]\nĐồng ý nhận liên hệ: [consent]\nTrang gửi: [_url]";
    $mail['additional_headers']='';
    $messages=$form->prop('messages');
    $messages['mail_sent_ok']='Cảm ơn bạn. Yêu cầu nhận cập nhật đã được ghi nhận.';
    $messages['mail_sent_ng']='Yêu cầu đã được ghi nhận, nhưng chưa gửi được email thông báo. Bạn không cần gửi lại.';
    $messages['validation_error']='Vui lòng kiểm tra các trường được đánh dấu.';
    $messages['accept_terms']='Vui lòng đồng ý nhận liên hệ trước khi gửi.';
    $form->set_properties(['form'=>$markup,'mail'=>$mail,'messages'=>$messages,'additional_settings'=>'acceptance_as_validation: on']);
    $id=$form->save();
    if ($id) update_option('tp48_cf7_form_id',$id);
});
function tp48_render_contact_form() {
    $form=tp48_cf7_form();
    if ($form) echo do_shortcode('[contact-form-7 id="'.(int)$form->id().'"]');
    else echo '<p class="form-status" role="status">Form đăng ký đang được chuẩn bị. Vui lòng liên hệ qua các kênh ở cuối trang.</p>';
}
add_action('admin_notices',function () {
    if (!current_user_can('manage_options')) return;
    if (!class_exists('WPCF7_ContactForm')) {
        echo '<div class="notice notice-warning"><p>48 Trần Phú: hãy kích hoạt Contact Form 7 để sử dụng form Trang chủ và Liên hệ.</p></div>';
    } elseif (tp48_cf7_form()) {
        $screen=get_current_screen();
        if ($screen && strpos($screen->id,'wpcf7')!==false) echo '<div class="notice notice-info"><p>Form 48 Trần Phú dùng chung cho Trang chủ và Liên hệ. Email nhận của thư chính luôn lấy từ Giao diện → Tùy biến → 48 Trần Phú — Liên hệ; trường To của form không thay thế thiết lập này. WP Mail SMTP quản lý tài khoản gửi.</p></div>';
    }
});
add_filter('wpcf7_mail_components',function ($components,$form,$mail) {
    if (tp48_is_cf7_form($form) && $mail->name()==='mail') {
        $components['recipient']=tp48_contact_recipient();
        $submission=WPCF7_Submission::get_instance();
        $email=$submission ? $submission->get_posted_data('email'):'';
        // Optional email must never produce an empty Reply-To header.
        $headers=preg_replace('/^Reply-To:.*(?:\r?\n|$)/mi','',(string)($components['additional_headers'] ?? ''));
        if (is_string($email) && is_email($email)) $headers=trim($headers)."\nReply-To: ".sanitize_email($email);
        $components['additional_headers']=trim($headers);
    }
    return $components;
},10,3);
add_filter('wpcf7_autop_or_not',function ($autop,$options) {
    if (($options['for'] ?? '')==='mail') return $autop;
    return tp48_is_cf7_form(wpcf7_get_current_contact_form()) ? false:$autop;
},10,2);
function tp48_cf7_rate_key() {
    return 'tp48_'.hash_hmac('sha256',($_SERVER['REMOTE_ADDR'] ?? 'local'),wp_salt());
}
function tp48_cf7_check_spam($spam,$submission) {
    if (!tp48_is_cf7_form($submission->get_contact_form())) return $spam;
    // Check the old name too: stale LiteSpeed pages and already-open tabs can still send it.
    foreach (['tp48_hp_check','website'] as $field) {
        $value=$submission->get_posted_data($field);
        if ($value!==null && $value!=='' && $value!==[]) {
            $submission->add_spam_log(['agent'=>'tp48_honeypot','reason'=>'Honeypot field is not empty.']);
            return true;
        }
    }
    if (get_transient(tp48_cf7_rate_key())) {
        $submission->add_spam_log(['agent'=>'tp48_rate_limit','reason'=>'A submission from this address was already accepted within the last 60 seconds.']);
        return true;
    }
    return $spam;
}
add_filter('wpcf7_spam','tp48_cf7_check_spam',10,2);
add_action('wpcf7_before_send_mail',function ($form,&$abort,$submission) {
    if ($abort || !tp48_is_cf7_form($form)) return;
    $value=function ($key) use ($submission) { $value=$submission->get_posted_data($key); return is_scalar($value) ? sanitize_text_field((string)$value):''; };
    $name=$value('full-name');$email=sanitize_email($value('email'));$phone=$value('phone');
    $id=wp_insert_post(['post_type'=>'tp48_inquiry','post_status'=>'private','post_title'=>$name,'post_content'=>"Họ và tên: $name\nEmail: $email\nSố điện thoại: $phone\nThời điểm: ".current_time('mysql')],true);
    if (is_wp_error($id) || !$id) {
        $abort=true;
        $submission->set_response('Chưa thể lưu yêu cầu. Vui lòng thử lại.');
        return;
    }
    $GLOBALS['tp48_cf7_inquiry_id']=$id;
    update_post_meta($id,'_tp48_email',$email);
    if ($submission->get_posted_data('consent')) {
        update_post_meta($id,'_tp48_consent_at',gmdate('c'));
        update_post_meta($id,'_tp48_consent_version','cf7-v1');
    }
    update_post_meta($id,'_tp48_mail_recipient',tp48_contact_recipient());
    set_transient(tp48_cf7_rate_key(),1,MINUTE_IN_SECONDS);
},10,3);
foreach (['wpcf7_mail_sent'=>'1','wpcf7_mail_failed'=>'0'] as $hook=>$status) {
    add_action($hook,function ($form) use ($status) {
        if (tp48_is_cf7_form($form) && !empty($GLOBALS['tp48_cf7_inquiry_id'])) update_post_meta($GLOBALS['tp48_cf7_inquiry_id'],'_tp48_mail_sent',$status);
    });
}
