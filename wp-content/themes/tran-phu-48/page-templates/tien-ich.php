<?php
/* Template Name: Tiện ích */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading'); ?>
<section class="section-space ruled information-page"><div class="information-intro"><p class="eyebrow">Thông tin được xác nhận</p><h2>Tiện ích<br><em>48 Trần Phú</em></h2><p class="muted">Danh mục tiện ích sẽ được cập nhật khi có thông tin và hình ảnh đã xác minh.</p></div><div><?php if (has_post_thumbnail()) the_post_thumbnail('large',['class'=>'page-cover']); tp48_page_content(); ?></div></section><section class="section-space ruled update-invite"><h2>Theo dõi thông tin mới</h2><p>Đăng ký nhận cập nhật khi có nội dung chính thức được công bố.</p><a class="button outline" href="<?php echo esc_url(tp48_page_url('lien-he')); ?>">Nhận thông tin cập nhật <span aria-hidden="true">↗</span></a></section>
</main>

<?php get_footer(); ?>
