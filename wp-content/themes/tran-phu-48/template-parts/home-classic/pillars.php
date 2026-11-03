<?php if (!defined('ABSPATH')) exit; $items=[];
for ($i=1;$i<=4;$i++) { $item=tp48_home_field('pillars','item_'.$i); if (is_array($item) && !empty($item['enabled'])) $items[]=$item; }
if (!$items) return; ?>
<nav class="pillars" aria-label="Khám phá 48 Trần Phú" style="--tp48-pillar-count:<?php echo count($items); ?>">
<?php foreach ($items as $item): $link=$item['link'] ?? []; $linked=(bool)tp48_home_link_attributes($link); ?>
<<?php echo $linked ? 'a':'span'; ?> class="pillar-item" <?php if ($linked) echo tp48_home_link_attributes($link); ?>>
<?php if (!empty($item['image'])) echo tp48_home_image_html($item['image'],$item['title'] ?? '','pillar-icon'); else echo tp48_icon(in_array($item['icon'] ?? '',['pin','waves','star','diamond'],true) ? $item['icon']:'pin'); ?>
<span><?php echo esc_html($item['title'] ?? ''); ?></span><?php if ($linked): ?><span class="mobile-chevron" aria-hidden="true">›</span><?php endif; ?>
</<?php echo $linked ? 'a':'span'; ?>>
<?php endforeach; ?>
</nav>
