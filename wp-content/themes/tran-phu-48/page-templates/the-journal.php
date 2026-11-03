<?php
/* Template Name: The Journal */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading'); ?>
<section class="section-space ruled"><div class="section-heading"><div><p class="eyebrow">Bài viết & thông tin</p><h2>The Journal</h2></div><p class="muted">Nội dung và góc nhìn được biên tập<br>cho website thông tin 48 Trần Phú.</p></div><?php while (have_posts()): the_post(); if (trim(get_the_content())): ?><div class="entry-content page-body"><?php the_content(); ?></div><?php endif; endwhile; ?>
<nav class="category-nav" aria-label="Danh mục The Journal"><a aria-current="page" href="<?php echo esc_url(tp48_page_url('the-journal')); ?>">Tất cả</a><?php foreach (get_categories(['hide_empty'=>true]) as $category): ?><a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo esc_html($category->name); ?></a><?php endforeach; ?></nav><?php tp48_cards('post',6,true); ?></section>
</main>

<?php get_footer(); ?>
