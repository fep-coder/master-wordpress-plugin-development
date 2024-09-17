<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Admin
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'register_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_admin_menu()
    {
        add_menu_page(
            __('Add And Review Recipes Settings', 'aarr'),
            __('Add And Review Recipes', 'aarr'),
            'manage_options',
            'add-and-review-recipes',
            [$this, 'settings_page'],
            'dashicons-menu',
        );
    }

    public function register_settings()
    {
        register_setting('aarr_options_group', 'aarr_selected_cpt');

        add_settings_section(
            'aarr_settings_section',
            __('Select Custom Post Type', 'aarr'),
            null,
            'add-and-review-recipes',
        );

        add_settings_field(
            'aarr_selected_cpt',
            __('Available Custom Post Types', 'aarr'),
            [$this, 'display_cpt_radio_buttons'],
            'add-and-review-recipes',
            'aarr_settings_section',
        );
    }

    public function settings_page()
    {
        ?>

        <div class="wrap">
            <h1><?php _e('Add And Review Recipes Settings', 'aarr');?></h1>

            <form action="options.php" method="post">
                <?php settings_fields('aarr_options_group');?>
                <?php do_settings_sections('add-and-review-recipes');?>
                <?php submit_button();?>
            </form>
        </div>

        <?php

    }

    public function display_cpt_radio_buttons()
    {
        $selected_cpt = get_option('aarr_selected_cpt');
        $post_types = get_post_types(['public' => true], 'objects');

        foreach ($post_types as $post_type) {
            ?>
            <label>
                <input type="radio"
                name="aarr_selected_cpt"
                value="<?php echo esc_attr($post_type->name); ?>"
                <?php checked($selected_cpt, $post_type->name);?>>
                <?php echo esc_html($post_type->label); ?>
            </label><br>
            <?php

        }
    }
}
