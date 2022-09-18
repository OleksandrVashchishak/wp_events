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


function ax_events()
{
    $instance = ax_events::instance(__FILE__, '1.0.0');
    return $instance;
}

ax_events();

