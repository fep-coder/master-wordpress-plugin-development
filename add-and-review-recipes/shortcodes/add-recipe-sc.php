<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Add_Recipe_SC
{

    public function __construct()
    {
        add_shortcode('add_recipe', [$this, 'render_recipe_form']);
    }

    public function render_recipe_form()
    {
        ob_start();

        $post_data = isset($_SESSION['add_recipe_data']) ? $_SESSION['add_recipe_data'] : [];

        $title = isset($post_data['title']) ? esc_attr($post_data['title']) : '';
        $meal = isset($post_data['meal']) ? esc_attr($post_data['meal']) : '';
        $difficulty = isset($post_data['difficulty']) ? esc_attr($post_data['difficulty']) : '';
        $content = isset($post_data['content']) ? esc_attr($post_data['content']) : '';
        $post_cat_id = isset($post_data['category']) ? esc_attr($post_data['category']) : '';

        if (isset($_SESSION['add_recipe_data'])) {
            unset($_SESSION['add_recipe_data']);
        }

        if (isset($_SESSION['add_recipe_errors'])) {
            echo '<div class="error text-center w-100">';
            foreach ($_SESSION['add_recipe_errors'] as $error) {
                echo '<p>' . esc_html($error) . '</p>';
            }
            echo '</div>';
            unset($_SESSION['add_recipe_errors']);
        }

        $selected_categories = get_option('aarr_selected_categories');
        ?>

        <div class="col-8 mx-auto">
            <form method="post"
                    action="<?php echo admin_url('admin-post.php'); ?>"
                    enctype="multipart/form-data">

                <div class="mb-3">
                    <label>
                        <?php _e('Title', 'aarr');?>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo $title; ?>"
                        name="title" required autofocus>
                </div>

                <div class="mb-3">
                    <label>
                        <?php _e('Meal', 'aarr');?>
                    </label>
                    <select name="meal" class="form-control">
                        <?php $meal_field = get_field_object('field_66e3f412c7064');?>

                        <?php foreach ($meal_field['choices'] as $value): ?>
                            <option value="<?php echo $value ?>"
                            <?php selected($meal, $value);?>>
                                <?php echo $value ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>
                        <?php _e('Difficulty', 'aarr');?>
                    </label>
                    <select name="difficulty" class="form-control">
                        <?php $difficulty_field = get_field_object('field_66e3f4f8c7065');?>

                        <?php foreach ($difficulty_field['choices'] as $value): ?>
                            <option value="<?php echo $value ?>"
                            <?php selected($difficulty, $value);?>>
                                <?php echo $value ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>
                        <?php _e('Category', 'aarr');?>
                    </label>
                    <select name="category" class="form-control">
                        <option value=""><?php _e('Select a category', 'aarr');?></option>
                        <?php foreach ($selected_categories as $category_id): ?>
                            <?php $category = get_category($category_id);?>
                            <option value="<?php echo $category_id ?>"
                            <?php selected($post_cat_id, $category_id);?>>
                                <?php echo $category->name ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>

                <div class="mb-3">
                    <label><?php _e('Content', 'aarr');?></label>
                    <textarea name="content" class="form-control" rows="5" required><?php echo $content; ?></textarea>
                </div>

                <?php wp_nonce_field('recipe_submission', 'recipe_submission_nonce');?>

                <input type="hidden" name="action" value="submit_recipe">

                <input
                    type="submit"
                    class="btn btn-primary"
                    value="<?php _e('Submit Recipe', 'aarr')?>">

            </form>
        </div>

        <?php

        return ob_get_clean();
    }
}