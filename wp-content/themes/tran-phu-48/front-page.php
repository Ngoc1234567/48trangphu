<?php
/* Template Name: Trang chủ */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main">
<?php
get_template_part('template-parts/home-classic/hero');
get_template_part('template-parts/home-classic/pillars');
get_template_part('template-parts/home-classic/location');
get_template_part('template-parts/home-classic/identity');
get_template_part('template-parts/home-classic/gallery');
get_template_part('template-parts/home-classic/journal');
get_template_part('template-parts/home-classic/journal-entries');
get_template_part('template-parts/home-classic/contact');
?>
</main>
<?php get_template_part('template-parts/lightbox'); get_footer(); ?>
