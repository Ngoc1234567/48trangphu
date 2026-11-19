<?php
if (!defined('ABSPATH')) exit;
$page_id=get_the_ID();
$current=max(1,(int)get_query_var('paged'),(int)get_query_var('page'));
$updates=new WP_Query(['post_type'=>'tp48_journal','post_status'=>'publish','posts_per_page'=>6,'paged'=>$current,'tp48_progress_order'=>true,'ignore_sticky_posts'=>true]);
?>
<div class="progress-timeline">
<?php if ($updates->have_posts()): while ($updates->have_posts()): $updates->the_post(); ?>
<article class="progress-update">
<div class="progress-media">
<?php get_template_part('template-parts/progress-cover'); ?>
</div>
<div class="progress-update-body">
<p class="eyebrow progress-month"><time datetime="<?php echo esc_attr(tp48_progress_date(0,'Y-m')); ?>">Tháng <?php echo esc_html(tp48_progress_date(0,'m/Y')); ?></time></p>
<?php if (tp48_detail_field('update_is_demo')): ?><p class="demo-notice">Nội dung mẫu để duyệt bố cục — không phản ánh tiến độ thực tế của dự án.</p><?php endif; ?>
<h2><a href="<?php the_permalink(); ?>"><?php echo esc_html(tp48_detail_field('update_title') ?: get_the_title()); ?></a></h2>
<div class="progress-summary"><?php tp48_progress_summary(); ?></div>
<a class="button outline" href="<?php the_permalink(); ?>"><?php echo esc_html(tp48_detail_field('update_button_label') ?: 'Xem cập nhật chi tiết'); ?> <span aria-hidden="true">↗</span></a>
</div></article>
<?php endwhile; else: ?>
<div class="pending-information"><p class="eyebrow">Chờ cập nhật chính thức</p><h3><?php echo tp48_detail_text('progress_heading',$page_id); ?></h3><p><?php echo nl2br(tp48_detail_text('progress_empty',$page_id)); ?></p></div>
<?php endif; ?>
</div>
<?php if ($updates->max_num_pages>1): ?><nav class="pagination" aria-label="Phân trang tiến độ"><?php echo wp_kses_post(paginate_links(['total'=>$updates->max_num_pages,'current'=>$current])); ?></nav><?php endif; wp_reset_postdata(); ?>
