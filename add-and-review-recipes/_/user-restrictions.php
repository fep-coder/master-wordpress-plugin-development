<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_User_Restrictions
{

    public function __construct()
    {
        add_action('admin_init', [$this, 'redirect_non_admin_users']);
        // add_filter('show_admin_bar', [$this, 'hide_admin_bar_for_users']);
    }

    public function redirect_non_admin_users()
    {
        if (!current_user_can('edit_posts') && !wp_doing_ajax()) {

            if (isset($_POST['action']) && $_POST['action'] == 'submit_recipe') {
                return;
            }

            wp_safe_redirect(home_url());
            exit;
        }
    }

    public function hide_admin_bar_for_users($show_admin_bar)
    {
        if (!current_user_can('edit_posts')) {
            $show_admin_bar = false;
        }

        return $show_admin_bar;
    }

}
