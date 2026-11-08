<?php
if (!defined('ABSPATH')) exit;
$page_id=get_the_ID();
$current=max(1,(int)get_query_var('paged'),(int)get_query_var('page'));
$updates=new WP_Query(['post_type'=>'tp48_journal','post_status'=>'publish','posts_per_page'=>6,'paged'=>$current,'tp48_progress_order'=>true,'ignore_sticky_posts'=>true]);
?>
<div class="progress-timeline">
<?php if ($updates->have_posts()): while ($updates->have_posts()): $updates->the_post(); ?>
<article class="progress-update">
<div class="progress-date"><time datetime="<?php echo esc_attr(tp48_progress_date(0,'Y-m-d')); ?>"><?php echo esc_html(tp48_progress_date()); ?></time></div>
<div class="progress-update-body">
<?php if (tp48_detail_field('update_is_demo')): ?><p class="demo-notice">Nội dung mẫu để duyệt bố cục — không phản ánh tiến độ thực tế của dự án.</p><?php endif; ?>
<div class="progress-media"><?php get_template_part('template-parts/progress-media'); ?></div>
<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
<div class="progress-summary"><?php tp48_progress_summary(); ?></div>
<a class="text-link" href="<?php the_permalink(); ?>">Xem bản cập nhật <span aria-hidden="true">↗</span></a>
</div></article>
<?php endwhile; else: ?>
<div class="pending-information"><p class="eyebrow">Chờ cập nhật chính thức</p><h3><?php echo tp48_detail_text('progress_heading',$page_id); ?></h3><p><?php echo nl2br(tp48_detail_text('progress_empty',$page_id)); ?></p></div>
<?php if (tp48_detail_field('progress_show_preview',$page_id)): ?>
<article class="progress-update progress-preview" aria-label="Khung trình bày bản cập nhật, chưa có dữ liệu thực tế">
<div class="progress-date">Ngày cập nhật</div><div class="progress-update-body"><div class="progress-media-empty">Vị trí ảnh hoặc video công trình</div><p class="eyebrow">Khung nội dung chờ cập nhật</p><h3>Tiêu đề bản cập nhật</h3><p>Mô tả ngắn về công việc và hình ảnh được xác nhận tại thời điểm cập nhật.</p></div>
</article>
<?php endif; endif; ?>
</div>
<?php if ($updates->max_num_pages>1): ?><nav class="pagination" aria-label="Phân trang tiến độ"><?php echo wp_kses_post(paginate_links(['total'=>$updates->max_num_pages,'current'=>$current])); ?></nav><?php endif; wp_reset_postdata(); ?>
