<?php if (!defined('ABSPATH')) exit; ?>
<nav class="pillars" aria-label="Khám phá 48 Trần Phú">
        <?php foreach ([['pin','Vị trí đắc địa','vi-tri'],['waves','Bên vịnh biển','dau-an'],['star','Dấu ấn đô thị','dau-an'],['diamond','Giá trị bền vững','kham-pha']] as $item): ?>
        <a href="#<?php echo esc_attr($item[2]); ?>"><?php echo tp48_icon($item[0]); ?><span><?php echo esc_html($item[1]); ?></span><span class="mobile-chevron" aria-hidden="true">›</span></a>
        <?php endforeach; ?>
    </nav>
