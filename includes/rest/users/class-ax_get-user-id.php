<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_Get_User_ID
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_get_user_id'));
    }

    public function add_rest_api_get_user_id()
    {
        $namespace = 'wm/v1';
        $rout = '/get_user_id';

        register_rest_route($namespace, $rout, array(
            'methods' => 'POST',
            'callback' => array($this, 'get_user_id'),
            'args'     => array(
                'email' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
            ),
        ));
    }

    public function get_user_id($request)
    {
        $response = array(
            'email' => sanitize_text_field($request->get_param('email')),
        );

        $email =  sanitize_text_field($response['email']);
        $user = get_user_by('email', $email);

        if ($user) {
            return $user->ID;
        } else {
            return 404;
        }
    }
}
