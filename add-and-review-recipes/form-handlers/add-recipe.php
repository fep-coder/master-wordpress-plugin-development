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
    }

    public function handle_recipe_submission()
    {
        if (isset($_POST['recipe_submission_nonce'])
            && wp_verify_nonce($_POST['recipe_submission_nonce'], 'recipe_submission')) {

            $title = sanitize_text_field($_POST['title']);
            $meal = sanitize_text_field($_POST['meal']);
            $difficulty = sanitize_text_field($_POST['difficulty']);
            $content = sanitize_textarea_field($_POST['content']);
            $category_id = sanitize_text_field($_POST['category']);

            $errors = [];

            if (strlen($title) < 4) {
                $errors[] = __('Title must be at least 4 characters long!', 'aarr');
            }

            if (strlen($content) < 4) {
                $errors[] = __('Content must be at least 4 characters long!', 'aarr');
            }

            if (empty($category_id)) {
                $errors[] = __('You must select a category!', 'aarr');
            }

            if (!empty($errors)) {
                $_SESSION['add_recipe_data'] = $_POST;
                $_SESSION['add_recipe_errors'] = $errors;
                wp_redirect(wp_get_referer());
                return;
            }

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
