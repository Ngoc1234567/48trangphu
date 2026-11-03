<?php get_header(); ?>
<main id="main" class="article-page">
<?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article><p class="eyebrow">48 Trần Phú · Nha Trang</p><h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1><?php if (has_post_thumbnail()) { the_post_thumbnail('large'); } ?><div class="entry-content"><?php the_content(); ?></div></article>
<?php endwhile; the_posts_pagination(); else: ?><h1>Chưa có nội dung</h1><p>Nội dung sẽ sớm được cập nhật.</p><?php endif; ?>
<a class="text-link" href="<?php echo esc_url(home_url('/')); ?>">← Về trang chủ</a>
</main>
<?php get_footer(); ?>
