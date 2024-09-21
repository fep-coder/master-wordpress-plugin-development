<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Add_Recipe
{

    public function __construct()
    {
        add_action('admin_post_submit_recipe', [$this, 'handle_recipe_submission']);
        add_action('admin_post_nopriv_submit_recipe', [$this, 'handle_recipe_submission']);
    }

    public function handle_recipe_submission()
    {
        if (isset($_POST['submit_recipe'])
            && isset($_POST['recipe_submission_nonce'])
            && wp_verify_nonce($_POST['recipe_submission_nonce'], 'recipe_submission')) {

            $title = sanitize_text_field($_POST['title']);
            $meal = sanitize_text_field($_POST['meal']);
            $difficulty = sanitize_text_field($_POST['difficulty']);
            $content = sanitize_textarea_field($_POST['content']);
            $category_id = sanitize_text_field($_POST['category']);

            $new_recipe = [
                'post_title' => $title,
                'post_content' => $content,
                'post_status' => 'pending',
                'post_type' => 'recipe',
                'post_category' => [$category_id],
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
