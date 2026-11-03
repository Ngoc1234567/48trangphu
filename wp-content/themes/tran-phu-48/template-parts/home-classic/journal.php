<?php if (!defined('ABSPATH')) exit; $button=tp48_home_field('journal','button'); ?>
<section class="journal ruled" id="nhat-ky" aria-labelledby="journal-title">
<?php echo tp48_home_image_html(tp48_home_field('journal','image'),tp48_home_field('journal','alt'),'journal-image'); ?>
<h2 id="journal-title"><?php echo tp48_home_text('journal','title',true); ?><span class="short-line"></span></h2>
<div class="journal-copy"><p><?php echo tp48_home_text('journal','description',true); ?></p>
<?php if (tp48_home_field('journal','mode')==='page'): if (tp48_home_link_attributes($button)): ?><a class="text-link" <?php echo tp48_home_link_attributes($button); ?>><?php echo tp48_home_text('journal','button_label'); ?> <span aria-hidden="true">⟶</span></a><?php endif; else: ?><button type="button" class="text-link" aria-expanded="false" aria-controls="journal-entries" data-journal-toggle><?php echo tp48_home_text('journal','button_label'); ?> <span aria-hidden="true">⟶</span></button><?php endif; ?></div>
<?php if (tp48_home_field('journal','image_note')): ?><span class="classic-photo-note"><?php echo tp48_home_text('journal','image_note'); ?></span><?php endif; ?>
</section>
