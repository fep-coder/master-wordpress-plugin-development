<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class VKPS_Admin
{
    public function __construct()
    {
        add_action('admin_menu', [self::class, 'add_admin_menu']);
        add_action('admin_init', [self::class, 'register_settings']);
    }

    public static function add_admin_menu()
    {
        add_options_page(
            'VK Post Slider',
            'VK Post Slider',
            'manage_options',
            'vk-post-slider',
            [self::class, 'create_admin_page']
        );
    }

    public static function register_settings()
    {
        register_setting('vk_post_slider_settings', 'vk_post_ids');

        add_settings_section(
            'vk_post_slider_section',
            'VK Post Slider Settings',
            null,
            'vk-post-slider'
        );

        add_settings_field(
            'vk_post_ids',
            'Post IDs',
            [self::class, 'post_ids_callback'],
            'vk-post-slider',
            'vk_post_slider_section'
        );
    }

    public static function create_admin_page()
    {
        ?>
        <h1>VK Post Slider Settings</h1>

        <form action="options.php" method="post">
            <?php

        settings_fields('vk_post_slider_settings');
        do_settings_sections('vk-post-slider');
        submit_button();
        ?>
        </form>
        <?php

    }

    public static function post_ids_callback()
    {
        $vk_post_ids = get_option('vk_post_ids');
        ?>

        <input type="text"
        class="regular-text"
        name="vk_post_ids"
        value="<?php echo esc_attr($vk_post_ids); ?>">
        <p class="description">Enter post IDs separated by commas</p>
        <?php

    }

}
