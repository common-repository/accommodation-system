<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Translation')){
        class Translation{
            public $lang;

            function __construct(){
                $this->lang = $this->lang();
            }

            public function txt($string){
                global $wpdb;
                $table = $wpdb->prefix . 'hotel_has_' . $this->lang . '_lang';
                $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `default` = '$string'",
                                                   ARRAY_A);
                if (count($query_result)== 0){
                    return '! missing';
                }
                else {
                    foreach ($query_result as $row) {
                        return stripslashes($row['description']);
                    }
                }
            }

            public function txt_list(){
                global $wpdb;
                $table = $wpdb->prefix . 'hotel_has_' . $this->lang . '_lang';
                $query_result = $wpdb->get_results("SELECT * FROM $table",
                                                   ARRAY_A);

                return $query_result;
            }

            public function lang(){
                global $wpdb;
                $table = $wpdb->prefix . 'hotel_has_settings';
                $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `type` = 'lang'",
                                                   ARRAY_A);
                foreach ($query_result as $row){

                    return $row['description'];

                }
            }

        }
    }