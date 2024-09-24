<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Submit_Rating
{

    public function __construct()
    {
        add_action('wp_ajax_submit_rating', [$this, 'submit_rating']);
        add_action('wp_ajax_nopriv_submit_rating', [$this, 'submit_rating']);
    }

    public function submit_rating()
    {
        // Check nonce
        check_ajax_referer('rating_nonce', 'security');

        if (!is_user_logged_in()) {
            wp_send_json_error('You must be logged in to submit a rating');
        }

        global $wpdb;

        $recipe_id = intval($_POST['recipe_id']);
        $rating = intval($_POST['rating']);
        $user_id = get_current_user_id();

        // Check if rating already exists
        $rating_exists = $wpdb->get_var($wpdb->prepare(
            "SELECT rating FROM {$wpdb->prefix}aarr_ratings
            WHERE recipe_id = %d
            AND user_id = %d", $recipe_id, $user_id
        ));

        if ($rating_exists) {
            $wpdb->update(
                $wpdb->prefix . 'aarr_ratings',
                ['rating' => $rating],
                ['recipe_id' => $recipe_id, 'user_id' => $user_id],
                ['%d'],
                ['%d', '%d']
            );
        } else {
            $wpdb->insert(
                $wpdb->prefix . 'aarr_ratings',
                ['recipe_id' => $recipe_id, 'user_id' => $user_id, 'rating' => $rating],
                ['%d', '%d', '%d']
            );
        }

        $avg_rating = $wpdb->get_var($wpdb->prepare(
            "SELECT AVG(rating)
            FROM {$wpdb->prefix}aarr_ratings
            WHERE recipe_id = %d", $recipe_id
        ));

        wp_send_json_success(['avg_rating' => round($avg_rating)]);
    }

}
