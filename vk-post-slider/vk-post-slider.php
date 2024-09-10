<?php

/**
 * Plugin Name: VK Post Slider
 * Plugin URI: https://vk.com/vkpostslider
 * Description: Post Slider
 * Version: 1.0
 * Author: VK
 * Author URI: https://vk.com/vkpostslider
 */

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class VK_Post_Slider
{
    private static $instance = null;

    public function __construct()
    {
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function activate()
    {
        // Code to run on plugin activation
    }

    public static function deactivate()
    {
        // Code to run on plugin deactivation
    }

    public static function uninstall()
    {
        // Code to run on plugin uninstall
    }
}

add_action('plugins_loaded', ['VK_Post_Slider', 'get_instance']);

register_activation_hook(__FILE__, ['VK_Post_Slider', 'activate']);
register_deactivation_hook(__FILE__, ['VK_Post_Slider', 'deactivate']);
register_uninstall_hook(__FILE__, ['VK_Post_Slider', 'uninstall']);
