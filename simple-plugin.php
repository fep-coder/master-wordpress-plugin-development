<?php

/**
 * Plugin Name: Simple Plugin
 * Plugin URI: https://github.com/simple-plugin
 * Description: A simple plugin
 * Version: 1.0.0
 * Author: VK
 *
 */

// echo 'Hello';

function prefix_add_before_title($title, $id)
{
    if (is_admin()) {
        return $title;
    }

    if (get_post_type($id) == "post") {
        error_log('The title is: ' . $title);
        return 'Prefix: ' . $title;
    }

    return $title;
}
add_filter('the_title', 'prefix_add_before_title', 10, 2);

function my_admin_notices()
{
    echo '<div class="notice notice-success is-dismissible">
            <p>This is a custom admin notice!</p>
        </div>';
}
add_action('admin_notices', 'my_admin_notices');
