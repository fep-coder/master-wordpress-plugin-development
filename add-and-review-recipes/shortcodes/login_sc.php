<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Login_SC
{

    public function __construct()
    {
        add_shortcode('login', [$this, 'render_login_form']);
    }

    public function render_login_form()
    {
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            if (in_array('user', (array) $current_user->roles)) {
                return '<p class="text-center w-100">'
                . __('You are logged in as a user.', 'aarr') . '</p>';
            } else {
                return '<p class="text-center w-100">'
                . __('You are logged in , but not as a user.', 'aarr') . '</p>';
            }
        } else {

            ob_start();
            ?>

            <div class="col-6 mx-auto text-center">
                <form method="post" id="login-form">
                    <div class="mb-3">
                        <label for="username">
                            <?php _e('Username', 'aarr');?>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password">
                            <?php _e('Password', 'aarr');?>
                        </label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password" required>
                    </div>

                    <?php wp_nonce_field('login_nonce', 'login_nonce');?>

                    <input
                        type="submit"
                        class="btn btn-primary"
                        name="login"
                        value="<?php _e('Log in', 'aarr')?>">

                </form>
            </div>

            <?php

            return ob_get_clean();
        }
    }

}