<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Post')){
        class Post extends Controller{

            /**
             *
             *  Constructor called when Post class instance is created.
             *
             */
            function __construct(){
                parent::__construct();
            }

            /**
             *
             *  Wordpress form submission post function
             *
             *  parameter: task
             *
             */
            public function register(){
                add_action('admin_post_has', array($this, 'task'));
                add_action('admin_post_nopriv_has', array($this, 'task'));
            }

            /**
             *
             *  Verify task parameter and call method
             *
             *  Only if nonce values submitted with post calls are verified, those db query functions will be executed
             *
             *  variable: $controller (class instance)
             *
             *            $method (class instance)
             *
             *            $nonce (string)
             *
             *            $task (string)
             *
             *            $nonce_verify (boolean)
             *
             */
            public function task(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                $nonce = sanitize_text_field($_POST['nonce']);
                $task = sanitize_text_field($_POST['task']);
                $nonce_verify = wp_verify_nonce($nonce, 'has-hotel-booking');

                if ($nonce_verify == true){
                    $task == 'create_booking_publicly'
                            ? $method->has_create_booking_publicly()
                            : false;
                    $task == 'create_booking_stripe_payment'
                            ? $method->has_create_booking_stripe_payment()
                            : false;
                    $task == 'create_booking_paypal_payment'
                            ? $method->has_create_booking_paypal_payment()
                            : false;
                    $task == 'create_booking'
                            ? $method->has_booking_create()
                            : false;
                    $task == 'cash_payment'
                            ? $method->send_emails_cash_payment()
                            : false;
                    $task == 'edit_booking'
                            ? $method->has_booking_edit()
                            : false;
                    $task == 'delete_booking'
                            ? $method->has_booking_delete()
                            : false;
                    $task == 'take_payment'
                            ? $method->has_take_payment()
                            : false;
                    $task == 'create_room'
                            ? $method->has_room_create()
                            : false;
                    $task == 'edit_room'
                            ? $method->has_room_edit()
                            : false;
                    $task == 'room_delete'
                            ? $method->has_room_delete()
                            : false;
                    $task == 'create_pricing'
                            ? $method->has_pricing_create()
                            : false;
                    $task == 'delete_pricing'
                            ? $method->has_pricing_delete()
                            : false;
                    $task == 'create_room_type'
                            ? $method->has_room_type_create()
                            : false;
                    $task == 'edit_room_type'
                            ? $method->has_room_type_edit()
                            : false;
                    $task == 'room_type_delete'
                            ? $method->has_room_type_delete()
                            : false;
                    $task == 'create_floor'
                            ? $method->has_floor_create()
                            : false;
                    $task == 'edit_floor'
                            ? $method->has_floor_edit()
                            : false;
                    $task == 'floor_delete'
                            ? $method->has_floor_delete()
                            : false;
                    $task == 'create_amenity'
                            ? $method->has_amenity_create()
                            : false;
                    $task == 'edit_amenity'
                            ? $method->has_amenity_edit()
                            : false;
                    $task == 'amenities_delete'
                            ? $method->has_amenity_delete()
                            : false;
                    $task == 'create_service'
                            ? $method->has_service_create()
                            : false;
                    $task == 'edit_service'
                            ? $method->has_service_edit()
                            : false;
                    $task == 'services_delete'
                            ? $method->has_service_delete()
                            : false;
                    $task == 'save_general_settings'
                            ? $method->has_save_general_settings()
                            : false;
                    $task == 'save_payment_settings'
                            ? $method->has_save_payment_settings()
                            : false;
                    $task == 'save_sync_data'
                            ? $method->has_save_sync_data()
                            : false;
                    $task == 'save_translate'
                            ? $method->has_save_translate()
                            : false;

                    if ($task == 'update_product'){
                    //TODO    self::update_plugin();
                        return false;
                    }
                }
                return false;
            }


        }
    }