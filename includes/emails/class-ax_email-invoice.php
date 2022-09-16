<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Email_Invoice
{
    private $email;
    private $message;
    private $theme;
    public function __construct($message, $theme, $email)
    {
        $this->email = $email;
        $this->message = $message;
        $this->theme = $theme;
        $this->init();
    }

    private function init()
    {
        $this->send_invoice();
    }

    private function send_invoice()
    {
        wp_mail(
            $this->email,
            $this->theme,
            $this->message,
            array(
                'From: Administrator <cars@cars.com>'
            )
        );
    }
}
