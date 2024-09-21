<?php

/**
 * Plugin Name: Add And Review Recipes
 * Plugin URI: https://vk.com/add-and-review-recipes
 * Description: Add and review recipes
 * Version: 1.0
 * Author: VK
 * Text Domain: aarr
 */

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

define('AARR_PATH', plugin_dir_path(__FILE__));
define('AARR_URL', plugin_dir_url(__FILE__));

require_once AARR_PATH . 'admin/admin.php';
require_once AARR_PATH . 'shortcodes/register_sc.php';
require_once AARR_PATH . 'form-handlers/register.php';
require_once AARR_PATH . 'shortcodes/login_sc.php';
require_once AARR_PATH . 'form-handlers/login.php';
require_once AARR_PATH . '_/user-restrictions.php';
require_once AARR_PATH . '_/helper.php';
require_once AARR_PATH . '_/menu.php';
require_once AARR_PATH . 'shortcodes/add-recipe-sc.php';
require_once AARR_PATH . 'form-handlers/add-recipe.php';

class Add_And_Review_Recipes
{
    private static $instance = null;

    public function __construct()
    {
        new AARR_Admin();
        new AARR_Register_SC();
        new AARR_Register();
        new AARR_Login_SC();
        new AARR_Login();
        new AARR_User_Restrictions();
        new AARR_Helper();
        new AARR_Menu();
        new AARR_Add_Recipe_SC();
        new AARR_Add_Recipe();
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

add_action('plugins_loaded', ['Add_And_Review_Recipes', 'get_instance']);

register_activation_hook(__FILE__, ['Add_And_Review_Recipes', 'activate']);
register_deactivation_hook(__FILE__, ['Add_And_Review_Recipes', 'deactivate']);
register_uninstall_hook(__FILE__, ['Add_And_Review_Recipes', 'uninstall']);
