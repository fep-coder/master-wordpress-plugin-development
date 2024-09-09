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

function vk_display_specific_posts($atts)
{

    $atts = shortcode_atts(['ids' => ''], $atts);

    $post_ids = explode(',', $atts['ids']); // 1,2,3

    $args = [
        'post_type' => 'post',
        'post__in' => $post_ids,
        'orderby' => 'post__in',
    ];
    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return '<p>No posts found.</p>';
    }

    // Start output buffering
    ob_start();

    while ($query->have_posts()) {
        $query->the_post();
        ?>

        <h2><?php the_title();?></h2>
        <div><?php the_content();?></div>

    <?php

    }

    wp_reset_postdata();

    // Get the contents of the output buffer and clean it up
    return ob_get_clean();
}

add_shortcode('vk_slider', 'vk_display_specific_posts');
