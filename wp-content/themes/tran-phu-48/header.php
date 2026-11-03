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
    <nav id="main-nav" aria-label="Điều hướng chính">
        <a href="<?php echo esc_url(home_url('/#vi-tri')); ?>">Vị trí</a><a href="<?php echo esc_url(home_url('/#dau-an')); ?>">Dấu ấn Nha Trang</a><a href="<?php echo esc_url(home_url('/#hinh-anh')); ?>">Hình ảnh</a><a href="<?php echo esc_url(home_url('/#nhat-ky')); ?>">Nhật ký công trình</a>
    </nav>
</header>
