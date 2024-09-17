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

                <input
                    type="submit"
                    class="btn btn-primary"
                    name="register"
                    value="<?php _e('Register', 'aarr')?>">

            </form>
        </div>

        <?php

        return ob_get_clean();
    }
}