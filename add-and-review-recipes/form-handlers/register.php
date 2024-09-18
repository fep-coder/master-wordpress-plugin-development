<?php

// Prevent direct access to file
if (!defined('ABSPATH')) {
    exit;
}

class AARR_Register
{

    public function __construct()
    {
        add_action('init', [$this, 'process_registration']);
    }

    public function process_registration()
    {
        if (isset($_POST['register'])
            && isset($_POST['register_nonce'])
            && wp_verify_nonce($_POST['register_nonce'], 'register_nonce')) {

            $username = sanitize_user($_POST['username']);
            $email = sanitize_email($_POST['email']);
            $password = $_POST['password'];

            $errors = [];

            if (strlen($username) < 3) {
                $errors[] = __('Username must be at least 4 characters long!', 'aarr');
            }

            if (strlen($email) < 6) {
                $errors[] = __('E-mail must be at least 6 characters long!', 'aarr');
            }

            if (strlen($password) < 4) {
                $errors[] = __('Password must be at least 4 characters long!', 'aarr');
            }

            if (!empty($errors)) {
                $_SESSION['register_data'] = $_POST;
                $_SESSION['register_errors'] = $errors;
                wp_redirect(wp_get_referer());
                return;
            }

            if (username_exists($username) || email_exists($email)) {
                $_SESSION['register_invalid'] =
                    __('Username or E-mail already exists!', 'aarr');
                return;
            }

            $user_id = wp_create_user($username, $password, $email);

            if (!is_wp_error($user_id)) {
                // wp_update_user(['ID' => $user_id, 'role' => 'user']);

                $user = new WP_User($user_id);
                $user->set_role('user');

                $_SESSION['register_success'] = __('Registration succesfull!', 'aarr');
            } else {
                $_SESSION['register_error'] = __('Registration failed!', 'aarr');
            }
        }
    }

}
