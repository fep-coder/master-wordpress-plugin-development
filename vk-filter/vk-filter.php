<?php

/**
 * Plugin Name: VK Filter
 * Plugin URI: https://vk.com/vk-filter
 * Description: Post Filter
 * Version: 1.0
 * Author: VK
 * Text Domain: vkf
 */

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('VK_FILTER_PATH', plugin_dir_path(__FILE__));

// Include required files
require_once VK_FILTER_PATH . 'includes/list-recipes.php';

class VK_Filter
{
    private static $instance = null;

    public function __construct()
    {
        new VKF_List_Recipes();
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
    }
}

add_action('plugins_loaded', ['VK_Filter', 'get_instance']);

register_activation_hook(__FILE__, ['VK_Filter', 'activate']);
register_deactivation_hook(__FILE__, ['VK_Filter', 'deactivate']);
register_uninstall_hook(__FILE__, ['VK_Filter', 'uninstall']);
