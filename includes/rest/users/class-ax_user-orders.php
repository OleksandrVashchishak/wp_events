<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_User_Orders
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_user_orders'));
    }

    public function add_rest_api_user_orders()
    {
        $namespace = 'ax/v1';
        $user_id = '(?P<user_id>[0-9-]+)';
        $rout = '/user_orders/' . $user_id;

        register_rest_route($namespace, $rout, array(
            'methods' => 'GET',
            'callback' => array($this, 'user_orders'),
        ));
    }

    public function user_orders($request)
    {
        $user_id = $request['user_id'];
        $ordersResult = array();

        $args = array(
            'post_type' => 'orders',
            'posts_per_page' => -1,
            'post_status' => array('publish'),
            'meta_query' => array(
                array(
                    'key'     => 'ax_customer_id',
                    'value'   => $user_id,
                    'compare' => '=',
                ),
              
            ),
        );

        $orders = get_posts($args);
        foreach ($orders as $order) {
            $order_id = $order->ID;
            $start_time = get_post_meta($order_id, 'ax_start_time', 1);
            $tickets_count = get_post_meta($order_id, 'ax_tickets_count', 1);
            $total = get_post_meta($order_id, 'ax_total', 1);
            $order_status = get_post_meta($order_id, 'ax_order_status', 1);
            $refund_status = get_post_meta($order_id, 'ax_refund_status', 1);

            $orderObj = array(
                'id' => $order_id,
                'title' => $order->post_title,
                'start' => $start_time,
                'tickets_count' => $tickets_count,
                'status' => $order_status,
                'refund' => $refund_status,
                'total' => $total,
            );

            array_push($ordersResult, $orderObj);
        }

        return $ordersResult;
    }
}
