<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_List
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('rest_api_init', array($this, 'add_rest_api_list'));
    }

    public function add_rest_api_list()
    {
        $namespace = 'ax/v1';
        $page = '(?P<page>[0-9-]+)';
        $date = '(?P<date>[0-9-]+)';
        $rout = '/list/' . $page . '/' . $date;

        register_rest_route($namespace, $rout, array(
            'methods' => 'GET',
            'callback' => array($this, 'list'),
        ));
    }

    public function list($request)
    {
        $page = $request['page'];
        $date = strtotime($request['date']);
        $eventsResult = array();
        $args = array(
            'post_type' => 'events',
            'posts_per_page' => 4,
            'post_status' => array('publish'),
            'paged' => $page,
            'meta_query' => array(
                'event_start' => array(
                    'key' => 'ax_time_start',
                ),
                array(
                    'key'     => 'ax_time_start',
                    'value'   => $date,
                    'compare' => '>=',
                ),
                //     array(
                //         'relation' => 'AND',
                //         array(
                //                 'key'     => 'ax_time_start',
                //                 'value'   => $date,
                //                 'compare' => '>=',
                //         ),
                //         array(
                //                 'key'     => 'ax_time_end',
                //                 'value'   => '$date',
                //                 'compare' => '<=',
                //         ),
                // ),
            ),
            'orderby' => 'event_start',
            'order' => 'ASC',
        );

        $events = get_posts($args);
        foreach ($events as $event) {
            $event_id = $event->ID;
            $start_date = get_post_meta($event_id, 'ax_from_date', true);
            $end_date = get_post_meta($event_id, 'ax_to_date', true);
            $start_time = get_post_meta($event_id, 'ax_from_time', true);
            $end_time = get_post_meta($event_id, 'ax_to_time', true);
            $location = get_post_meta($event_id, 'ax_location', true);
            $country = get_post_meta($event_id, 'ax_country', true);
            $price = get_post_meta($event_id, 'ax_price', true);
            $thumbnail = get_the_post_thumbnail_url($event_id);
            $content = wp_trim_words($event->post_content, 50, '[...]');
           $cats = get_the_terms( $event, 'events-cat' );
            $eventsObj = array(
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
                'cats' => $cats,
            );

            array_push($eventsResult, $eventsObj);
        }


        return $eventsResult;
    }
}
