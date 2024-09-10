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

// Define constants
define('VK_POST_SLIDER_PATH', plugin_dir_path(__FILE__));
define('VK_POST_SLIDER_URL', plugin_dir_url(__FILE__));

// Include required files
require_once VK_POST_SLIDER_PATH . 'includes/scripts.php';
require_once VK_POST_SLIDER_PATH . 'includes/shortcode.php';
require_once VK_POST_SLIDER_PATH . 'includes/admin.php';

class VK_Post_Slider
{
    private static $instance = null;

    public function __construct()
    {
        new VKPS_Scripts();
        new VKPS_Shortcode();
        new VKPS_Admin();
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
        delete_option('vk_post_ids');
    }
}

add_action('plugins_loaded', ['VK_Post_Slider', 'get_instance']);

register_activation_hook(__FILE__, ['VK_Post_Slider', 'activate']);
register_deactivation_hook(__FILE__, ['VK_Post_Slider', 'deactivate']);
register_uninstall_hook(__FILE__, ['VK_Post_Slider', 'uninstall']);
