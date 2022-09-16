<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Rest_Payment_Success
{
    private $order_id;
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
        $this->init();
    }

    private function init()
    {
        $this->send_emails();
    }


    private function send_emails()
    {
        $first_name = get_post_meta($this->order_id, 'ax_first_name', 1);
        $last_name = get_post_meta($this->order_id, 'ax_last_name', 1);
        $email = get_post_meta($this->order_id, 'ax_email', 1);
        $tickets_count = get_post_meta($this->order_id, 'ax_tickets_count', 1);
        $total = get_post_meta($this->order_id, 'ax_total', 1);

        $theme = 'Payment success!';
        $message_admin = $first_name . ' ' . $last_name . ' bought an event, quantity ' . $tickets_count . ', price $' . $total . '. His email ' . $email;
        new Ax_Email_To_Admin($message_admin, $theme);

        $message_user = 'You success buy event, quantity ' . $tickets_count . ', price $' . $total . '. Thank you!';
        new Ax_Email_To_User($message_user, $theme, $email);
    }
}
