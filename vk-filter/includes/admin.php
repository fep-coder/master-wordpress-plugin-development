<?php

if (!defined('ABSPATH')) {
    exit;
}

class VKF_Admin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'register_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_admin_menu()
    {
        add_menu_page(
            'VK Filter Settings',
            'VK Filter',
            'manage_options',
            'vk-filter',
            [$this, 'settings_page']
        );
    }

    public function register_settings()
    {
        register_setting('vkf_options', 'vkf_categories');
    }

    public function settings_page()
    {
        ?>

        <div class="wrap">
            <h1>VK Filter Settings</h1>

            <form method="post" action="options.php">

        <?php
        settings_fields('vkf_options');
        ?>

        <h2>Select Categories</h2>
        
        <?php
        $categories = get_categories(['hide_empty' => false]);
        $selected_categories = get_option('vkf_categories', []);

        foreach ($categories as $category) {
            ?>

            <p>
                <label>
                    <input type="checkbox" 
                    name="vkf_categories[]" 
                    value="<?php echo esc_attr($category->name); ?>" 
                    <?php checked(in_array($category->name, $selected_categories)); ?>>
                    <?php echo esc_html($category->name); ?>
                </label>
            </p>

            <?php
        }

        submit_button(); 
        ?>

            </form>
        </div>

        <?php
    }
}
