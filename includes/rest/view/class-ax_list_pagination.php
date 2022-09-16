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
        $id_point = '(?P<id>[0-9-]+)';
        $rout = '/list_pagination/' . $id_point;

        register_rest_route($namespace, $rout, array(
            'methods' => 'GET',
            'callback' => array($this, 'list_pagination'),
        ));
    }

    public function list_pagination()
    {
        $args = array(
            'post_type' => 'events',
            'posts_per_page' => -1,
            'post_status' => array('publish'),
        );

        $events = get_posts($args);
        $pagination_count = ceil(count($events) / 4);
        $pagination = array();
        for ($i = 0; $i < $pagination_count; $i++) {
            array_push($pagination, $i + 1);
        }
        return $pagination;
    }
}
