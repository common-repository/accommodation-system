<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/
    if (!class_exists('StyleScript')){

        class StyleScript extends Controller{

            /**
             * 
             *  Constructor called when StyleScript class instance is created.
             *
             */
            function __construct(){
                parent::__construct();
            }

            /**
             * 
             *  Method for registering admin script enqueue hook to this plugin
             * 
             *  parameter: function enqueue()
             *
             *             function enqueue_frontend()
             *
             */
            public function register(){
                add_action('admin_enqueue_scripts', array($this, 'enqueue'));
                add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend'));
            }

            /**
             *
             *  Method for registering admin script enqueue hook to this plugin
             *
             *  parameter: $hook
             *
             *             $current_page
             *
             * function: enqueue_styles()
             *
             *           enqueue_scripts()
             *
             *  Hooking up the js & css files to current plugin pages only
             * @param $hook
             */
            function enqueue($hook){
                $current_page = get_current_screen()->base;
                if ($hook == $current_page){
                    $this->enqueue_styles();
                    $this->enqueue_scripts();
                }
            }

            /**
             * 
             *  Method for registering frontend script enqueue hook to this plugin
             *
             * parameter:
             *
             * function: enqueue_styles_frontend()
             *
             *           enqueue_scripts_frontend()
             *
             *  Hooking up the js & css files to frontend
             * 
             */
            function enqueue_frontend(){
                $this->enqueue_styles_frontend();
                $this->enqueue_scripts_frontend();
            }

            /**
             *
             *  Method for enqueueing stylesheets (backend)
             *
             */
            private function enqueue_styles(){
                wp_enqueue_style('bootstrap-css',       $this->plugin_url . 'assets/css/bootstrap.css');
                wp_enqueue_style('settings-css',        $this->plugin_url . 'assets/css/backend/settings/settings.css');
    //            wp_enqueue_style('font-awesome',        $this->plugin_url . 'assets/css/backend/icons/font-awesome.css');
    //            wp_enqueue_style('flaticon',            $this->plugin_url . 'assets/css/backend/icons/flaticon.css');
                wp_enqueue_style('jquery-ui',           $this->plugin_url . 'assets/css/backend/jquery-ui.css');
                wp_enqueue_style('daterangepicker-css', $this->plugin_url . 'assets/css/backend/daterangepicker.css');
                wp_enqueue_style('general',             $this->plugin_url . 'assets/css/backend/general.css');
                wp_enqueue_style('general.min',         $this->plugin_url . 'assets/css/backend/general.min.css');
                wp_enqueue_style('year-calendar',       $this->plugin_url . 'assets/css/backend/calendar/bootstrap-year-calendar.css');
                wp_enqueue_style('icheck-square',       $this->plugin_url . 'assets/css/backend/icheck/square/orange.css');
                wp_enqueue_style('icheck-line',         $this->plugin_url . 'assets/css/backend/icheck/line/orange.css');
            }

            /**
             *
             *  Method for enqueueing javascripts (backend)
             *
             */
            private function enqueue_scripts(){
                wp_enqueue_media();
                wp_enqueue_script('bootstrap.min',      $this->plugin_url . 'assets/js/backend/bootstrap.min.js', array('jquery'));
                wp_enqueue_script('jquery-form-js',     $this->plugin_url . 'assets/js/backend/jquery.form.js', array('jquery'));
                wp_enqueue_script('toastr-js',          $this->plugin_url . 'assets/js/backend/jquery.toaster.js', array('jquery'));
                wp_enqueue_script('daterangepicker-js', $this->plugin_url . 'assets/js/backend/daterangepicker.js', array('jquery'));
                wp_enqueue_script('moment.min',         $this->plugin_url . 'assets/js/backend/moment.min.js');
                wp_enqueue_script('blockui-js',         $this->plugin_url . 'assets/js/backend/blockui.js', array('jquery'));
                wp_enqueue_script('jquery-ui-datepicker');
                wp_enqueue_script('general-js',         $this->plugin_url . 'assets/js/backend/general.js', array('jquery'));
                wp_enqueue_script('icheck',             $this->plugin_url . 'assets/js/backend/icheck.js', array('jquery'));
                wp_enqueue_script('year-calendar',      $this->plugin_url . 'assets/js/backend/calendar/bootstrap-year-calendar.js', array('jquery'));

            }

            /**
             *
             *  Method for enqueueing stylesheets in frontend
             *
             */
            private function enqueue_styles_frontend(){
                wp_enqueue_style('style',       $this->plugin_url . 'assets/css/frontend/style.css');
                wp_enqueue_style('fontawesome', $this->plugin_url . 'assets/css/frontend/fonts/font-awesome.min.css');
                wp_enqueue_style('datepicker',  $this->plugin_url . 'assets/css/frontend/jquery/jquery-ui.css');
                wp_enqueue_style('flaticon',    $this->plugin_url . 'assets/css/backend/icons/flaticon.css');
            }

            /**
             *
             *  Method for enqueueing javascripts
             *
             */
            private function enqueue_scripts_frontend(){
                wp_enqueue_script('paypal',                 'https://www.paypalobjects.com/api/checkout.js');
                wp_enqueue_script('stripe',                 'https://js.stripe.com/v3/');
                wp_enqueue_script('stripe-checkout',        'https://checkout.stripe.com/checkout.js');
                wp_enqueue_script('jquery-ui-datepicker');
                wp_enqueue_script('ajax-form',              $this->plugin_url . 'assets/js/frontend/jquery.form.js', array('jquery'));
                wp_enqueue_script('popper',                 $this->plugin_url . 'assets/js/frontend/js/popper.min.js', array('jquery'));
                wp_enqueue_script('bs-js',                  $this->plugin_url . 'assets/js/frontend/js/bootstrap.min.js', array('jquery'));
                wp_enqueue_script('sticky',                 $this->plugin_url . 'assets/js/frontend/js/sticky.min.js', array('jquery'));
                wp_enqueue_script('main',                   $this->plugin_url . 'assets/js/frontend/js/main.js', array('jquery'));
            }

        }
    }
