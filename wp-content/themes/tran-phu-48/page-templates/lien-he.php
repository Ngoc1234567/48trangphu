<?php
/* Template Name: Liên hệ */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading'); ?>

<?php while (have_posts()): the_post(); if (trim(get_the_content())): ?><section class="section-space entry-content ruled"><?php the_content(); ?></section><?php endif; endwhile; ?>
<?php get_template_part('template-parts/contact'); ?>
</main>

<?php get_footer(); ?>
