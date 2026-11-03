<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Chuyển đến nội dung</a>
<header class="site-header">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="48 Trần Phú Nha Trang — Trang chủ"><span class="brand-number">48</span><span>TRẦN PHÚ<small>NHA TRANG</small></span></a>
    <button class="menu-toggle" aria-label="Mở menu" aria-expanded="false" aria-controls="main-nav"><span></span><span></span><span></span></button>
<?php if (is_front_page() || is_page_template('front-page.php')): get_template_part('template-parts/home-classic/navigation'); else: ?>
    <nav id="main-nav" aria-label="Điều hướng chính"><?php wp_nav_menu(['theme_location'=>'primary','container'=>false,'menu_class'=>'nav-list','fallback_cb'=>'tp48_navigation']); ?></nav>
<?php endif; ?>
</header>
