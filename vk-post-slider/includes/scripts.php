<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class VKPS_Scripts
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'vkps_enqueue_scripts']);
    }

    public function vkps_enqueue_scripts()
    {
        wp_enqueue_script(
            'slickjs',
            "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js",
            ['jquery'],
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'slick-init',
            VK_POST_SLIDER_URL . 'assets/slick-init.js',
            ['jquery'],
            '1.0.0',
            true
        );

        wp_enqueue_style(
            'slicktheme',
            "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
        );

        wp_enqueue_style(
            'slickcss',
            "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"
        );
    }

}
