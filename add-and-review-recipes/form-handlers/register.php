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
        if (isset($_POST['register'])) {
            $username = sanitize_user($_POST['username']);
            $email = sanitize_email($_POST['email']);
            $password = $_POST['password'];

            if (username_exists($username) || email_exists($email)) {
                _e('Username or E-mail already exists', 'aarr');
                return;
            }

            $user_id = wp_create_user($username, $password, $email);

            if (!is_wp_error($user_id)) {
                wp_update_user(['ID' => $user_id, 'role' => 'user']);

                _e('Registration succesfull', 'aarr');
            } else {
                _e('Registration failed', 'aarr');
            }
        }
    }

}
