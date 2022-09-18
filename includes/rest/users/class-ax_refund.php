<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_Refund
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_refund'));
    }

    public function add_rest_api_refund()
    {
        $namespace = 'ax/v1';
        $order_id = '(?P<order_id>[0-9-]+)';
        $rout = '/refund/' . $order_id;

        register_rest_route($namespace, $rout, array(
            'methods' => 'GET',
            'callback' => array($this, 'refund'),
        ));
    }

    public function refund($request)
    {
        $order_id = $request['order_id'];
        update_post_meta($order_id, 'ax_refund_status', 'processing');

        $email = get_post_meta($order_id, 'ax_email', 1);
        $theme = 'User request refund!';
        $message_admin = $order_id . ' was requst refund money. Customer email ' . $email;
        new Ax_Email_To_Admin($message_admin, $theme);


        return 200;
    }
}
