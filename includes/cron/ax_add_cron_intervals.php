<?php
if (!defined('ABSPATH')) {
    exit;
}

add_filter('cron_schedules',  'cron_add_five_min');
function cron_add_five_min($schedules)
{
    $schedules['five_min'] = array(
        'interval' => 60,
        'display' => 'One in 5 mins'
    );
    return $schedules;
}

add_filter('cron_schedules',  'cron_add_week');
function cron_add_week($schedules)
{
    $schedules['WEEK_IN_SECONDS'] = array(
        'interval' => 60 * 60 * 24 * 7,
        'display' => 'One in week'
    );
    return $schedules;
}

add_filter('cron_schedules',  'cron_add_month');
function cron_add_month($schedules)
{
    $schedules['MONTH_IN_SECONDS'] = array(
        'interval' => 60 * 60 * 24 * 7 * 4,
        'display' => 'One in month'
    );
    return $schedules;
}
