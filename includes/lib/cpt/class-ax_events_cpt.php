<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Events_Cpt
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('init', array($this, 'ax_register_events_cpt'));
    }

    public function ax_register_events_cpt()
    {
        register_taxonomy(
            'events-cat',
            array('events'),
            array(
                'labels' => array(
                    'name' => 'Category',
                    'singular_name' => 'Category',
                    'search_items' => 'Search Category',
                    'all_items' => 'All Category',
                    'edit_item' => 'Edit Category',
                    'update_item' => 'Update Category',
                    'add_new_item' => 'Add New Category',
                    'new_item_name' => 'New Category',
                    'menu_name' => 'Category'
                ),
                'hierarchical' => true,
                'rewrite' => array('slug' => 'events-cat'),
                'show_in_rest'          => true,
                'rest_base'             => 'events-cat',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
            )
        );

        register_post_type('events', [
            'labels' => [
                'name'               => 'Events',
                'singular_name'      => 'Event',
                'add_new'            => 'Add Events',
                'add_new_item'       => 'Add Events',
                'edit_item'          => 'Edit Events',
                'new_item'           => 'Add Events',
                'view_item'          => 'See Events',
                'search_items'       => 'Search Events',
                'not_found'          => 'Not found',
                'not_found_in_trash' => 'Not found',
                'menu_name'          => 'Events',
            ],
            'description'         => '',
            'public'              => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_rest'        => true,
            'rest_base'             => 'events',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'menu_position'       => 1,
            'menu_icon'           => 'dashicons-image-filter',
            'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
            'query_var'           => true,
            'taxonomies'  => array('events-cat'),
        ]);
    }
}
