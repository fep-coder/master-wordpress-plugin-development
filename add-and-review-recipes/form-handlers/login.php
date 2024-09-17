<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Login
{

    public function __construct()
    {
        add_action('init', [$this, 'process_login']);
    }

    public function process_login()
    {
        if (isset($_POST['login'])) {
            $username = sanitize_user($_POST['username']);
            $password = $_POST['password'];

            $credentials = [
                'user_login' => $username,
                'user_password' => $password,
                'remember' => true,
            ];

            $user = wp_signon($credentials, true);

            if (is_wp_error($user)) {
                _e('Login failed', 'aarr');
            } else {
                wp_set_current_user($user->ID);
                wp_set_auth_cookie($user->ID, true);
                wp_redirect(home_url());

                exit;
            }
        }
    }

}
