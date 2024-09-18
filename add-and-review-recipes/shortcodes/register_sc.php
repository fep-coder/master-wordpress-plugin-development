<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Register_SC
{

    public function __construct()
    {
        add_shortcode('register', [$this, 'render_registration_form']);
    }

    public function render_registration_form()
    {

        ob_start();

        $post_data = isset($_SESSION['register_data']) ? $_SESSION['register_data'] : [];

        $username = isset($post_data['username']) ? esc_attr($post_data['username']) : '';
        $email = isset($post_data['email']) ? esc_attr($post_data['email']) : '';

        if (isset($_SESSION['register_data'])) {
            unset($_SESSION['register_data']);
        }

        if (isset($_SESSION['register_errors'])) {
            echo '<div class="error text-center w-100">';
            foreach ($_SESSION['register_errors'] as $error) {
                echo '<p>' . esc_html($error) . '</p>';
            }
            echo '</div>';
            unset($_SESSION['register_errors']);
        }

        if (isset($_SESSION['register_success'])) {
            echo '<p class="text-center w-100 text-success">'
                . $_SESSION['register_success'] . '</p>';
            ?>

            <p class="text-center w-100">
                <a href="/login" class="btn btn-info">Log in</a>
            </p>

            <?php

            unset($_SESSION['register_success']);
        } else {

            if (isset($_SESSION['register_error'])) {
                echo '<p class="text-center w-100 text-danger">'
                    . $_SESSION['register_error'] . '</p>';
                unset($_SESSION['register_error']);
            }

            if (isset($_SESSION['register_invalid'])) {
                echo '<p class="text-center w-100 text-danger">'
                    . $_SESSION['register_invalid'] . '</p>';
                unset($_SESSION['register_invalid']);
            }

            ?>

            <div class="col-8 mx-auto text-center">
                <form method="post">
                    <div class="mb-3">
                        <label for="username">
                            <?php _e('Username', 'aarr');?>
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            value="<?php echo $username; ?>"
                            name="username" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="email">
                            <?php _e('E-mail', 'aarr');?>
                        </label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            value="<?php echo $email; ?>"
                            name="email" required>
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

                    <?php wp_nonce_field('register_nonce', 'register_nonce');?>

                    <input
                        type="submit"
                        class="btn btn-primary"
                        name="register"
                        value="<?php _e('Register', 'aarr')?>">

                </form>
            </div>

        <?php

        }

        return ob_get_clean();
    }
}