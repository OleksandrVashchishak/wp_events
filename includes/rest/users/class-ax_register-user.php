<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_Register_User
{

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'rest_api_register_user'));
    }

    public function rest_api_register_user()
    {
        $namespace = 'wm/v1';
        $rout = '/register_user';

        register_rest_route($namespace, $rout, array(
            'methods' => 'POST',
            'callback' => array($this, 'register_user'),
            'args'     => array(
                'username' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'email' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'password' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
            ),
        ));
    }

    public function register_user($request)
    {
        $response = array(
            'username' => sanitize_text_field($request->get_param('username')),
            'email' => sanitize_text_field($request->get_param('email')),
            'password' => sanitize_text_field($request->get_param('password')),
        );

        $username = sanitize_text_field($response['username']);
        $email =  sanitize_text_field($response['email']);
        $password = sanitize_text_field($response['password']);
        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            return $user_id->get_error_message();
        } else {
            return $user_id;
        }
    }
}
