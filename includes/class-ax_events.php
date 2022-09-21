<?php
class ax_events
{
    private static $_instance = null;
    public $_version;
    public $_token;
    public $file;
    public $dir;
    public $assets_dir;
    public $assets_url;
    public $script_suffix;

    public function __construct($file = '', $version = '1.0.0')
    {
        global $wpdb;
        $this->_version = $version;
        $this->_token   = 'ax_events';
        $this->file       = $file;
        $this->dir        = dirname($this->file);
        $this->assets_dir = trailingslashit($this->dir) . 'assets';
        $this->assets_url = esc_url(trailingslashit(plugins_url('/assets/', $this->file)));
        $this->init();
    }

    public function init()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'), 10);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 10);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'), 10, 1);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 10, 1);
        
        $this->register_cpt();
        $this->init_rest_api();
    }

    public function init_rest_api()
    {
        //== START VIEW COMPONENTS ==//
        new Ax_Rest_Calendar();
        new Ax_Rest_List();
        new Ax_Rest_List_Pagination();
        new Ax_Rest_Single();

        //== START CHECKOUT COMPONTS ==//
        new Ax_Rest_Checkout();
        new Ax_Rest_Send_Invoice();

        //== START USER COMPONENTS ==//
        new Ax_Rest_Register_User();
        new Ax_Rest_Get_User_ID();
        new Ax_Rest_User_Orders();
        new Ax_Rest_Refund();

        //== CREATE PDF ==//
        new AX_Ajax_Create_Pdf();
    }

    public function register_cpt()
    {
        //== START CPT REGISTER ==//
        new Ax_Events_Cpt();
        new Ax_Orders_Cpt();

        //== START AD METABOXES ==//
        new Ax_Events_Metabox();
        new Ax_Orders_Metabox();
    }

    public function enqueue_styles()
    {
        wp_register_style($this->_token . '-datepicker', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', array(), $this->_version);
        wp_enqueue_style($this->_token . '-datepicker');

        wp_register_style($this->_token . '-admin_ax', esc_url($this->assets_url) . 'css/_admin.css', array(), $this->_version);
        wp_enqueue_style($this->_token . '-admin_ax');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->_token .  'jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), null, true);
        wp_enqueue_script($this->_token .  'datepicker-script', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array(), null, true);

        wp_register_script($this->_token . '-admin_ax', esc_url($this->assets_url) . 'js/_admin.js', array('jquery'), $this->_version, true);
        wp_enqueue_script($this->_token . '-admin_ax');
    }

    public static function instance($file = '', $version = '1.0.0')
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($file, $version);
        }

        return self::$_instance;
    }
}
