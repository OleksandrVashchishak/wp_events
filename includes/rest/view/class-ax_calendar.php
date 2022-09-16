<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_Calendar
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_calendar'));
    }

    public function add_rest_api_calendar()
    {
        $namespace = 'ax/v1';
        $id_point = '(?P<id>[0-9-]+)';
        $rout = '/calendar/' . $id_point;

        register_rest_route($namespace, $rout, array(
            'methods' => 'GET',
            'callback' => array($this, 'calendar'),
        ));
    }

    public function calendar()
    {
        $eventsResult = array();
        $args = array(
            'post_type' => 'events',
            'posts_per_page' => -1,
            'post_status' => array('publish')
        );

        $events = get_posts($args);
        foreach ($events as $event) {
            $event_id = $event->ID;
            $start_date = get_post_meta($event_id, 'ax_from_date', true);
            $end_date = get_post_meta($event_id, 'ax_to_date', true);
            $start_time = get_post_meta($event_id, 'ax_from_time', true);
            $end_time = get_post_meta($event_id, 'ax_to_time', true);
            $eventsObj = array(
                'id' => $event_id,
                'title' => $event->post_title . ' | ' . $start_time . ' - '. $end_time,
                'start' => $start_date,
                'end' => $end_date,
            );

            array_push($eventsResult, $eventsObj);
        }

        return $eventsResult;
    }
}
