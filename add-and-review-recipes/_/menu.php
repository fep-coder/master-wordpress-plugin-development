<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Menu
{
    public function __construct()
    {
        // add_filter('wp_nav_menu_items', [$this, 'custom_menu_item']);
        add_filter('wp_nav_menu_objects', [$this, 'modify_menu_items']);
    }

    public function custom_menu_item($items)
    {
        $items .= '<li>test</li>';

        return $items;
    }

    public function modify_menu_items($items)
    {
        $login_url = site_url('/login/');
        $register_url = site_url('/register/');
        $logout_url = wp_logout_url();

        foreach ($items as $key => &$item) {
            if (is_user_logged_in()) {

                if ($item->url == $login_url) {
                    $item->url = $logout_url;
                    $item->title = __('Logout', 'aarr');
                }

                if ($item->url == $register_url || $item->url == $logout_url) {
                    unset($items[$key]);
                }
            }
        }

        return $items;
    }

}
