<?php 
if (!defined('ABSPATH')) {
    exit;
}

function on_activation_set_cron()
{
    wp_schedule_event(time(), 'WEEK_IN_SECONDS', 'ax_repeat_events_week');
    wp_schedule_event(time(), 'MONTH_IN_SECONDS', 'ax_repeat_events_month');
}

function on_deactivation_remove_cron()
{
    wp_clear_scheduled_hook('ax_repeat_events_week');
    wp_clear_scheduled_hook('ax_repeat_events_month');
}