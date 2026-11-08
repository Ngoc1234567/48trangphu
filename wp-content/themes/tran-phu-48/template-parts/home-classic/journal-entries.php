<?php if (!defined('ABSPATH')) exit;
$selected=tp48_home_field('journal','posts');$selected=array_filter(array_map('absint',is_array($selected) ? $selected:[]));
$query=['post_type'=>'tp48_journal','post_status'=>'publish','posts_per_page'=>max(1,min(24,(int)tp48_home_field('journal','limit'))),'ignore_sticky_posts'=>true,'no_found_rows'=>true];
if (!$selected) $query['tp48_progress_order']=true;
if ($selected) { $query['post__in']=$selected;$query['orderby']='post__in'; }
$journal=new WP_Query($query); ?>
<section id="journal-entries" class="journal-entries" aria-label="Các bài nhật ký" hidden>
<?php if ($journal->have_posts()): while ($journal->have_posts()): $journal->the_post(); ?>
<article><?php if (tp48_home_field('journal','show_date')): ?><time datetime="<?php echo esc_attr(tp48_progress_date(0,'Y-m-d')); ?>"><?php echo esc_html(tp48_progress_date()); ?></time><?php endif; ?><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php if (tp48_home_field('journal','show_excerpt')) tp48_progress_summary(); ?></article>
<?php endwhile; else: ?><p><?php echo tp48_home_text('journal','empty_message'); ?></p><?php endif; wp_reset_postdata(); ?>
</section>
