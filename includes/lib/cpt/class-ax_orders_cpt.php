<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Orders_Cpt
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('init', array($this, 'ax_register_orders_cpt'));
    }

    public function ax_register_orders_cpt()
    {
    

        register_post_type('orders', [
            'labels' => [
                'name'               => 'Orders',
                'singular_name'      => 'Event',
                'add_new'            => 'Add Orders',
                'add_new_item'       => 'Add Orders',
                'edit_item'          => 'Edit Orders',
                'new_item'           => 'Add Orders',
                'view_item'          => 'See Orders',
                'search_items'       => 'Search Orders',
                'not_found'          => 'Not found',
                'not_found_in_trash' => 'Not found',
                'menu_name'          => 'Orders',
            ],
            'description'         => '',
            'public'              => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_rest'        => true,
            'rest_base'             => 'orders',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'menu_position'       => 1,
            'menu_icon'           => 'dashicons-editor-ol',
            'supports'            => ['title'],
            'query_var'           => true,
        ]);
    }
}
