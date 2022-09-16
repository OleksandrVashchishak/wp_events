<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Orders_Metabox
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('add_meta_boxes', array($this, 'orders_add_custom_box'));
        add_action('save_post_orders', array($this, 'orders_save_postdata'));
    }

    function orders_add_custom_box()
    {
        $screens = array('orders');
        add_meta_box('orders_sectionid', 'Order', array($this, 'orders_meta_box_callback'), $screens);
    }

    function orders_meta_box_callback($post)
    {
        $post_id = $post->ID;
        wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');
        $first_name = get_post_meta($post_id, 'ax_first_name', 1);
        $last_name = get_post_meta($post_id, 'ax_last_name', 1);
        $email = get_post_meta($post_id, 'ax_email', 1);
        $event_title = get_post_meta($post_id, 'ax_events_title', 1);
        $start_time = get_post_meta($post_id, 'ax_start_time', 1);
        $end_time = get_post_meta($post_id, 'ax_end_time', 1);
        $tickets_count = get_post_meta($post_id, 'ax_tickets_count', 1);
        $total = get_post_meta($post_id, 'ax_total', 1);
        $order_status = get_post_meta($post_id, 'ax_order_status', 1);
?>
        <div class="_ax_events">
            <h5 class="_ax_events-title">Status</h5>
            <div class="_ax_events-wrapper">
                <div class="_ax_events-box">
                    <label>Order status <?= $order_status ?> </label>
                    <select id="ax_order_status" name="ax_order_status" class="_ax_events-select">
                        <option <?= $order_status == 'pending' ? 'selected' : '' ?> value="pending">Pending</option>
                        <option <?= $order_status == 'paid' ? 'selected' : '' ?> value="paid">Paid</option>
                        <option <?= $order_status == 'canceled' ? 'selected' : '' ?> value="canceled">Canceled</option>
                    </select>
                </div>
            </div>

            <h5 class="_ax_events-title">Customer information</h5>
            <div class="_ax_events-wrapper">
                <div class="_ax_events-box">
                    <label>First name </label>
                    <input type="text" value="<?= $first_name ?>" readonly>
                </div>
                <div class="_ax_events-box">
                    <label>Last name</label>
                    <input type="text" value="<?= $last_name ?>" readonly>
                </div>
                <div class="_ax_events-box">
                    <label>Email</label>
                    <input type="text" value="<?= $email ?>" readonly>
                </div>
            </div>

            <h5 class="_ax_events-title">Event information</h5>
            <div class="_ax_events-wrapper">
                <div class="_ax_events-box">
                    <label>Event name</label>
                    <input type="text" value="<?= $event_title ?>" readonly>
                </div>
                <div class="_ax_events-box">
                    <label>Start time</label>
                    <input type="text" value="<?= $start_time ?>" readonly>
                </div>
                <div class="_ax_events-box">
                    <label>End time</label>
                    <input type="text" value="<?= $end_time ?>" readonly>
                </div>
            </div>

            <h5 class="_ax_events-title">Purchase information</h5>
            <div class="_ax_events-wrapper">
                <div class="_ax_events-box">
                    <label>Tickets purchased</label>
                    <input type="text" value="<?= $tickets_count ?>" readonly>
                </div>
                <div class="_ax_events-box">
                    <label>Total price</label>
                    <input type="text" value="$<?= $total ?>" readonly>
                </div>
            </div>
        </div>
<?php
    }

    function orders_save_postdata($post_id)
    {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $order_status = sanitize_text_field($_POST['ax_order_status']);
        if ($order_status == 'paid') {
            new Ax_Rest_Payment_Success($post_id);
        }
        if ($order_status == 'canceled') {
            // send message status canceled
        }

        update_post_meta($post_id, 'ax_order_status', $order_status);
    }
}
