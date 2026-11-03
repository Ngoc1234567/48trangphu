<?php if (!defined('ABSPATH')) exit;
$menu=absint(tp48_home_field('brand','menu'));$items=$menu ? wp_get_nav_menu_items($menu):[]; ?>
<nav id="main-nav" aria-label="Điều hướng chính">
<?php if ($items): foreach ($items as $item): if ($item->menu_item_parent) continue; $link=['url'=>$item->url,'target'=>$item->target]; ?><a <?php echo tp48_home_link_attributes($link); ?>><?php echo esc_html($item->title); ?></a><?php endforeach; else: foreach (['vi-tri'=>'Vị trí','tong-quan'=>'Dấu ấn Nha Trang','hinh-anh'=>'Hình ảnh','tien-do'=>'Nhật ký công trình','lien-he'=>'Liên hệ'] as $slug=>$label): ?><a href="<?php echo esc_url(tp48_page_url($slug)); ?>"><?php echo esc_html($label); ?></a><?php endforeach; endif; ?>
</nav>
