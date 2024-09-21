<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Add_Recipe
{

    public function __construct()
    {
        add_action('init', [$this, 'process_recipe_submission']);
    }

    public function process_recipe_submission()
    {
        if (isset($_POST['submit_recipe'])
            && isset($_POST['recipe_submission_nonce'])
            && wp_verify_nonce($_POST['recipe_submission_nonce'], 'recipe_submission')) {

            $title = sanitize_text_field($_POST['title']);
            $meal = sanitize_text_field($_POST['meal']);
            $difficulty = sanitize_text_field($_POST['difficulty']);
            $content = sanitize_textarea_field($_POST['content']);

            $new_recipe = [
                'post_title' => $title,
                'post_content' => $content,
                'post_status' => 'pending',
                'post_type' => 'recipe',
            ];

            $recipe_id = wp_insert_post($new_recipe);

            if ($recipe_id) {
                update_field('meal', $meal, $recipe_id);
                update_field('difficulty', $difficulty, $recipe_id);

                echo 'submitted';
                exit;
            } else {
                wp_die(__('Error submitting your recipe, try again later.', 'aarr'));
            }

        }
    }

}
