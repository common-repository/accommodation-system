<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('RoLang')){
        class RoLang{

            function __construct(){
            }

            public function ro_lang(){
                self::create_ro_table();
                self::add_ro_data();
            }

            private static function create_ro_table(){
                global $wpdb;
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

                $ro_lang = $wpdb->prefix . 'hotel_has_ro_lang';
                $sql = "CREATE TABLE IF NOT EXISTS $ro_lang (
                                `text_id` int(11) NOT NULL AUTO_INCREMENT,
                                `default` longtext COLLATE utf8_unicode_ci NOT NULL,
                                `description` longtext COLLATE utf8_unicode_ci NOT NULL,
                                PRIMARY KEY (`text_id`)
                              ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
                dbDelta($sql);
            }

            private static function add_ro_data(){
                global $wpdb;
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

                $ro_lang = $wpdb->prefix . 'hotel_has_ro_lang';
                $wpdb->get_results("SELECT * FROM $ro_lang");
                if ($wpdb->num_rows == 0){
                    $sql = "INSERT INTO $ro_lang (`text_id`, `default`, `description`) VALUES 
                               (1, 'Rooms', 'Camere'),
                               (2, 'Services', 'Servicii'),
                               (3, 'Amenities', 'Utilitati'),
                               (4, 'Room type', 'Tip camera'),
                               (5, 'Floors', 'Etaj'),
                               (6, 'Manage Room', 'Administreaza camera'),
                               (7, 'Filter', 'Filtru'),
                               (8, 'Room type - all', 'Tip camera - toate'),
                               (9, 'Floor - all', 'Etaj - toate');";

                    dbDelta($sql);
                }
            }

        }
    }