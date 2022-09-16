<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Email_To_Admin
{
    private $message;
    private $theme;
    public function __construct($message, $theme)
    {
        $this->message = $message;
        $this->theme = $theme;
        $this->init();
    }

    private function init()
    {
        $this->send_email();
    }

    private function send_email()
    {
        wp_mail(
            'q121312q@gmail.com',
            $this->theme,
            $this->message,
            array(
                'From: Administrator <cars@cars.com>'
            )
        );
    }
}
