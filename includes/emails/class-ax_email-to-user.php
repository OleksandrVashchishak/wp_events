<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Email_To_User
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
        $this->send_email();
    }

    private function send_email()
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
