<?php
/* Template Name: Trang chủ */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="home-page">
<?php
$sections=tp48_home_sections();
if (!in_array('hero',$sections,true)) echo '<h1 class="sr-only">'.esc_html(get_the_title()).'</h1>';
foreach ($sections as $section) {
    get_template_part('template-parts/home-classic/'.$section);
    if ($section==='journal' && tp48_home_field('journal','mode')==='toggle') get_template_part('template-parts/home-classic/journal-entries');
}
?>
</main>
<?php if (in_array('gallery',$sections,true) && tp48_home_gallery()) get_template_part('template-parts/lightbox'); get_footer(); ?>
