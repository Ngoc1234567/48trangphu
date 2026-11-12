<?php if (!defined('ABSPATH')) exit; ?>
<section class="identity ruled" id="dau-an" aria-labelledby="identity-title">
    <?php echo tp48_home_image_html(tp48_home_field('identity','image'),tp48_home_field('identity','alt')); ?>
    <div class="identity-copy"><h2 id="identity-title"><?php echo tp48_home_text('identity','title'); ?></h2><div class="short-line"></div><p><?php echo tp48_home_text('identity','description',true); ?></p></div>
</section>
