<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_Checkout
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_checkout'));
    }

    public function add_rest_api_checkout()
    {
        $namespace = 'ax/v1';
        $rout = '/checkout';

        register_rest_route($namespace, $rout, array(
            'methods' => 'POST',
            'callback' => array($this, 'checkout'),
            'args'     => array(
                'event_id' => array(
                    'type'     => 'number',
                    'required' => true,
                ),
                'count' => array(
                    'type'     => 'number',
                    'required' => true,
                ),
            ),
        ));
    }

    public function checkout($request)
    {
        $response = array(
            'event_id' => sanitize_text_field($request->get_param('event_id')),
            'count' => sanitize_text_field($request->get_param('count')),
        );

        $event_id = $response['event_id'];
        $count = $response['count'];
        $args = array(
            'include' => $event_id,
            'post_type' => 'events',
            'post_status' => array('publish')
        );

        $events = get_posts($args);
        $event = array();
        foreach ($events as $event) {
            $event_id = $event->ID;
            $price = get_post_meta($event_id, 'ax_price', true);
            $max_ticket =  get_post_meta($event_id, 'ax_max_tickets', true);
            $bought_tickets =  get_post_meta($event_id, 'ax_bought_tickets', true);
            $ticket_left = $max_ticket - $bought_tickets;
            $event = array(
                'title' => $event->post_title,
                'price' => $price,
                'ticket_left' => $ticket_left,
            );
        }

        return $event;
    }
}
