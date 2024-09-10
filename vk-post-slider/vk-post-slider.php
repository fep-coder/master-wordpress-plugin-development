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

function vkps_display_specific_posts($atts)
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

    echo '<div class="slider">';

    while ($query->have_posts()) {
        $query->the_post();
        ?>
        <div>
            <?php the_post_thumbnail();?>
            <h2><?php the_title();?></h2>
            <?php the_content();?>
        </div>

    <?php

    }

    echo '</div>';

    wp_reset_postdata();

    // Get the contents of the output buffer and clean it up
    return ob_get_clean();
}

add_shortcode('vk_slider', 'vkps_display_specific_posts');

function vkps_enqueue_scripts()
{
    wp_enqueue_script(
        'slickjs',
        "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js",
        ['jquery'],
        '1.0.0',
        true
    );

    wp_enqueue_script(
        'slick-init',
        plugins_url('assets/slick-init.js', __FILE__),
        ['jquery'],
        '1.0.0',
        true
    );

    wp_enqueue_style(
        'slicktheme',
        "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
    );

    wp_enqueue_style(
        'slickcss',
        "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"
    );
}

add_action('wp_enqueue_scripts', 'vkps_enqueue_scripts');