<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_Single
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_single'));
    }

    public function add_rest_api_single()
    {
        $namespace = 'ax/v1';
        $id_point = '(?P<id>[0-9-]+)';
        $rout = '/single/' . $id_point;

        register_rest_route($namespace, $rout, array(
            'methods' => 'GET',
            'callback' => array($this, 'single'),
        ));
    }

    public function single($request)
    {
        $id = $request['id'];
        $args = array(
            'include' => $id,
            'post_type' => 'events',
            'post_status' => array('publish')
        );

        $events = get_posts($args);
        $event = array();
        foreach ($events as $event) {
            $event_id = $event->ID;
            $start_date = get_post_meta($event_id, 'ax_from_date', true);
            $end_date = get_post_meta($event_id, 'ax_to_date', true);
            $start_time = get_post_meta($event_id, 'ax_from_time', true);
            $end_time = get_post_meta($event_id, 'ax_to_time', true);
            $location = get_post_meta($event_id, 'ax_location', true);
            $country = get_post_meta($event_id, 'ax_country', true);
            $price = get_post_meta($event_id, 'ax_price', true);
            $bought_tickets =  get_post_meta($event_id, 'ax_bought_tickets', true);
            $max_ticket =  get_post_meta($event_id, 'ax_max_tickets', true);
            $thumbnail = get_the_post_thumbnail_url($event_id);
            $content = $event->post_content;
            $ticket_left = $max_ticket - $bought_tickets;
            $cats = get_the_terms( $event, 'events-cat' );
            $event = array(
                'id' => $event_id,
                'title' => $event->post_title,
                'start_date' => date('d F',strtotime($start_date)),
                'end_date' => date('d F',strtotime($end_date)),
                'start_time' => $start_time,
                'end_time' => $end_time,
                'content' => $content,
                'country' => $country,
                'location' => $location,
                'price' => $price,
                'thumbnail' => $thumbnail,
                'ticket_left' => $ticket_left,
                'max_ticket' => $max_ticket,
                'cats' => $cats,
            );
        }


        return $event;
    }
}
