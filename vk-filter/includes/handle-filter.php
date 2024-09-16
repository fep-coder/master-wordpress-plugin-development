<?php

if (!defined('ABSPATH')) {
    exit;
}

class VKF_Handle_Filter
{
    public function __construct()
    {
        add_action('wp_ajax_filter_posts', [$this, 'filter_posts']);
        add_action('wp_ajax_nopriv_filter_posts', [$this, 'filter_posts']);
    }

    public function filter_posts()
    {
        if (!isset($_GET['vkf_nonce'])
            && !wp_verify_nonce($_GET['vkf_nonce'], 'vkf_nonce')) {
            wp_die('Invalid nonce.');
        }

        $categories = isset($_GET['categories']) ? $_GET['categories'] : [];
        $meal = isset($_GET['meal']) ? $_GET['meal'] : '';
        $difficulty = isset($_GET['difficulty']) ? $_GET['difficulty'] : '';

        $args = [
            'post_type' => 'recipe',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => [],
            'meta_query' => [],
        ];

        // Taxonomy query for categories
        if (!empty($categories)) {
            $args['tax_query'][] = [
                'taxonomy' => 'category',
                'field' => 'name',
                'terms' => $categories,
                'operator' => 'IN',
            ];
        }

        // Meta query for meal
        if (!empty($meal) && $meal !== 'Any') {
            $args['meta_query'][] = [
                'key' => 'meal',
                'value' => $meal,
                'compare' => '=',
            ];
        }

        // Meta query for difficulty
        if (!empty($difficulty)) {
            $args['meta_query'][] = [
                'key' => 'difficulty',
                'value' => $difficulty,
                'compare' => '=',
            ];
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            echo '<div class="row">';
            while ($query->have_posts()) {
                $query->the_post();

                // Output post content
                echo '<div class="col-6">';
                echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
                if (has_post_thumbnail()) {
                    echo '<a href="' . get_permalink() . '">'
                    . get_the_post_thumbnail(get_the_ID(),
                        'medium', ['class' => 'img-fluid', 'alt' => get_the_title()])
                        . '</a>';
                }
                echo '</div>';
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<h3 class="text-center w-100">No recipes found.</h3>';
        }

        wp_die();
    }
}
