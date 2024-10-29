<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Controller')){

        class Controller{

            /**
             *
             *  Define public variables used by Controller
             *
             *  variables: $plugin_path
             *
             *             $plugin_url
             *
             *             $plugin
             *
             */
            public $plugin_path;
            public $plugin_url;
            public $plugin;
            public static $text_domain = 'accommodation-system';

            /**
             *
             *  Constructor called when Controller class instance is created.
             *
             */
            public function __construct(){
                $this->plugin_path  = plugin_dir_path(dirname(dirname(__FILE__)));
                $this->plugin_url   = plugin_dir_url(dirname(dirname(__FILE__)));
                $this->plugin       = plugin_basename(dirname(dirname(dirname(__FILE__)))) . '/accommodation-system.php';
            }
        }
    }



