<?php if (!defined('ABSPATH')) exit; ?>
<nav id="main-nav" aria-label="Điều hướng chính">
<?php wp_nav_menu(['menu'=>absint(tp48_home_field('brand','menu')),'theme_location'=>'primary','container'=>false,'menu_class'=>'nav-list','fallback_cb'=>'tp48_navigation']); ?>
</nav>
