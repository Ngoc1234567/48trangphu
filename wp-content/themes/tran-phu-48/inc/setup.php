<?php
if (!defined('ABSPATH')) exit;
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_editor_style('assets/editor.css');
    add_theme_support('html5', ['search-form','gallery','caption','style','script','navigation-widgets']);
    register_nav_menus(['primary'=>'Menu chính', 'footer'=>'Menu chân trang']);
});
add_action('wp_enqueue_scripts', function () {
    $classic=is_front_page() || is_page_template('front-page.php');
    $css=$classic ? '/assets/home-classic.css' : '/style.css';
    wp_enqueue_style('tp48', get_template_directory_uri().$css, [], filemtime(get_template_directory().$css));
    wp_enqueue_style('tp48-footer', get_template_directory_uri().'/assets/footer.css', ['tp48'], filemtime(get_template_directory().'/assets/footer.css'));
    if (!$classic) wp_enqueue_style('tp48-interior', get_template_directory_uri().'/assets/interior-pages.css', ['tp48'], filemtime(get_template_directory().'/assets/interior-pages.css'));
    wp_enqueue_style('tp48-contact', get_template_directory_uri().'/assets/contact.css', ['tp48'], filemtime(get_template_directory().'/assets/contact.css'));
    wp_enqueue_script('tp48', get_template_directory_uri().'/assets/site.js', [], filemtime(get_template_directory().'/assets/site.js'), true);
});
function tp48_text($key, $default = '') { return get_theme_mod('tp48_'.$key, $default); }
function tp48_image($key) {
    $defaults=['hero'=>'hero','location'=>'coast','sunrise'=>'sunrise','journal'=>'construction'];
    $name=$defaults[$key] ?? 'hero';
    $file=file_exists(get_template_directory().'/assets/images/'.$name.'.webp') ? $name.'.webp' : $name.'.jpg';
    return get_theme_mod('tp48_image_'.$key, get_template_directory_uri().'/assets/images/'.$file);
}
function tp48_page_url($slug) {
    $page=get_page_by_path($slug);
    return ($page && $page->post_status==='publish') ? get_permalink($page) : home_url('/'.$slug.'/');
}
function tp48_navigation() {
    echo '<ul class="nav-list">';
    foreach ([''=>'Trang chủ','tong-quan'=>'Tổng quan','vi-tri'=>'Vị trí','mat-bang'=>'Mặt bằng','tien-ich'=>'Tiện ích','tien-do'=>'Tiến độ','the-journal'=>'The Journal','lien-he'=>'Liên hệ'] as $slug=>$title) {
        $current=$slug ? is_page($slug) : is_front_page();
        echo '<li><a href="'.esc_url($slug ? tp48_page_url($slug) : home_url('/')).'"'.($current ? ' aria-current="page"':'').'>'.esc_html($title).'</a></li>';
    }
    echo '</ul>';
}
function tp48_placeholder($message = 'Chưa có thông tin chính thức – sẽ cập nhật') {
    echo '<div class="empty-state"><span class="status-mark" aria-hidden="true"></span><p>'.esc_html($message).'</p></div>';
}
function tp48_page_summary($slug, $fallback='Chưa có thông tin chính thức – sẽ cập nhật') {
    $page=get_page_by_path($slug);
    return ($page && trim($page->post_content)) ? wp_trim_words(wp_strip_all_tags(strip_shortcodes($page->post_content)), 38) : $fallback;
}
function tp48_page_content() {
    while (have_posts()) { the_post();
        if (trim(get_the_content())) { echo '<div class="entry-content page-body">'; the_content(); wp_link_pages(); echo '</div>'; }
        else { tp48_placeholder(); }
    }
}
function tp48_phone() { return preg_replace('/[^+0-9]/','',tp48_text('phone')); }
function tp48_messenger() { return esc_url_raw(tp48_text('messenger'),['https','http']); }
function tp48_zalo() {
    $url=esc_url_raw(tp48_text('zalo'),['https','http']);
    if ($url) return $url;
    $phone=ltrim(tp48_phone(),'+');
    return $phone ? 'https://zalo.me/'.preg_replace('/^0/','84',$phone) : '';
}
function tp48_cards($type='post', $limit=3, $pagination=false) {
    $query=new WP_Query(['post_type'=>$type,'post_status'=>'publish','posts_per_page'=>$limit,'paged'=>$pagination ? max(1,get_query_var('paged'),get_query_var('page')):1,'ignore_sticky_posts'=>true]);
    if (!$query->have_posts()) { tp48_placeholder($type==='post' ? 'The Journal đang được biên tập. Bài viết sẽ hiển thị tại đây sau khi được công bố.' : 'Chưa có thông tin tiến độ chính thức – sẽ cập nhật'); return; }
    echo '<div class="story-grid'.($type==='tp48_journal' ? ' progress-grid':'').'">';
    while ($query->have_posts()) { $query->the_post(); get_template_part('template-parts/story-card',null,['progress'=>$type==='tp48_journal']); }
    echo '</div>';
    if ($pagination) { echo '<nav class="pagination" aria-label="Phân trang">'.wp_kses_post(paginate_links(['total'=>$query->max_num_pages,'current'=>max(1,get_query_var('paged'),get_query_var('page'))])).'</nav>'; }
    wp_reset_postdata();
}
add_action('init',function () {
    register_post_type('tp48_journal', ['labels'=>['name'=>'Tiến độ','singular_name'=>'Bản cập nhật tiến độ','add_new_item'=>'Thêm cập nhật tiến độ','edit_item'=>'Sửa cập nhật tiến độ'], 'public'=>true,'menu_icon'=>'dashicons-building','supports'=>['title','editor','thumbnail','excerpt','revisions'],'show_in_rest'=>true,'rewrite'=>['slug'=>'tien-do','with_front'=>false]]);
    register_post_type('tp48_inquiry', ['labels'=>['name'=>'Yêu cầu nhận cập nhật','singular_name'=>'Yêu cầu liên hệ'], 'public'=>false,'show_ui'=>true,'menu_icon'=>'dashicons-email-alt','supports'=>['title','editor'],'capabilities'=>['create_posts'=>'do_not_allow'],'map_meta_cap'=>true]);
});
add_filter('post_type_labels_post', function ($labels) { $labels->name='The Journal'; $labels->singular_name='Bài Journal'; $labels->add_new_item='Thêm bài Journal'; return $labels; });
add_action('after_switch_theme',function () { update_option('tp48_flush_rewrite',1); });
add_action('init',function () { if (get_option('tp48_flush_rewrite')) { flush_rewrite_rules(false); delete_option('tp48_flush_rewrite'); } },20);
add_action('template_redirect',function () {
    if (is_preview()) return;
    $legacy=['dau-an'=>tp48_page_url('tong-quan'),'nhat-ky'=>tp48_page_url('tien-do'),'hinh-anh'=>tp48_page_url('tong-quan').'#hinh-anh'];
    foreach ($legacy as $slug=>$target) if (is_page($slug)) { wp_safe_redirect($target,301); exit; }
});

// Reserve pagination routes before single-article rewrite rules.
add_action('init',function () {
    add_rewrite_rule('^(tien-do|the-journal)/page/([0-9]+)/?$', 'index.php?pagename=$matches[1]&paged=$matches[2]', 'top');
});
