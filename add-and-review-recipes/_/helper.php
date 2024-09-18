<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Helper
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts()
    {
        if (is_page('register')) {
            wp_enqueue_script(
                'jquery-validate',
                'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js',
                ['jquery'],
                '1.21.0',
                true
            );

            wp_enqueue_script(
                'register-validation',
                AARR_URL . 'assets/js/register-validation.js',
                ['jquery', 'jquery-validate'],
                '1.0.0',
                true
            );
        }

        if (is_page('login')) {
            wp_enqueue_script(
                'jquery-validate',
                'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js',
                ['jquery'],
                '1.21.0',
                true
            );

            wp_enqueue_script(
                'login-validation',
                AARR_URL . 'assets/js/login-validation.js',
                ['jquery', 'jquery-validate'],
                '1.0.0',
                true
            );
        }
    }

}
