<?php

/**
 * Plugin Name: AX Events
 * Version: 1.0.0
 * Description: AX Events
 * Author: Alex Vashch
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once 'includes/class-ax_events.php';

require_once 'includes/lib/fpdf/fpdf.php';

require_once 'includes/lib/pdf-generate/class_ax_pdf_generator.php';

require_once 'includes/lib/cpt/class-ax_events_cpt.php';
require_once 'includes/lib/cpt/class-ax_orders_cpt.php';
require_once 'includes/lib/metaboxes/class-ax_events_metabox.php';
require_once 'includes/lib/metaboxes/class-ax_orders_metabox.php';

require_once 'includes/emails/class-ax_email-to-admin.php';
require_once 'includes/emails/class-ax_email-to-user.php';

require_once 'includes/rest/view/class-ax_calendar.php';
require_once 'includes/rest/view/class-ax_list.php';
require_once 'includes/rest/view/class-ax_list_pagination.php';
require_once 'includes/rest/view/class-ax_single.php';

require_once 'includes/rest/checkout/class-ax_checkout.php';
require_once 'includes/rest/checkout/class-ax_send-invoice.php';
require_once 'includes/rest/checkout/class-ax_payment-success.php';

require_once 'includes/rest/users/class-ax_register-user.php';
require_once 'includes/rest/users/class-ax_get-user-id.php';
require_once 'includes/rest/users/class-ax_user-orders.php';
require_once 'includes/rest/users/class-ax_refund.php';

// require_once 'includes/cron/ax_add_cron_intervals.php';
// require_once 'includes/cron/ax_cron_control.php';
// require_once 'includes/cron/ax_repeat_events.php';


function ax_events()
{
    $instance = ax_events::instance(__FILE__, '1.0.0');
    return $instance;
}

ax_events();

register_activation_hook(__FILE__, 'on_activation_set_cron');
register_deactivation_hook(__FILE__,  'on_deactivation_remove_cron');