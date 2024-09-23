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
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function handle_recipe_submission()
    {
        if (isset($_POST['recipe_submission_nonce'])
            && wp_verify_nonce($_POST['recipe_submission_nonce'], 'recipe_submission')) {

            $title = sanitize_text_field($_POST['title']);
            $meal = sanitize_text_field($_POST['meal']);
            $difficulty = sanitize_text_field($_POST['difficulty']);
            $content = wp_kses_post($_POST['recipe_content']);
            $category_id = sanitize_text_field($_POST['category']);

            $errors = [];

            if (strlen($title) < 4) {
                $errors[] = __('Title must be at least 4 characters long!', 'aarr');
            }

            if (strlen($content) < 4) {
                $errors[] = __('Recipe must be at least 4 characters long!', 'aarr');
            }

            if (empty($category_id)) {
                $errors[] = __('You must select a category!', 'aarr');
            }

            if (empty($_FILES['recipe_image']['name'])) {
                $errors[] = __('You must select an image!', 'aarr');
            } else {
                $uploaded_file = $_FILES['recipe_image'];

                $file_type = wp_check_filetype_and_ext(
                    $uploaded_file['tmp_name'],
                    $uploaded_file['name']
                );

                $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($file_type['ext'], $valid_extensions)) {
                    $errors[] = __('Invalid image type!', 'aarr');
                }
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

                $image_id = media_handle_upload('recipe_image', $recipe_id);

                if (!is_wp_error($image_id)) {
                    set_post_thumbnail($recipe_id, $image_id);
                } else {
                    wp_die($image_id->get_error_message());
                }

                $_SESSION['add_recipe_success'] =
                    __('Your recipe has been submitted. It will be reviewed and published soon.', 'aarr');
                wp_redirect(wp_get_referer());
                exit;
            } else {
                wp_die(__('Error submitting your recipe, try again later.', 'aarr'));
            }

        }
    }

    public function enqueue_scripts()
    {
        if (is_page('add-recipe')) {
            wp_enqueue_script(
                'jquery-validate',
                'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js',
                ['jquery'],
                '1.21.0',
                true
            );

            wp_enqueue_script(
                'recipe-validation',
                AARR_URL . 'assets/js/recipe-validation.js',
                ['jquery', 'jquery-validate'],
                '1.0.0',
                true
            );
        }

    }

}
