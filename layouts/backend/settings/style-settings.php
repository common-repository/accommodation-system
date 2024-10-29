<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('StyleSettings')){
        class StyleSettings extends Settings{

            function __construct(){
                parent::__construct();
            }

            public static function style_settings_layout(){
                echo 'soon';
                include $controller->plugin_path . 'layouts/backend/header/modal.php';
            }

        }
    }