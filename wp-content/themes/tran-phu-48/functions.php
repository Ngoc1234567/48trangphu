<?php
/** Theme setup and editable homepage. */
if (!defined('ABSPATH')) { exit; }

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
});
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('tp48', get_stylesheet_uri(), [], '1.0.0');
    wp_enqueue_script('tp48', get_template_directory_uri() . '/assets/site.js', [], '1.0.0', true);
});

function tp48_image($key) {
    $defaults = ['hero' => 'hero.jpg', 'location' => 'coast.jpg', 'sunrise' => 'sunrise.jpg', 'journal' => 'construction.jpg'];
    return get_theme_mod('tp48_image_' . $key, get_template_directory_uri() . '/assets/images/' . $defaults[$key]);
}
function tp48_text($key, $default) { return get_theme_mod('tp48_' . $key, $default); }

add_action('customize_register', function ($customizer) {
    $customizer->add_section('tp48_home', ['title' => '48 Trần Phú — Trang chủ', 'priority' => 30]);
    foreach (['hero' => 'Ảnh nền đầu trang', 'location' => 'Ảnh vị trí', 'sunrise' => 'Ảnh dấu ấn Nha Trang', 'journal' => 'Ảnh nhật ký công trình'] as $key => $label) {
        $customizer->add_setting('tp48_image_' . $key, ['default' => tp48_image($key), 'sanitize_callback' => 'esc_url_raw']);
        $customizer->add_control(new WP_Customize_Image_Control($customizer, 'tp48_image_' . $key, ['label' => $label, 'section' => 'tp48_home']));
    }
    foreach ([
        'headline' => ['Tiêu đề chính', 'Dấu ấn mới bên vịnh biển'],
        'subtitle' => ['Phụ đề', 'A New Landmark on Nha Trang Bay'],
        'location' => ['Mô tả vị trí', 'Tọa lạc trên tuyến đường ven biển Trần Phú, bên cạnh Quảng trường 2/4 và Tháp Trầm Hương – trái tim của thành phố Nha Trang.'],
        'identity' => ['Mô tả dấu ấn', 'Thành phố của biển, ánh sáng và những giá trị sống đặc trưng.'],
    ] as $key => $field) {
        $customizer->add_setting('tp48_' . $key, ['default' => $field[1], 'sanitize_callback' => 'sanitize_textarea_field']);
        $customizer->add_control('tp48_' . $key, ['label' => $field[0], 'section' => 'tp48_home', 'type' => 'textarea']);
    }
});

add_action('init', function () {
    register_post_type('tp48_journal', ['labels' => ['name' => 'Nhật ký công trình', 'singular_name' => 'Bài nhật ký', 'add_new_item' => 'Thêm bài nhật ký'], 'public' => true, 'menu_icon' => 'dashicons-building', 'supports' => ['title', 'editor', 'thumbnail', 'excerpt'], 'show_in_rest' => true, 'rewrite' => ['slug' => 'nhat-ky']]);
    register_post_type('tp48_inquiry', ['labels' => ['name' => 'Liên hệ từ website', 'singular_name' => 'Liên hệ'], 'public' => false, 'show_ui' => true, 'menu_icon' => 'dashicons-email-alt', 'supports' => ['title', 'editor'], 'capabilities' => ['create_posts' => 'do_not_allow'], 'map_meta_cap' => true]);
});
add_action('after_switch_theme', function () { update_option('tp48_flush_rewrite', 1); });
add_action('init', function () { if (get_option('tp48_flush_rewrite')) { flush_rewrite_rules(); delete_option('tp48_flush_rewrite'); } }, 20);

function tp48_contact() {
    $back = home_url('/');
    $finish = function ($state) use ($back) { wp_safe_redirect(add_query_arg('contact', $state, $back) . '#kham-pha'); exit; };
    if (!isset($_POST['tp48_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['tp48_nonce'])), 'tp48_contact')) { $finish('expired'); }
    if (!empty($_POST['website'])) { $finish('error'); }
    $name = sanitize_text_field(wp_unslash($_POST['full_name'] ?? ''));
    $phone = sanitize_text_field(wp_unslash($_POST['phone'] ?? ''));
    $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    if (!$name || strlen($name) > 180 || !preg_match('/^[+0-9 ().-]{8,20}$/', $phone) || !is_email($email)) { $finish('invalid'); }
    $rate_key = 'tp48_' . hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? '') . wp_salt());
    if (get_transient($rate_key)) { $finish('wait'); }
    $id = wp_insert_post(['post_type' => 'tp48_inquiry', 'post_status' => 'private', 'post_title' => $name, 'post_content' => "Họ và tên: $name\nSố điện thoại: $phone\nEmail: $email"], true);
    if (is_wp_error($id) || !$id) { $finish('error'); }
    set_transient($rate_key, 1, MINUTE_IN_SECONDS);
    wp_mail(get_option('admin_email'), 'Liên hệ mới — 48 Trần Phú', "Họ và tên: $name\nSố điện thoại: $phone\nEmail: $email\n\nXem trong quản trị: " . admin_url('post.php?post=' . $id . '&action=edit'));
    $finish('success');
}
add_action('admin_post_tp48_contact', 'tp48_contact');
add_action('admin_post_nopriv_tp48_contact', 'tp48_contact');

function tp48_icon($name) {
    $paths = [
        'pin' => '<path d="M24 43S9 28 9 18a15 15 0 1 1 30 0c0 10-15 25-15 25Z"/><circle cx="24" cy="18" r="6"/>',
        'waves' => '<path d="M3 12q5-7 10 0t10 0t10 0t12 0M3 24q5-7 10 0t10 0t10 0t12 0M3 36q5-7 10 0t10 0t10 0t12 0"/>',
        'star' => '<path d="m24 2 5 12 13-5-5 13 10 5-13 5 4 13-14-8-11 8 2-14L2 25l13-5-4-12 12 6Z"/><path d="m24 15 3 7 8 2-7 4-4 8-3-8-8-4 8-2Z"/>',
        'diamond' => '<path d="m3 15 9-10h24l9 10-21 29Z M3 15h42M12 5l5 10 7-10 7 10 5-10M17 15l7 29 7-29"/>',
    ];
    return '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($paths[$name] ?? '') . '</svg>';
}
