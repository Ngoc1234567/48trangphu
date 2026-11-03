<?php
if (!defined('ABSPATH')) exit;
function tp48_should_noindex() {
    if (wp_get_environment_type()!=='production') return true;
    if (is_search() || is_404()) return true;
    if (is_page(['chinh-sach-bao-mat'])) return true;
    if (is_page_template(['page-templates/tong-quan.php','page-templates/vi-tri.php','page-templates/mat-bang.php','page-templates/tien-ich.php']) && get_post_meta(get_queried_object_id(),'_tp48_ready',true)!=='1') return true;
    if (is_page('tien-do') && !(wp_count_posts('tp48_journal')->publish ?? 0)) return true;
    if (is_page('the-journal') && !(wp_count_posts('post')->publish ?? 0)) return true;
    return false;
}
add_filter('wpseo_robots_array',function ($robots) { if (tp48_should_noindex()) $robots['index']='noindex'; return $robots; });
add_filter('wp_robots',function ($robots) { if (tp48_should_noindex()) { unset($robots['index']); $robots['noindex']=true; } return $robots; });
add_action('wp_head',function () {
    if (wp_get_environment_type()!=='production') return;
    $gsc=tp48_text('gsc');
    if ($gsc) echo '<meta name="google-site-verification" content="'.esc_attr($gsc).'">'."
";
    $ga=tp48_text('ga4');
    if ($ga && preg_match('/^G-[A-Z0-9]+$/',$ga)) {
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id='.esc_attr($ga).'"></script>';
        echo '<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());gtag("config",'.wp_json_encode($ga).');</script>';
    }
},20);
// Yoast owns metadata when active. A small fallback keeps basic metadata intact otherwise.
add_action('wp_head',function () {
    if (defined('WPSEO_VERSION')) return;
    $description=is_singular() ? get_post_meta(get_queried_object_id(),'_yoast_wpseo_metadesc',true) : '';
    if (!$description) $description='Website thông tin về dự án tại 48 Trần Phú, Nha Trang. Tổng quan, vị trí và các cập nhật được xác nhận.';
    echo '<meta name="description" content="'.esc_attr($description).'">'."
";
});

add_filter('wpseo_metadesc',function ($description) {
    if ($description) return $description;
    if (is_category()) return 'The Journal — ' . single_cat_title('',false) . '. Bài viết trên website thông tin 48 Trần Phú, Nha Trang.';
    if (is_singular()) {
        $post=get_queried_object();
        if ($post && trim($post->post_excerpt)) return wp_trim_words(wp_strip_all_tags($post->post_excerpt),30,'');
        if ($post && trim($post->post_content)) return wp_trim_words(wp_strip_all_tags(strip_shortcodes($post->post_content)),30,'');
    }
    return 'Website thông tin về dự án tại 48 Trần Phú, Nha Trang. Tổng quan, vị trí và các cập nhật được xác nhận.';
});

// Keep incomplete pages out of the XML sitemap as well as marking them noindex.
add_filter('wpseo_sitemap_entry',function ($url,$type,$object) {
    if ($type!=='post' || !($object instanceof WP_Post) || $object->post_type!=='page') return $url;
    $template=get_page_template_slug($object->ID);
    if (in_array($template,['page-templates/tong-quan.php','page-templates/vi-tri.php','page-templates/mat-bang.php','page-templates/tien-ich.php'],true) && get_post_meta($object->ID,'_tp48_ready',true)!=='1') return false;
    if (in_array($object->post_name,['dau-an','nhat-ky','hinh-anh','chinh-sach-bao-mat'],true)) return false;
    if ($object->post_name==='tien-do' && !(wp_count_posts('tp48_journal')->publish ?? 0)) return false;
    if ($object->post_name==='the-journal' && !(wp_count_posts('post')->publish ?? 0)) return false;
    return $url;
},10,3);
