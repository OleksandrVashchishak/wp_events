<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_Send_Invoice
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_send_invoice'));
    }

    public function add_rest_api_send_invoice()
    {
        $namespace = 'ax/v1';
        $rout = '/send_invoice';

        register_rest_route($namespace, $rout, array(
            'methods' => 'POST',
            'callback' => array($this, 'send_invoice'),
            'args'     => array(
                'first_name' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'last_name' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'email' => array(
                    'type'     => 'string',
                    'required' => true,
                ),
                'tickets_count' => array(
                    'type'     => 'number',
                    'required' => true,
                ),
                'total' => array(
                    'type'     => 'number',
                    'required' => true,
                ),
                'event_id' => array(
                    'type'     => 'number',
                    'required' => true,
                ),

            ),
        ));
    }

    public function send_invoice($request)
    {
        $response = array(
            'first_name' => sanitize_text_field($request->get_param('first_name')),
            'last_name' => sanitize_text_field($request->get_param('last_name')),
            'email' => sanitize_text_field($request->get_param('email')),
            'tickets_count' => sanitize_text_field($request->get_param('tickets_count')),
            'total' => sanitize_text_field($request->get_param('total')),
            'event_id' => sanitize_text_field($request->get_param('event_id')),
        );
        $event_id = $response['event_id'];
        $tickets_count = $response['tickets_count'];
        $this->create_order($response);
        $this->hundler_ticket_left($event_id, $tickets_count);
        $this->send_emails($response);
        return 200;
    }

    private function create_order($data)
    {
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $email = $data['email'];
        $tickets_count = $data['tickets_count'];
        $total = $data['total'];

        $args = array(
            'post_title'    => 'Order | ' . $first_name . ' ' . $last_name,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'orders',
        );
        $order_id = wp_insert_post($args);

        update_post_meta($order_id, 'ax_first_name', $first_name,);
        update_post_meta($order_id, 'ax_last_name', $last_name,);
        update_post_meta($order_id, 'ax_email', $email,);
        update_post_meta($order_id, 'ax_tickets_count', $tickets_count,);
        update_post_meta($order_id, 'ax_total', $total,);
        update_post_meta($order_id, 'ax_order_status', 'pending');
    }

    private function hundler_ticket_left($event_id, $tickets_count)
    {
        $bought_tickets = get_post_meta($event_id, 'ax_bought_tickets', 1);
        $result = $bought_tickets + $tickets_count;
        update_post_meta($event_id, 'ax_bought_tickets', $result);
    }

    private function send_emails($data)
    {
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $email = $data['email'];
        $tickets_count = $data['tickets_count'];
        $total = $data['total'];
        
        $theme = 'Order Created!';
        $message_admin = $first_name . ' ' . $last_name . ' was sent invoice:, quantity ' . $tickets_count . ', price $' . $total . '. His email ' . $email;
        new Ax_Email_To_Admin($message_admin, $theme);

        $theme = 'Event Invoice';
        $message_user = 'Invoice for payment event xxxx xxxx xxxx xxxx. Event details: quantity ' . $tickets_count . ', price $' . $total . '. Thank you!';
        new Ax_Email_To_User($message_user, $theme, $email);
    }
}
