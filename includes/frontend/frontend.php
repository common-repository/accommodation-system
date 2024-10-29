<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Frontend')){

        class Frontend extends Controller{
            /**
             *
             *  Constructor called when Frontend class instance is created.
             *
             */
            function __construct(){
                parent::__construct();
            }

            /**
             *
             *  Method for registering plugin shortcode
             *
             */
            public function register(){
                if (!is_admin()){
                    add_shortcode('hotel_accommodation_system', array($this, 'hotel_accommodation_system_shortcode'));
                }
                else{
                    return false;
                }
                return true;
            }

            /**
             *
             *  Method for creating plugin shortcode
             *
             *  variable: $controller (class instance)
             *
             *            $booking_form (class instance)
             *
             * function: booking_form() return layouts/frontend/booking-form.php
             *
             */
            public function hotel_accommodation_system_shortcode(){
                ob_start();
                $controller = new Controller();
                include $controller->plugin_path . 'layouts/frontend/booking-form.php';
                $booking_form = new BookingForm();
                $booking_form->booking_form();
                return ob_get_clean();
            }

        }
    }
    