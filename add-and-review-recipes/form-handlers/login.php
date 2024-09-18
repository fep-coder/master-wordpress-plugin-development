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
        if (isset($_POST['login'])
            && isset($_POST['login_nonce'])
            && wp_verify_nonce($_POST['login_nonce'], 'login_nonce')) {

            $username = sanitize_user($_POST['username']);
            $password = $_POST['password'];

            $errors = [];

            if (strlen($username) < 3) {
                $errors[] = __('Username must be at least 3 characters long!', 'aarr');
            }

            if (strlen($password) < 4) {
                $errors[] = __('Password must be at least 4 characters long!', 'aarr');
            }

            if (!empty($errors)) {
                $_SESSION['login_username'] = $username;
                $_SESSION['login_errors'] = $errors;
                wp_redirect(wp_get_referer());
                return;
            }

            $credentials = [
                'user_login' => $username,
                'user_password' => $password,
                'remember' => true,
            ];

            $user = wp_signon($credentials, true);

            if (is_wp_error($user)) {
                $_SESSION['login_failed'] = __('Invalid username or password', 'aarr');
                wp_redirect(wp_get_referer());
            } else {
                wp_set_current_user($user->ID);
                wp_set_auth_cookie($user->ID, true);
                wp_redirect(home_url());

                exit;
            }
        }
    }

}
