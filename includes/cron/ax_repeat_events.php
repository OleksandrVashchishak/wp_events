<?php
if (!defined('ABSPATH')) {
    exit;
}

function ax_create_repeat_events_cron($events, $interval) {
    foreach ($events as $event) {

        //== start insert event ==//
        $args = array(
            'post_title'    => $event->post_title,
            'post_content'  => $event->post_content,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'events',
        );
        $new_event_id = wp_insert_post($args);
        //== end insert event ==//

        //== start update fields ==//
        $from_date = get_post_meta($event->ID, 'ax_from_date', 1);
        update_post_meta($new_event_id, 'ax_from_date', date('Y-m-d', strtotime($interval, strtotime($from_date))));
        update_post_meta($new_event_id, 'ax_time_start', strtotime($interval, strtotime($from_date)));
        $to_date = get_post_meta($event->ID, 'ax_to_date', 1);
        update_post_meta($new_event_id, 'ax_to_date', date('Y-m-d', strtotime($interval, strtotime($to_date))));
        update_post_meta($new_event_id, 'ax_time_end', strtotime($interval, strtotime($to_date)));
        $from_time = get_post_meta($event->ID, 'ax_from_time', 1);
        update_post_meta($new_event_id, 'ax_from_time', $from_time);
        $to_time = get_post_meta($event->ID, 'ax_to_time', 1);
        update_post_meta($new_event_id, 'ax_to_time', $to_time);
        $country = get_post_meta($event->ID, 'ax_country', 1);
        update_post_meta($new_event_id, 'ax_country', $country);
        $location = get_post_meta($event->ID, 'ax_location', 1);
        update_post_meta($new_event_id, 'ax_location', $location);
        $max_tickets = get_post_meta($event->ID, 'ax_max_tickets', 1);
        update_post_meta($new_event_id, 'ax_max_tickets', $max_tickets);
        $price = get_post_meta($event->ID, 'ax_price', 1);
        update_post_meta($new_event_id, 'ax_price', $price);
        $repeat = get_post_meta($event->ID, 'ax_repeat', 1);
        update_post_meta($new_event_id, 'ax_repeat', $repeat);
        update_post_meta($new_event_id, 'ax_bought_tickets', '0');
        //== end update fields ==//

        //== start update repeat status for current event ==//
        update_post_meta($event->ID, 'ax_repeat', 'none');
        //== end update repeat status for current event ==//
    }
}


add_action('ax_repeat_events_week', 'ax_get_repeat_events_week');
function ax_get_repeat_events_week()
{
    //== start get repeat events ==//
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => -1,
        'post_status' => array('publish'),
        'meta_query' => array(
            array(
                'key'     => 'ax_repeat',
                'value'   => 'week',
                'compare' => '=',
            ),

        ),
    );

    $events = get_posts($args);
    //== end get repeat events ==//
    if ($events) {
        ax_create_repeat_events_cron($events, "+7 day");
    }
}

add_action('ax_repeat_events_month', 'ax_get_repeat_events_month');
function ax_get_repeat_events_month()
{
    //== start get repeat events ==//
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => -1,
        'post_status' => array('publish'),
        'meta_query' => array(
            array(
                'key'     => 'ax_repeat',
                'value'   => 'month',
                'compare' => '=',
            ),

        ),
    );

    $events = get_posts($args);
    //== end get repeat events ==//
    if ($events) {
        ax_create_repeat_events_cron($events, "+30 day");
    }
}





