<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Profile_SC
{

    public function __construct()
    {
        add_shortcode('profile', [$this, 'render_profile']);
    }

    public function render_profile()
    {
        $user_id = get_current_user_id();

        if ($user_id == 0) {
            return '<p class="text-center w-100">You must be logged in to view your profile.<br> <a href="/login">Log in</a></p>';
        }

        $args = [
            'post_type' => 'recipe',
            'posts_per_page' => -1,
            'author' => $user_id,
            'post_status' => ['publish', 'pending'],
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                echo '<div class="col-6 pb-3">';

                $query->the_post();
                $post_status = get_post_status();

                $status_label = ($post_status == 'pending') ? ' ( pending )' : '';

                echo '<h2>' . get_the_title() . $status_label . '</h2>';
                echo get_the_post_thumbnail(get_the_ID(), 'thumbnail');

                echo '</div>';
            }

            wp_reset_postdata();
        } else {
            echo '<p class="text-center w-100">You currently have no recipes.</p>';
        }

    }

}
