<?php
if (!defined('ABSPATH')) exit;
require_once __DIR__ . '/inc/setup.php';
require_once __DIR__ . '/inc/acf-home.php';
require_once __DIR__ . '/inc/acf-pages.php';
require_once __DIR__ . '/inc/contact.php';
require_once __DIR__ . '/inc/contact-cf7.php';
require_once __DIR__ . '/inc/review-updates.php';
require_once __DIR__ . '/inc/admin.php';
require_once __DIR__ . '/inc/seo.php';
function tp48_icon($name) {
    $paths = [
        'pin' => '<path d="M24 43S9 28 9 18a15 15 0 1 1 30 0c0 10-15 25-15 25Z"/><circle cx="24" cy="18" r="6"/>',
        'waves' => '<path d="M3 12q5-7 10 0t10 0t10 0t12 0M3 24q5-7 10 0t10 0t10 0t12 0M3 36q5-7 10 0t10 0t10 0t12 0"/>',
        'star' => '<path d="m24 2 5 12 13-5-5 13 10 5-13 5 4 13-14-8-11 8 2-14L2 25l13-5-4-12 12 6Z"/><path d="m24 15 3 7 8 2-7 4-4 8-3-8-8-4 8-2Z"/>',
        'diamond' => '<path d="m3 15 9-10h24l9 10-21 29Z M3 15h42M12 5l5 10 7-10 7 10 5-10M17 15l7 29 7-29"/>',
    ];
    return '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($paths[$name] ?? '') . '</svg>';
}
