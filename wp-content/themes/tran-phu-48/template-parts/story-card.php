<?php if (!defined('ABSPATH')) exit; ?>
<article class="story-card">
<?php if (has_post_thumbnail()): ?><a href="<?php the_permalink(); ?>" class="story-image" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail('large',['loading'=>'lazy']); ?></a><?php endif; ?>
<div class="story-card-body"><p class="eyebrow"><?php echo !empty($args['progress']) ? 'Cập nhật tiến độ' : esc_html(get_the_category_list(' · ') ? wp_strip_all_tags(get_the_category_list(' · ')) : 'The Journal'); ?></p><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d.m.Y')); ?></time><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php the_excerpt(); ?><a class="text-link" href="<?php the_permalink(); ?>">Đọc bài viết <span aria-hidden="true">↗</span></a></div>
</article>
