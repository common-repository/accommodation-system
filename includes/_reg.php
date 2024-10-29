<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Reg')){

        final class Reg extends Controller{

            /**
             *
             * Constructor called when Reg final class instance is created.
             *
             */
            function __construct(){
                parent::__construct();
            }

            /**
             *
             * Initiate _POST, Ajax calls, Scripts & Translations
             *
             * call register() function from each Class
             *
             * function: register()
             *
             * variables: $enqueue (class instance)
             *
             *            $ajax (class instance)
             *
             *            $post (class instance)
             *
             *            $frontend (class instance)
             *
             *            $LANG (class instance)
             *
             */
            public static function initiate(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/controller/style-script.php';
                include $controller->plugin_path . 'includes/models/ajax-calls.php';
                include $controller->plugin_path . 'includes/models/_post.php';
                include $controller->plugin_path . 'includes/frontend/frontend.php';
                include $controller->plugin_path . 'includes/libraries/iCal/SG_ical.php';
                include $controller->plugin_path . 'includes/sync/sync.php';
                include $controller->plugin_path . 'includes/woocommerce/woocommerce.php';
                include $controller->plugin_path . 'includes/woocommerce/class.wcbk-cart.php';

                $enqueue        =   new StyleScript;
                $ajax           =   new AjaxCalls();
                $post           =   new Post();
                $frontend       =   new Frontend();
                $ical           =   new HASiCal();
                $sync           =   new MasterSync();
                $woocommerce    =   new HASWooCommerce();

                $enqueue        ->  register();
                $ajax           ->  register();
                $post           ->  register();
                $frontend       ->  register();
                $woocommerce    ->  register();
                $ical           ->  __construct();
                $sync           ->  sync();

                global $LANG;
                if (class_exists('Translation')){
                    $LANG = new Translation();
                }

                $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                $room_id = substr($url, -1);
                if (strpos($url,'ical_feed') !== false) {
                    $sync->generate_ical($room_id);
                    exit();
                }
            }

        }

    }