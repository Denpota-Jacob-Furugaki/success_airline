<?php
/**
 * Success Airline Figma theme functions.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', 'success_airline_figma_enqueue_assets');
function success_airline_figma_enqueue_assets() {
    wp_enqueue_style(
        'success-airline-figma-google-fonts',
        'https://fonts.googleapis.com/css2?family=Allura&family=Noto+Sans+JP:wght@300;400;500;700&family=Shippori+Mincho:wght@400;500;600;700&family=Dancing+Script:wght@400;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'success-airline-figma-homepage',
        get_template_directory_uri() . '/assets/css/homepage.css',
        array('success-airline-figma-google-fonts'),
        file_exists(get_template_directory() . '/assets/css/homepage.css') ? filemtime(get_template_directory() . '/assets/css/homepage.css') : null
    );
}
