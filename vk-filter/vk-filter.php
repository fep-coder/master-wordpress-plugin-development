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
// require_once VK_FILTER_PATH . 'includes/scripts.php';

class VK_Filter
{
    private static $instance = null;

    public function __construct()
    {
        // add_action('pre_get_posts', [$this, 'filter_posts_by_category']);
        add_action('pre_get_posts', [$this, 'filter_posts_by_taxonomy']);
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function filter_posts_by_category($query)
    {
        if (!is_admin() && $query->get('pagename') == 'blog') {
            $categories = ['et', 'aspernatur', 'quia'];

            $query->set('category_name', implode(',', $categories));
        }
    }

    public function filter_posts_by_taxonomy($query)
    {
        if (!is_admin() && $query->get('pagename') == 'blog') {

            $taxonomy = 'category';
            $terms = ['et', 'aspernatur'];

            $query->set('tax_query', [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $terms,
                ],
            ]);
        }
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
