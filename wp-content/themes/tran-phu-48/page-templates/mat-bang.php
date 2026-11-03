<?php
/* Template Name: Mặt bằng */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading'); ?>
<section class="section-space ruled information-page"><div class="information-intro"><p class="eyebrow">Thông tin được xác nhận</p><h2>Mặt bằng<br><em>48 Trần Phú</em></h2><p class="muted">Mặt bằng và các tài liệu liên quan sẽ được đăng tải khi có nguồn xác thực.</p></div><div><?php if (has_post_thumbnail()) the_post_thumbnail('large',['class'=>'page-cover']); tp48_page_content(); ?></div></section><section class="section-space ruled update-invite"><h2>Theo dõi thông tin mới</h2><p>Đăng ký nhận cập nhật khi có nội dung chính thức được công bố.</p><a class="button outline" href="<?php echo esc_url(tp48_page_url('lien-he')); ?>">Nhận thông tin cập nhật <span aria-hidden="true">↗</span></a></section>
</main>

<?php get_footer(); ?>
