<?php if (!defined('ABSPATH')) exit; ?>
<section id="journal-entries" class="journal-entries" aria-label="Các bài nhật ký" <?php if (empty($args['expanded'])) echo 'hidden'; ?>>
        <?php $journal = new WP_Query(['post_type' => 'tp48_journal', 'posts_per_page' => 6, 'paged' => !empty($args['expanded']) ? max(1, get_query_var('paged'), get_query_var('page')) : 1]); ?>
        <?php if ($journal->have_posts()): while ($journal->have_posts()): $journal->the_post(); ?>
            <article><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d.m.Y')); ?></time><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php the_excerpt(); ?></article>
        <?php endwhile; else: ?><p>Nhật ký công trình sẽ được cập nhật tại đây khi có thông tin chính thức.</p><?php endif; if (!empty($args['expanded'])) { echo wp_kses_post(paginate_links(['total' => $journal->max_num_pages, 'current' => max(1, get_query_var('paged'), get_query_var('page'))])); } wp_reset_postdata(); ?>
    </section>
