<?php
/* Template Name: Liên hệ */
if (!defined('ABSPATH')) exit;
get_header(); ?>
<main id="main" class="section-page">
<?php get_template_part('template-parts/page-heading'); ?>
<section class="section-space ruled contact-details"><div><p class="eyebrow">Trao đổi & cập nhật</p><h2>Kết nối với<br>48 Trần Phú</h2><p class="muted">Tiếp nhận nhu cầu tìm hiểu và cập nhật thông tin đã xác minh về dự án.</p></div><address><p>Địa điểm dự án: 48 Trần Phú, Nha Trang</p><?php if (tp48_phone()): ?><a href="tel:<?php echo esc_attr(tp48_phone()); ?>">Gọi điện · <?php echo esc_html(tp48_text('phone')); ?></a><a href="<?php echo esc_url(tp48_zalo()); ?>" target="_blank" rel="noopener noreferrer">Trao đổi qua Zalo ↗</a><?php endif; ?><?php if (tp48_text('email')): ?><a href="mailto:<?php echo esc_attr(tp48_text('email')); ?>"><?php echo esc_html(tp48_text('email')); ?></a><?php endif; ?></address></section>
<?php while (have_posts()): the_post(); if (trim(get_the_content())): ?><section class="section-space entry-content ruled"><?php the_content(); ?></section><?php endif; endwhile; ?>
<?php get_template_part('template-parts/contact'); ?>
</main>

<?php get_footer(); ?>
