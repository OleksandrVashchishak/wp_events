<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_List_Pagination
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_list_pagination'));
    }

    public function add_rest_api_list_pagination()
    {
        $namespace = 'ax/v1';
        $date = '(?P<date>[0-9-]+)';
        $search = '(?P<search>[a-zA-Z0-9-]+)';
        $location = '(?P<location>[a-zA-Z0-9-]+)';
        $rout = '/list_pagination/' . $date . '/' . $search . '/' . $location;

        register_rest_route($namespace, $rout, array(
            'methods' => 'GET',
            'callback' => array($this, 'list_pagination'),
        ));
    }

    public function list_pagination($request)
    {
        $date = strtotime($request['date']);
        $search = $request['search'];
        $location_filter = $request['location'];

        $args = array(
            'post_type' => 'events',
            'posts_per_page' => -1,
            'post_status' => array('publish'),
            'meta_query' => array(
                'event_start' => array(
                    'key' => 'ax_time_start',
                ),
                array(
                    'key'     => 'ax_time_start',
                    'value'   => $date,
                    'compare' => '>=',
                ),

            ),
        );

        if ($location_filter) {
            array_push($args['meta_query'],  array(
                'key' => 'ax_country',
                'value' => $location_filter,
                'compare' => "LIKE",
            ));
        }

        if ($search) {
            $args['s'] = $search;
        }

        $events = get_posts($args);
        $pagination_count = ceil(count($events) / 4);
        $pagination = array();
        for ($i = 0; $i < $pagination_count; $i++) {
            array_push($pagination, $i + 1);
        }
        return $pagination;
    }
}
