<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

if (!class_exists('Methods')) {

    class Methods extends Controller
    {

        function __construct()
        {
            parent::__construct();
        }


        /**
         *
         * Method to make payment using PayPal payment gateway
         *
         */
        public static function has_create_booking_paypal_payment()
        {
            $amount = sanitize_text_field($_POST['amount']);
            $booking_id = sanitize_text_field($_POST['booking_id']);

            $data['method']     =   'paypal';
            $data['amount']     =   $amount;
            $data['booking_id'] =   $booking_id;
            $data['timestamp']  =   strtotime(date("d M, Y"));
            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_payment', $data);

            $data2['status']      =      '2';
            $wpdb->update($wpdb->prefix . 'hotel_has_booking', $data2, array('booking_id' => $booking_id));

            if (self::has_get_settings('admin_notification')=='yes') {
                self::send_admin_email($booking_id);
            }
            if (self::has_get_settings('customer_notification')=='yes') {
                self::send_customer_email($booking_id);
            }
            return false;
        }

        /**
         *
         * Method to make payment using Stripe payment gateway
         *
         * @throws \Stripe\Exception\ApiErrorException
         */
        public static function has_create_booking_stripe_payment()
        {
            //require_once('stripe/init.php');
            /** Take values from the submitted form */
            $token      =   sanitize_text_field($_POST['stripe_token']);
            $amount     =   sanitize_text_field($_POST['amount']);
            $booking_id =   sanitize_text_field($_POST['booking_id']);

            /**
             *
             * Get stripe keys from settings
             *
             * get the stripe settings from database
             *
             */
            $stripe_settings_json   =   self::has_get_settings('stripe');
            $stripe_settings_array  =   json_decode($stripe_settings_json);
            $stripe_test_mode       =   $stripe_settings_array[0]->testmode;
            $stripe_secret_test_key =   $stripe_settings_array[0]->secret_test_key;
            $stripe_secret_live_key =   $stripe_settings_array[0]->secret_live_key;
            $stripe_currency        =   $stripe_settings_array[0]->currency;

            if ($stripe_test_mode == 'on') {
                $stripe_secret_key = $stripe_secret_test_key;
            } else if ($stripe_test_mode == 'off') {
                $stripe_secret_key = $stripe_secret_live_key;
            }

            $secret_key         =   $stripe_secret_key;
            $stripe_instance    =   new Stripe\Stripe();
            $stripe_instance->setApiKey($secret_key);
            $chargeable_amount  =   $amount * 100;
            $description        =   'Reservation charge [booking_id_' . $booking_id . ']';
            $currency           =   $stripe_currency;
            $stripe_charge      =   new Stripe\Charge();
            $stripe_charge->create(
                array(
                    'amount'      =>    $chargeable_amount,
                    'currency'    =>    $currency,
                    'description' =>    $description,
                    'source'      =>    $token
                )
            );

            $data['method']     =   'stripe';
            $data['booking_id'] =   $booking_id;
            $data['timestamp']  =   strtotime(date("d M, Y"));
            $data['amount']     =   $amount;
            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_payment', $data);

            $data2['status']      =      '2';
            $wpdb->update($wpdb->prefix . 'hotel_has_booking', $data2, array('booking_id' => $booking_id));

            if (self::has_get_settings('admin_notification')=='yes') {
                self::send_admin_email($booking_id);
            }
            if (self::has_get_settings('customer_notification')=='yes') {
                self::send_customer_email($booking_id);
            }
        }

        /**
         *
         * Method to create booking from frontend
         *
         */
        public static function has_create_booking_publicly()
        {
            $data['status']      =      '1';
            $data['name']        =      sanitize_text_field($_POST['name']);
            $data['email']       =      sanitize_text_field($_POST['email']);
            $data['address']     =      sanitize_text_field($_POST['address']);
            $data['phone']       =      sanitize_text_field($_POST['phone']);
            $data['total_guest'] =      sanitize_text_field($_POST['total_guest']);
            $data['summary']     =      sanitize_text_field($_POST['message']);
            $data['created_by']  =      'user';
            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_booking', $data);
            $booking_id = $wpdb->insert_id;

            /** Saving the rooms for a single booking */
            $room_types = isset( $_POST['room_types'] ) ? (array) $_POST['room_types'] : array();
            $room_types = array_map( 'sanitize_text_field', $room_types );
            $room_quantities = isset( $_POST['room_quantities'] ) ? (array) $_POST['room_quantities'] : array();
            $room_quantities = array_map( 'sanitize_text_field', $room_quantities );
            $checkin_timestamps = isset( $_POST['checkin_timestamps'] ) ? (array) $_POST['checkin_timestamps'] : array();
            $checkin_timestamps = array_map( 'sanitize_text_field', $checkin_timestamps );
            $checkout_timestamps = isset( $_POST['checkout_timestamps'] ) ? (array) $_POST['checkout_timestamps'] : array();
            $checkout_timestamps = array_map( 'sanitize_text_field', $checkout_timestamps );
            $prices = isset( $_POST['prices'] ) ? (array) $_POST['prices'] : array();
            $prices = array_map( 'sanitize_text_field', $prices );

            $number_of_entries   =      sizeof($room_types);
            for ($i = 0; $i < $number_of_entries; $i++) {
                /** for each room type, run the number of rooms requested by guest */
                $room_type_id    =      $room_types[$i];
                $number_of_rooms =      $room_quantities[$i];
                $room_counter    =      1;
                $room            =      $wpdb->prefix . 'hotel_has_room';
                $query_result    =      $wpdb->get_results("SELECT * FROM `$room` WHERE `room_type_id` = $room_type_id ", ARRAY_A);
                foreach ($query_result as $row1) {
                    /** Flag variable for checking if a room is available for booking */
                    $exclude_flag = false;

                    /**
                     *
                     * If a room is already in booking status within the asked checkin & checkout timestamp
                     *
                     * Checking within the room booking history of a single room
                     *
                     */
                    $booking_room = $wpdb->prefix . 'hotel_has_booking_room';
                    $room_id = $row1['room_id'];
                    $query_result2 = $wpdb->get_results("SELECT * FROM  `$booking_room` WHERE `room_id` = $room_id", ARRAY_A);
                    foreach ($query_result2 as $row2):

                        if ($checkin_timestamps[$i] >= $row2['checkin_timestamp'] && $checkin_timestamps[$i] < $row2['checkout_timestamp']) {
                            $exclude_flag = true;
                            break;
                        }
                        if ($checkout_timestamps[$i] > $row2['checkin_timestamp'] && $checkout_timestamps[$i] <= $row2['checkout_timestamp']) {
                            $exclude_flag = true;
                            break;
                        }
                        if ($checkin_timestamps[$i] <= $row2['checkin_timestamp'] && $checkout_timestamps[$i] >= $row2['checkout_timestamp']) {
                            $exclude_flag = true;
                            break;
                        }

                    endforeach;

                    /** Exclude this room, as it is not available */
                    if ($exclude_flag == true) {
                        continue;
                    } else {
                        /** insert in the booking_room table */
                        $data2['room_id']            =      $room_id;
                        $data2['checkin_timestamp']  =      $checkin_timestamps[$i];
                        $data2['checkout_timestamp'] =      $checkout_timestamps[$i];
                        $data2['price']              =      $prices[$i] / $room_quantities[$i];
                        $data2['booking_id']         =      $booking_id;
                        $wpdb->insert($wpdb->prefix . 'hotel_has_booking_room', $data2);

                        /** check if the room number exceeds the guest's requests room number of a single room type */
                        $room_counter++;
                        if ($room_counter > $number_of_rooms) {
                            break;
                        }
                    }
                }
            }

            if(isset($_POST['service_ids'])){
                /** Saving the services for a single booking */
                $service_ids = isset( $_POST['service_ids'] ) ? (array) $_POST['service_ids'] : array();
                $service_ids = array_map( 'sanitize_text_field', $service_ids );
                $types = isset( $_POST['types'] ) ? (array) $_POST['types'] : array();
                $types = array_map( 'sanitize_text_field', $types );
                $guest_numbers = isset( $_POST['guest_numbers'] ) ? (array) $_POST['guest_numbers'] : array();
                $guest_numbers = array_map( 'sanitize_text_field', $guest_numbers );
                $night_numbers = isset( $_POST['night_numbers'] ) ? (array) $_POST['night_numbers'] : array();
                $night_numbers = array_map( 'sanitize_text_field', $night_numbers );
                $service_prices = isset( $_POST['service_prices'] ) ? (array) $_POST['service_prices'] : array();
                $service_prices = array_map( 'sanitize_text_field', $service_prices );

                $number_of_entries  =       sizeof($service_ids);

                for ($i = 0; $i < $number_of_entries; $i++) {
                    $data3['booking_id']    =   $booking_id;
                    $data3['service_id']    =   $service_ids[$i];
                    $data3['type']          =   $types[$i];
                    $data3['guest_number']  =   $guest_numbers[$i];
                    $data3['night_number']  =   $night_numbers[$i];
                    $data3['price']         =   $service_prices[$i];

                    $wpdb->insert($wpdb->prefix . 'hotel_has_booking_service', $data3);
                }
            }

            echo $booking_id;


        }
        public function send_emails_cash_payment(){
            $booking_id =   sanitize_text_field($_POST['booking_id']);
            if (self::has_get_settings('admin_notification')=='yes') {
                self::send_admin_email($booking_id);
            }
            if (self::has_get_settings('customer_notification')=='yes') {
                self::send_customer_email($booking_id);
            }
        }

        /**
         *
         * Method to send admin notification
         *
         * @param $booking_id
         * @return bool
         */
        public static function send_admin_email($booking_id)
        {
            global $wpdb;
            $controller = new Controller;
            $table      =   $wpdb->prefix . 'hotel_has_booking';
            $order_info =   $wpdb->get_results("SELECT * FROM $table WHERE booking_id = '$booking_id'");

            $table2         =   $wpdb->prefix . 'hotel_has_booking_room';
            $booking_info   =   $wpdb->get_results("SELECT * FROM $table2 WHERE booking_id = '$booking_id'");

            $message    =   array();
            $message['id'] = $booking_id;
            $message['name'] = $order_info[0]->name;
            $message['email'] = $order_info[0]->email;
            $message['address'] = $order_info[0]->address;
            $message['phone'] = $order_info[0]->phone;
            $message['guests'] = $order_info[0]->total_guest;
            $message['summary'] = $order_info[0]->summary;

            $checkin = array();
            $checkout = array();
            $price = array();

            foreach ($booking_info as $value){
                array_push($checkin, date('d m Y', $value->checkin_timestamp));
                array_push($checkout, date('d m Y', $value->checkout_timestamp));
                array_push($price, self::has_currency($value->price));
            }

            $message['check_in'] = implode(" | ", $checkin);
            $message['check_out'] = implode(" | ", $checkout);
            $message['room_id'] = $booking_info[0]->room_id;
            $message['price'] = implode(" | ", $price);

            $email_to   =   self::has_get_settings('email');
            $subject    =   "New Booking! - Booking ID. " . $booking_id;
            $from       =   $order_info[0]->email;
            $from_name  =   $order_info[0]->name;

            $template = file_get_contents($controller->plugin_path . 'includes/libraries/email_admin_template.html');

            foreach($message as $key => $value)
            {
                $template = str_replace('{{ '.$key.' }}', $value, $template);
            }


            $headers    =   'From: ' . $from_name . '<' . $from . '>' . "\r\n";
            $headers    .=  'Reply-To: ' . $from_name . '<' . $from . '>';
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "Return-Path: $from_name <$from>\r\n";

            wp_mail($email_to,
                    $subject,
                    $template,
                    $headers);
            return false;

        }

        /**
         *
         * Method to send customer notification
         *
         * @param $booking_id
         * @return bool
         */
        public static function send_customer_email($booking_id)
        {
            global $wpdb;
            $controller = new Controller;
            $table      =   $wpdb->prefix . 'hotel_has_booking';
            $order_info =   $wpdb->get_results("SELECT * FROM $table WHERE booking_id = '$booking_id'");

            $table2         =   $wpdb->prefix . 'hotel_has_booking_room';
            $booking_info   =   $wpdb->get_results("SELECT * FROM $table2 WHERE booking_id = '$booking_id'");

            $message    =   array();
            $message['id'] = $booking_id;
            $message['name'] = $order_info[0]->name;
            $message['email'] = $order_info[0]->email;
            $message['address'] = $order_info[0]->address;
            $message['phone'] = $order_info[0]->phone;
            $message['guests'] = $order_info[0]->total_guest;
            $message['summary'] = $order_info[0]->summary;

            $email_to   =   self::has_get_settings('email');
            $checkin = array();
            $checkout = array();
            $price = array();

            foreach ($booking_info as $value){
                array_push($checkin, date('d m Y', $value->checkin_timestamp));
                array_push($checkout, date('d m Y', $value->checkout_timestamp));
                array_push($price, self::has_currency($value->price));
            }
            $message['check_in'] = implode(" | ", $checkin);
            $message['check_out'] = implode(" | ", $checkout);
            $message['room_id'] = $booking_info[0]->room_id;
            $message['price'] = implode(" | ", $price);
            $message['hotel_name'] = self::has_get_settings('hotel_name');
            $message['hotel_address'] = self::has_get_settings('address');
            $message['hotel_phone'] = self::has_get_settings('phone');
            $message['hotel_email'] = $email_to;
            $message['url'] = get_site_url();


            $subject    =   "New Booking! - Booking ID. " . $booking_id;
            $from       =   $order_info[0]->email;
            $from_name  =   $order_info[0]->name;

            $template = file_get_contents($controller->plugin_path . 'includes/libraries/email_customer_template.html');

            foreach($message as $key => $value)
            {
                $template = str_replace('{{ '.$key.' }}', $value, $template);
            }


            $headers    =   'From: ' . $from_name . '<' . $from . '>' . "\r\n";
            $headers    .=  'Reply-To: ' . $from_name . '<' . $from . '>';
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "Return-Path: $from_name <$from>\r\n";

            wp_mail($email_to,
                $subject,
                $template,
                $headers);

            return false;
        }

        /**
         *
         * Method add reservations from WooCommerce
         *
         * @param $booking_details object
         *
         */
        public function has_create_booking_woocommerce($booking_details)
        {
            $data['status']             =       $booking_details->status;
            $data['name']               =       $booking_details->name;
            $data['email']              =       $booking_details->email;
            $data['address']            =       $booking_details->address;
            $data['phone']              =       $booking_details->phone;
            $data['total_guest']        =       'none';
            $data['summary']            =       $booking_details->summary;
            $data['created_by']         =       $booking_details->requester;
            $checkin_timestamps         =       $booking_details->check_in;
            $checkout_timestamps        =       $booking_details->check_out;
            $room_type_id               =       $booking_details->room_type_id;
            $price                      =       $booking_details->price;
            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_booking', $data);
            $booking_id = $wpdb->insert_id;

            /**
             *
             * Saving the rooms for a single booking
             *
             * for each room type, run the number of rooms requested by guest
             *
             */
            $room            =      $wpdb->prefix . 'hotel_has_room';
            $query_result    =      $wpdb->get_results("SELECT * FROM `$room` WHERE `room_type_id` = $room_type_id ", ARRAY_A);
            foreach ($query_result as $row){
                $exclude_flag = false;
                $booking_room = $wpdb->prefix . 'hotel_has_booking_room';
                $room_id = $row['room_id'];
                $query_result2 = $wpdb->get_results("SELECT * FROM  `$booking_room` WHERE `room_id` = $room_id", ARRAY_A);
                if(isset($query_result2)){
                    foreach ($query_result2 as $row2):

                        if ($checkin_timestamps >= $row2['checkin_timestamp'] && $checkin_timestamps < $row2['checkout_timestamp']) {
                            $exclude_flag = true;
                            break;
                        }
                        if ($checkout_timestamps > $row2['checkin_timestamp'] && $checkout_timestamps <= $row2['checkout_timestamp']) {
                            $exclude_flag = true;
                            break;
                        }
                        if ($checkin_timestamps <= $row2['checkin_timestamp'] && $checkout_timestamps >= $row2['checkout_timestamp']) {
                            $exclude_flag = true;
                            break;
                        }

                    endforeach;

                    /** Exclude this room, as it is not available */
                    if ($exclude_flag == true) {
                        die();
                    } else {
                        /** insert in the booking_room table */
                        $data2['room_id']               =       $room_id;
                        $data2['checkin_timestamp']     =       $checkin_timestamps;
                        $data2['checkout_timestamp']    =       $checkout_timestamps;
                        $data2['booking_id']            =       $booking_id;
                        $data2['price']                 =       $price;
                        $wpdb->insert($wpdb->prefix . 'hotel_has_booking_room', $data2);

                        $data3['method']     =   'woocommerce';
                        $data3['booking_id'] =   $booking_id;
                        $data3['timestamp']  =   strtotime(date("d M, Y"));
                        $data3['amount']     =   $price;
                        $wpdb->insert($wpdb->prefix . 'hotel_has_payment', $data3);
                    }
                }
                else echo '!';

            }

            /** Flag variable for checking if a room is available for booking */


            /**
             *
             * If a room is already in booking status within the asked checkin & checkout timestamp
             *
             * Checking within the room booking history of a single room
             *
             */



        }


        /**
         *
         * Method add reservations from AirBnB
         *
         * @param $airbnb
         * @param $checkin_timestamps
         * @param $checkout_timestamps
         * @param $room_type_id
         * @param $location
         * @param $summary
         * @param $description
         *
         */
        public static function has_create_booking_airnbnb($airbnb, $checkin_timestamps, $checkout_timestamps, $room_type_id, $location, $summary, $description)
        {
            $data['status']         =   '2';
            $data['name']           =   $summary;
            $data['email']          =   'none';
            $data['address']        =   $location;
            $data['phone']          =   'none';
            $data['total_guest']    =   '1';
            $data['summary']        =   $description;
            $data['created_by']     =   $airbnb;
            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_booking', $data);
            $booking_id = $wpdb->insert_id;

            /**
             *
             * Saving the rooms for a single booking
             *
             * for each room type, run the number of rooms requested by guest
             *
             */


                /** Flag variable for checking if a room is available for booking */
                $exclude_flag = false;

                /**
                 *
                 * If a room is already in booking status within the asked checkin & checkout timestamp
                 *
                 * Checking within the room booking history of a single room
                 *
                 */
                $booking_room = $wpdb->prefix . 'hotel_has_booking_room';
                $room_id = $room_type_id;
                $query_result2 = $wpdb->get_results("SELECT * FROM  `$booking_room` WHERE `room_id` = $room_id", ARRAY_A);
                foreach ($query_result2 as $row2):

                    if ($checkin_timestamps >= $row2['checkin_timestamp'] && $checkin_timestamps < $row2['checkout_timestamp']) {
                        $exclude_flag = true;
                        break;
                    }
                    if ($checkout_timestamps > $row2['checkin_timestamp'] && $checkout_timestamps <= $row2['checkout_timestamp']) {
                        $exclude_flag = true;
                        break;
                    }
                    if ($checkin_timestamps <= $row2['checkin_timestamp'] && $checkout_timestamps >= $row2['checkout_timestamp']) {
                        $exclude_flag = true;
                        break;
                    }

                endforeach;

                /** Exclude this room, as it is not available */
                if ($exclude_flag == true) {
                    die();
                } else {
                    /** insert in the booking_room table */
                    $data2['room_id']               =       $room_id;
                    $data2['checkin_timestamp']     =       $checkin_timestamps;
                    $data2['checkout_timestamp']    =       $checkout_timestamps;
                    $data2['booking_id']            =       $booking_id;
                    $wpdb->insert($wpdb->prefix . 'hotel_has_booking_room', $data2);
                }


        }

        /**
         *
         * Method add reservations from Google Calendars
         *
         * @param $google
         * @param $checkin_timestamps
         * @param $checkout_timestamps
         * @param $room_type_id
         * @param $location
         * @param $summary
         * @param $description
         *
         */
        public function has_create_booking_google($google, $checkin_timestamps, $checkout_timestamps, $room_type_id, $location, $summary, $description)
        {
            $data['status']         =   '2';
            $data['name']           =   $summary;
            $data['email']          =   'none';
            $data['address']        =   $location;
            $data['phone']          =   'none';
            $data['total_guest']    =   '1';
            $data['summary']        =   $description;
            $data['created_by']     =   $google;

            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_booking', $data);
            $booking_id = $wpdb->insert_id;

            /**
             *
             * Saving the rooms for a single booking
             *
             * for each room type, run the number of rooms requested by guest
             *
             */


                /** Flag variable for checking if a room is available for booking */
                $exclude_flag = false;

                /**
                 *
                 * If a room is already in booking status within the asked checkin & checkout timestamp
                 *
                 * Checking within the room booking history of a single room
                 *
                 */
                $booking_room = $wpdb->prefix . 'hotel_has_booking_room';
                $room_id = $room_type_id;
                $query_result2 = $wpdb->get_results("SELECT * FROM  `$booking_room` WHERE `room_id` = $room_id", ARRAY_A);
                foreach ($query_result2 as $row2):

                    if ($checkin_timestamps >= $row2['checkin_timestamp'] && $checkin_timestamps < $row2['checkout_timestamp']) {
                        $exclude_flag = true;
                        break;
                    }
                    if ($checkout_timestamps > $row2['checkin_timestamp'] && $checkout_timestamps <= $row2['checkout_timestamp']) {
                        $exclude_flag = true;
                        break;
                    }
                    if ($checkin_timestamps <= $row2['checkin_timestamp'] && $checkout_timestamps >= $row2['checkout_timestamp']) {
                        $exclude_flag = true;
                        break;
                    }

                endforeach;

                /** Exclude this room, as it is not available */
                if ($exclude_flag == true) {
                    die();
                } else {
                    /** insert in the booking_room table */
                    $data2['room_id']               =       $room_id;
                    $data2['checkin_timestamp']     =       $checkin_timestamps;
                    $data2['checkout_timestamp']    =       $checkout_timestamps;
                    $data2['booking_id']            =       $booking_id;
                    $wpdb->insert($wpdb->prefix . 'hotel_has_booking_room', $data2);
                }

        }

        /**
         *
         * Method add reservations from Booking.com
         *
         * @param $booking_com
         * @param $checkin_timestamps
         * @param $checkout_timestamps
         * @param $room_type_id
         * @param $location
         * @param $summary
         * @param $description
         *
         */
        public static function has_create_booking_booking_com($booking_com, $checkin_timestamps, $checkout_timestamps, $room_type_id, $location, $summary, $description)
        {
            $data['status']         =   '1';
            $data['name']           =   $summary;
            $data['email']          =   'none';
            $data['address']        =   $location;
            $data['phone']          =   'none';
            $data['total_guest']    =   'none';
            $data['summary']        =   $description;
            $data['created_by']     =   $booking_com;
            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_booking', $data);
            $booking_id = $wpdb->insert_id;

            /**
             *
             * Saving the rooms for a single booking
             *
             * for each room type, run the number of rooms requested by guest
             *
             */


                /** Flag variable for checking if a room is available for booking */
                $exclude_flag = false;

                /**
                 *
                 * If a room is already in booking status within the asked checkin & checkout timestamp
                 *
                 * Checking within the room booking history of a single room
                 *
                 */
                $booking_room = $wpdb->prefix . 'hotel_has_booking_room';
                $room_id = $room_type_id;
                $query_result2 = $wpdb->get_results("SELECT * FROM  `$booking_room` WHERE `room_id` = $room_id", ARRAY_A);
                foreach ($query_result2 as $row2):

                    if ($checkin_timestamps >= $row2['checkin_timestamp'] && $checkin_timestamps < $row2['checkout_timestamp']) {
                        $exclude_flag = true;
                        break;
                    }
                    if ($checkout_timestamps > $row2['checkin_timestamp'] && $checkout_timestamps <= $row2['checkout_timestamp']) {
                        $exclude_flag = true;
                        break;
                    }
                    if ($checkin_timestamps <= $row2['checkin_timestamp'] && $checkout_timestamps >= $row2['checkout_timestamp']) {
                        $exclude_flag = true;
                        break;
                    }

                endforeach;

                /** Exclude this room, as it is not available */
                if ($exclude_flag == true) {
                    die();
                } else {
                    /** insert in the booking_room table */
                    $data2['room_id']               =       $room_id;
                    $data2['checkin_timestamp']     =       $checkin_timestamps;
                    $data2['checkout_timestamp']    =       $checkout_timestamps;
                    $data2['booking_id']            =       $booking_id;
                    $wpdb->insert($wpdb->prefix . 'hotel_has_booking_room', $data2);
                }


        }

        /**
         *
         * Method to send create reservation from backend
         *
         */
        public static function has_booking_create()
        {
            $data['status']             =       sanitize_text_field($_POST['status']);
            $data['name']               =       sanitize_text_field($_POST['name']);
            $data['email']              =       sanitize_text_field($_POST['email']);
            $data['address']            =       sanitize_text_field($_POST['address']);
            $data['phone']              =       sanitize_text_field($_POST['phone']);
            $data['total_guest']        =       sanitize_text_field($_POST['total_guest']);
            $data['booking_timestamp']  =       date('Y-m-d H:i:s');
            $data['summary']            =       'none';
            $data['created_by']         =       'admin';

            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_booking', $data);
            $new_booking_id         =       $wpdb->insert_id;

            /** Saving the selected rooms for a single booking */
            $data2['booking_id']    =       $new_booking_id;
            $rooms = isset( $_POST['rooms'] ) ? (array) $_POST['rooms'] : array();
            $rooms = array_map( 'sanitize_text_field', $rooms );
            $checkin_timestamps = isset( $_POST['checkin_timestamps'] ) ? (array) $_POST['checkin_timestamps'] : array();
            $checkin_timestamps = array_map( 'sanitize_text_field', $checkin_timestamps );
            $checkout_timestamps = isset( $_POST['checkout_timestamps'] ) ? (array) $_POST['checkout_timestamps'] : array();
            $checkout_timestamps = array_map( 'sanitize_text_field', $checkout_timestamps );
            $prices = isset( $_POST['prices'] ) ? (array) $_POST['prices'] : array();
            $prices = array_map( 'sanitize_text_field', $prices );

            $number_of_entries = sizeof($rooms);
            for ($i = 0; $i < $number_of_entries; $i++) {
                $data2['room_id']               =       $rooms[$i];
                $data2['checkin_timestamp']     =       $checkin_timestamps[$i];
                $data2['checkout_timestamp']    =       $checkout_timestamps[$i];
                $data2['price']                 =       $prices[$i];
                $wpdb->insert($wpdb->prefix . 'hotel_has_booking_room', $data2);
            }

            /** Saving the selected services for a single booking */
            $services = self::has_get_services();
            foreach ($services as $row) {
                $service_input_name = 'service_' . $row['service_id'];
                if (isset($_POST[$service_input_name]) && $_POST[$service_input_name] == 'yes') {
                    $data3['service_id']    =   $row['service_id'];
                    $data3['type']          =   $row['type'];
                    $data3['price']         =   $row['price'];
                    $data3['booking_id']    =   $new_booking_id;
                    /** check if the service is fixed price/guest multiplier/night multiplier */
                    if ($row['type'] == '2') {
                        $guest_number_input_name    =       'guest_number_' . $row['service_id'];
                        $data3['guest_number']      =       sanitize_text_field($_POST[$guest_number_input_name]);
                    }
                    if ($row['type'] == '3') {
                        $night_number_input_name    =       'night_number_' . $row['service_id'];
                        $data3['night_number']      =       sanitize_text_field($_POST[$night_number_input_name]);
                    }
                    $wpdb->insert($wpdb->prefix . 'hotel_has_booking_service', $data3);
                }
            }
        }

        /**
         *
         * Method to edit reservation in backend
         *
         */
        public static function has_booking_edit()
        {
            /** Update booking basic info */
            $booking_id             =       sanitize_text_field($_POST['booking_id']);
            $data['status']         =       sanitize_text_field($_POST['status']);
            $data['name']           =       sanitize_text_field($_POST['name']);
            $data['email']          =       sanitize_text_field($_POST['email']);
            $data['address']        =       sanitize_text_field($_POST['address']);
            $data['phone']          =       sanitize_text_field($_POST['phone']);
            $data['total_guest']    =       sanitize_text_field($_POST['total_guest']);

            global $wpdb;
            $wpdb->update($wpdb->prefix . 'hotel_has_booking', $data, array('booking_id' => $booking_id));

            /**
             *
             * Update the rooms under this booking.
             *
             * First delete the old ones and then re-insert the new ones
             *
             */
            global $wpdb;
            $wpdb->delete($wpdb->prefix . 'hotel_has_booking_room', array('booking_id' => $booking_id));

            /** Now re-insert the updated booking rooms */
            $data2['booking_id']    =       $booking_id;

            $rooms = isset( $_POST['rooms'] ) ? (array) $_POST['rooms'] : array();
            $rooms = array_map( 'sanitize_text_field', $rooms );
            $checkin_timestamps = isset( $_POST['checkin_timestamps'] ) ? (array) $_POST['checkin_timestamps'] : array();
            $checkin_timestamps = array_map( 'sanitize_text_field', $checkin_timestamps );
            $checkout_timestamps = isset( $_POST['checkout_timestamps'] ) ? (array) $_POST['checkout_timestamps'] : array();
            $checkout_timestamps = array_map( 'sanitize_text_field', $checkout_timestamps );
            $prices = isset( $_POST['prices'] ) ? (array) $_POST['prices'] : array();
            $prices = array_map( 'sanitize_text_field', $prices );

            $number_of_entries      =       sizeof($rooms);
            for ($i = 0; $i < $number_of_entries; $i++) {
                $data2['room_id']               =       $rooms[$i];
                $data2['checkin_timestamp']     =       $checkin_timestamps[$i];
                $data2['checkout_timestamp']    =       $checkout_timestamps[$i];
                $data2['price']                 =       $prices[$i];
                $wpdb->insert($wpdb->prefix . 'hotel_has_booking_room', $data2);
            }

            /**
             *
             * Update the services under this booking.
             *
             * First delete the old ones and then re-insert the new ones
             *
             */
            global $wpdb;
            $wpdb->delete($wpdb->prefix . 'hotel_has_booking_service', array('booking_id' => $booking_id));

            /**
             * Now re-insert the updated booking services
             */
            $services = self::has_get_services();
            foreach ($services as $row) {
                $service_input_name = 'service_' . $row['service_id'];
                if (isset($_POST[$service_input_name]) && $_POST[$service_input_name] == 'yes') {
                    $data3['service_id']    =       $row['service_id'];
                    $data3['type']          =       $row['type'];
                    $data3['price']         =       $row['price'];
                    $data3['booking_id']    =       $booking_id;
                    /**
                     * check if the service is fixed price/guest multiplier/night multiplier
                     */
                    if ($row['type'] == '2') {
                        $guest_number_input_name    =   'guest_number_' . $row['service_id'];
                        $data3['guest_number']      =   sanitize_text_field($_POST[$guest_number_input_name]);
                    }
                    if ($row['type'] == '3') {
                        $night_number_input_name    =   'night_number_' . $row['service_id'];
                        $data3['night_number']      =   sanitize_text_field($_POST[$night_number_input_name]);
                    }
                    $wpdb->insert($wpdb->prefix . 'hotel_has_booking_service', $data3);
                }
            }
        }

        /**
         *
         * Method to delete reservation in backend
         *
         */
        public static function has_booking_delete()
        {
            global $wpdb;
            $booking_id = sanitize_text_field($_POST['booking_id']);

            /** delete the booking information */
            $wpdb->delete($wpdb->prefix . 'hotel_has_booking', array('booking_id' => $booking_id));

            /** deleting the rooms allocated with the booking_id */
            $wpdb->delete($wpdb->prefix . 'hotel_has_booking_room', array('booking_id' => $booking_id));
        }

        /**
         *
         * Method to take reservation payment in backend
         *
         */
        public static function has_take_payment()
        {
            /**
             * create payment under a single booking
             */
            $data['booking_id']     =       sanitize_text_field($_POST['booking_id']);
            $data['timestamp']      =       strtotime(sanitize_text_field($_POST['date']));
            $data['amount']         =       sanitize_text_field($_POST['amount']);
            $data['method']         =       'cash';

            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_payment', $data);
        }

        /**
         *
         * Method to get reservations and their payments
         *
         * @param $booking_id
         * @return array|object|null
         *
         */
        public static function has_get_booking_payments($booking_id)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_payment';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `booking_id` = $booking_id", ARRAY_A);
            return $query_result;
        }

        /**
         *
         * Method to get rooms allocated to a reservation
         *
         * @param $booking_id integer
         * @return array|object|null
         *
         */
        public static function has_get_booking_allocated_rooms($booking_id)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_booking_room';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `booking_id` = $booking_id", ARRAY_A);
            return $query_result;
        }


        /**
         *
         * Method to get services attached to a reservation
         *
         * @param $booking_id integer
         * @return array|object|null
         *
         */
        public static function has_get_booking_attached_services($booking_id)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_booking_service';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `booking_id` = $booking_id", ARRAY_A);
            return $query_result;
        }

        public static function has_get_booking_of_room($room_id)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_booking_room';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_id` = $room_id",
                ARRAY_A);
            return $query_result;
        }


        /**
         *
         * Method to get the room price
         *
         * @param $room_id int
         * @param $checkin_timestamp string
         * @param $checkout_timestamp string
         * @return int|mixed|string|null
         *
         */
        public static function has_get_room_price($room_id,
                                                  $checkin_timestamp,
                                                  $checkout_timestamp)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_id` = $room_id", ARRAY_A);
            foreach ($query_result as $row) {
                $room_type_id = $row['room_type_id'];
            }

            // finding the custom price from price table
            //$checkin_timestamp  =   strtotime('+1 day', $checkin_timestamp);
            //$str='';
            $total_price = 0;
            for ($timestamp = $checkin_timestamp; $timestamp < $checkout_timestamp;) {
                $day = date("j", $timestamp);
                $month = date("n", $timestamp);
                $year = date("Y", $timestamp);
                $table = $wpdb->prefix . 'hotel_has_pricing';
                $numrows = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE `day` = $day AND `month` = $month AND `year` = $year AND `room_type_id` = $room_type_id");
                if ($numrows == 0) {
                    $table = $wpdb->prefix . 'hotel_has_room_type';
                    $price = $wpdb->get_var($wpdb->prepare("SELECT price FROM $table WHERE room_type_id = %d", $room_type_id));
                    $total_price += $price;
                } else {
                    $table = $wpdb->prefix . 'hotel_has_pricing';
                    $price = $wpdb->get_var($wpdb->prepare("SELECT price FROM $table WHERE `day` = %d AND `month` = %d AND `year` = %d AND `room_type_id` = %d", array($day, $month, $year, $room_type_id)));$total_price += $price;
                }

                //$str .= $day.'-'.$month.'-'.$year.'-'.$numrows.'-'.$price.'<br>';
                $timestamp = strtotime('+1 day', $timestamp);
            }

            //return $str;
            return $total_price;

            /**
             *
             * if custom price is not found, then rooms default base price is returned
             *
             */

            $table = $wpdb->prefix . 'hotel_has_room_type';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['price'];
            }
        }


        /**
         *
         * Method to get room name
         *
         * parameter: $room_id (integer)
         *
         */
        public static function has_get_room_name($room_id)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_id` = $room_id",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['name'];
            }
        }


        /**
         *
         * Method to get room type
         *
         */
        public static function has_get_room_type()
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room_type';
            $query_result = $wpdb->get_results("SELECT * FROM $table",
                ARRAY_A);
            return $query_result;
        }


        /**
         *
         * Method room type name using the ID
         *
         * @param $room_type_id
         * @return mixed
         *
         */
        public static function has_get_name_by_room_type_id($room_type_id)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room_type';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['name'];
            }
        }

        public static function has_get_room_type_name($room_id)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_id` = $room_id",
                ARRAY_A);
            foreach ($query_result as $row) {
                $room_type_id = $row['room_type_id'];
            }

            $table = $wpdb->prefix . 'hotel_has_room_type';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['name'];
            }
        }



        /**
         *
         * Method to create pricing for room types
         *
         */
        public static function has_pricing_create()
        {
            global $wpdb;
            $from_date = $_POST['from_timestamp'];
            $to_date = $_POST['to_timestamp'];
            $from_timestamp = strtotime(str_replace(",", "", $from_date));
            $to_timestamp = strtotime(str_replace(",", "", $to_date));

            for ($entry_timestamp = $from_timestamp; $entry_timestamp <= $to_timestamp; $from_timestamp) {
                $data['day'] = date("j", $entry_timestamp);
                $data['month'] = date("n", $entry_timestamp);
                $data['year'] = date("Y", $entry_timestamp);
                $data['room_type_id'] = sanitize_text_field($_POST['room_type_id']);
                $data['price'] = sanitize_text_field($_POST['price']);

                $day_name = date('D', $entry_timestamp);
                if ($day_name == 'Sat') {
                    if (isset($_POST['saturday']) && $_POST['saturday'] == 'yes') {
                        $wpdb->insert($wpdb->prefix . 'hotel_has_pricing', $data);
                    }
                } else if ($day_name == 'Sun') {
                    if (isset($_POST['sunday']) && $_POST['sunday'] == 'yes') {
                        $wpdb->insert($wpdb->prefix . 'hotel_has_pricing', $data);
                    }
                } else if ($day_name == 'Mon') {
                    if (isset($_POST['monday']) && $_POST['monday'] == 'yes') {
                        $wpdb->insert($wpdb->prefix . 'hotel_has_pricing', $data);
                    }
                } else if ($day_name == 'Tue') {
                    if (isset($_POST['tuesday']) && $_POST['tuesday'] == 'yes') {
                        $wpdb->insert($wpdb->prefix . 'hotel_has_pricing', $data);
                    }
                } else if ($day_name == 'Wed') {
                    if (isset($_POST['wednesday']) && $_POST['wednesday'] == 'yes') {
                        $wpdb->insert($wpdb->prefix . 'hotel_has_pricing', $data);
                    }
                } else if ($day_name == 'Thu') {
                    if (isset($_POST['thursday']) && $_POST['thursday'] == 'yes') {
                        $wpdb->insert($wpdb->prefix . 'hotel_has_pricing', $data);
                    }
                } else if ($day_name == 'Fri') {
                    if (isset($_POST['friday']) && $_POST['friday'] == 'yes') {
                        $wpdb->insert($wpdb->prefix . 'hotel_has_pricing', $data);
                    }
                }

                $entry_timestamp = strtotime("+1 day",
                    $entry_timestamp);
            }
        }


        /**
         *
         * Method to delete prices of room types
         *
         */
        public static function has_pricing_delete()
        {
            global $wpdb;
            $from_date = sanitize_text_field($_POST['from_timestamp']);
            $to_date = sanitize_text_field($_POST['to_timestamp']);
            $from_timestamp = strtotime(str_replace(",",
                "",
                $from_date));
            $to_timestamp = strtotime(str_replace(",",
                "",
                $to_date));

            for ($entry_timestamp = $from_timestamp; $entry_timestamp <= $to_timestamp; $from_timestamp) {
                $day = date("j",
                    $entry_timestamp);
                $month = date("n",
                    $entry_timestamp);
                $year = date("Y",
                    $entry_timestamp);
                $room_type_id = sanitize_text_field($_POST['room_type_id']);

                $wpdb->delete($wpdb->prefix . 'hotel_has_pricing',
                    array('room_type_id' => $room_type_id,
                        'day' => $day,
                        'month' => $month,
                        'year' => $year));

                $entry_timestamp = strtotime("+1 day",
                    $entry_timestamp);
            }
        }

        /**
         *
         * Method to create room
         *
         */
        public static function has_room_create()
        {
            $data['name'] = sanitize_text_field($_POST['name']);
            $data['room_type_id'] = sanitize_text_field($_POST['room_type_id']);
            $data['floor_id'] = sanitize_text_field($_POST['floor_id']);
            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_room',
                $data);
        }

        /**
         *
         * Method to edit room
         *
         */
        public static function has_room_edit()
        {
            $room_id = sanitize_text_field($_POST['room_id']);
            $data['name'] = sanitize_text_field($_POST['name']);
            $data['room_type_id'] = sanitize_text_field($_POST['room_type_id']);
            $data['floor_id'] = sanitize_text_field($_POST['floor_id']);

            global $wpdb;
            $wpdb->update($wpdb->prefix . 'hotel_has_room',
                $data,
                array('room_id' => $room_id));
        }

        public static function has_room_delete()
        {
            $room_id = sanitize_text_field($_POST['room_id']);
            global $wpdb;
            $wpdb->delete($wpdb->prefix . 'hotel_has_room',
                array('room_id' => $room_id));
        }

        /**
         *
         * Method to get room type data
         * @return array
         *
         */
        public static function has_get_room_types()
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room_type';
            $query_result = $wpdb->get_results("SELECT * FROM $table",
                ARRAY_A);
            return $query_result;
        }


        /**
         *
         * Method to create room type
         *
         */
        public static function has_room_type_create()
        {
            $data['name'] = sanitize_text_field($_POST['name']);
            $data['capacity'] = sanitize_text_field($_POST['capacity']);
            $data['price'] = sanitize_text_field($_POST['price']);
            $data['image_url'] = sanitize_text_field($_POST['image_url']);

            /**
             *
             * encoding amenities array to JSON
             *
             */
            $amenity_array = array();
            $amenities = $_POST['amenities'];
            foreach ($amenities as $row) {
                array_push($amenity_array,
                    $row);
            }
            $amenity_json = json_encode($amenity_array);
            $data['amenities'] = $amenity_json;

            /**
             *
             * encoding beds array to JSON
             *
             */
            $beds_array = array();
            $beds = $_POST['beds'];
            foreach ($beds as $row) {
                array_push($beds_array,
                    $row);
            }
            $beds_json = json_encode($beds_array);
            $data['bed_type'] = $beds_json;

            /**
             *
             * encoding permissions array to JSON
             *
             */
            $permissions_array = array();
            $permissions = $_POST['permissions'];
            foreach ($permissions as $row) {
                array_push($permissions_array,
                    $row);
            }
            $permissions_json = json_encode($permissions_array);
            $data['permissions'] = $permissions_json;

            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_room_type',
                $data);
        }

        /**
         *
         * Method to edit room type
         *
         */
        public static function has_room_type_edit()
        {
            $room_type_id = sanitize_text_field($_POST['room_type_id']);
            $data['name'] = sanitize_text_field($_POST['name']);
            $data['capacity'] = sanitize_text_field($_POST['capacity']);
            $data['price'] = sanitize_text_field($_POST['price']);
            $data['image_url'] = sanitize_text_field($_POST['image_url']);

            /**
             *
             * encode amenities from array to JSON
             *
             */
            $amenity_array = array();
            $amenities = $_POST['amenities'];
            foreach ($amenities as $row) {
                array_push($amenity_array,
                    $row);
            }
            $amenity_json = json_encode($amenity_array);
            $data['amenities'] = $amenity_json;

            /**
             *
             * encode beds array to JSON
             *
             */
            $beds_array = array();
            $beds = $_POST['beds'];
            foreach ($beds as $row) {
                array_push($beds_array,
                    $row);
            }
            $beds_json = json_encode($beds_array);
            $data['bed_type'] = $beds_json;

            /**
             *
             * encode permissions array to JSON
             *
             */
            $permissions_array = array();
            $permissions = $_POST['permissions'];
            foreach ($permissions as $row) {
                array_push($permissions_array,
                    $row);
            }
            $permissions_json = json_encode($permissions_array);
            $data['permissions'] = $permissions_json;

            global $wpdb;
            $wpdb->update($wpdb->prefix . 'hotel_has_room_type',
                $data,
                array('room_type_id' => $room_type_id));
        }

        /**
         *
         * Method to delete room type
         *
         */
        public static function has_room_type_delete()
        {
            $room_type_id = sanitize_text_field($_POST['room_type_id']);
            global $wpdb;
            $wpdb->delete($wpdb->prefix . 'hotel_has_room_type',
                array('room_type_id' => $room_type_id));
        }

        /**
         *
         * Method to get room type with certain ID
         * @param string $room_type_id
         * @return mixed
         */
        public static function get_room_type_name_by_id($room_type_id = '')
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room_type';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['name'];
            }
        }

        /**
         *
         * Method to get room price
         * @param $room_type_id integer
         * @return mixed
         */
        public static function has_get_room_type_price($room_type_id)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room_type';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['price'];
            }
        }

        /**
         *
         * Method to get rooms with certain ID
         * @param $room_type_id integer
         * @return array|object|null
         */
        public static function has_get_room_by_type($room_type_id)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id",
                ARRAY_A);
            return $query_result;
        }

        /**
         *
         * Method to get all rooms
         * @return array
         *
         */
        public static function has_get_rooms()
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room';
            $query_result = $wpdb->get_results("SELECT * FROM $table",
                ARRAY_A);
            return $query_result;
        }

        /**
         *
         * Method to get rooms for synchronization process
         * @return mixed
         *
         */
        public static function has_get_rooms_for_sync()
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_room';
            if($wpdb->get_var("SHOW TABLES LIKE '$table'") === $table) {
                $query_result = $wpdb->get_results("SELECT * FROM $table",
                    ARRAY_A);
                return $query_result;
            }
            else return false;
        }

        /**
         *
         * Method to greate floor
         *
         */
        public static function has_floor_create()
        {
            $data['name'] = sanitize_text_field($_POST['name']);
            $data['note'] = sanitize_text_field($_POST['note']);
            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_floor',
                $data);
        }

        /**
         *
         * Method to edit floor
         *
         */
        public static function has_floor_edit()
        {
            $floor_id = sanitize_text_field($_POST['floor_id']);
            $data['name'] = sanitize_text_field($_POST['name']);
            $data['note'] = sanitize_text_field($_POST['note']);

            global $wpdb;
            $wpdb->update($wpdb->prefix . 'hotel_has_floor',
                $data,
                array('floor_id' => $floor_id));
        }

        /**
         *
         * Method to delete floor
         *
         */
        public static function has_floor_delete()
        {
            $floor_id = sanitize_text_field($_POST['floor_id']);
            global $wpdb;
            $wpdb->delete($wpdb->prefix . 'hotel_has_floor',
                array('floor_id' => $floor_id));
        }

        /**
         *
         * Method to get floor name
         * @param string $floor_id
         * @return string
         */
        public static function get_floor_name_by_id($floor_id = '')
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_floor';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `floor_id` = $floor_id",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['name'];
            }
        }

        /**
         *
         * Method to get amenity data from database
         * @return array
         *
         */
        public static function has_get_amenities()
        {
            global $wpdb;
            $amenity = $wpdb->prefix . 'hotel_has_amenity';
            $query_result = $wpdb->get_results("SELECT * FROM `$amenity`",
                ARRAY_A);
            return $query_result;
        }

        /**
         *
         * Method to get amenity name
         * @param string $amenity_id
         * @return mixed
         */
        public static function get_amenity_name_by_id($amenity_id = '')
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_amenity';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `amenity_id` = $amenity_id",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['name'];
            }
        }

        /**
         *
         * Method to create amenity
         *
         */
        public static function has_amenity_create()
        {
            $data['name'] = sanitize_text_field($_POST['name']);
            $data['description'] = sanitize_text_field($_POST['description']);
            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_amenity',
                $data);
        }

        /**
         *
         * Method to edit amenity
         *
         */
        public static function has_amenity_edit()
        {
            $amenity_id = sanitize_text_field($_POST['amenity_id']);
            $data['name'] = sanitize_text_field($_POST['name']);
            $data['description'] = sanitize_text_field($_POST['description']);

            global $wpdb;
            $wpdb->update($wpdb->prefix . 'hotel_has_amenity',
                $data,
                array('amenity_id' => $amenity_id));
        }

        /**
         *
         * Method to delete amenity
         *
         */
        public static function has_amenity_delete()
        {
            $amenity_id = sanitize_text_field($_POST['amenity_id']);
            global $wpdb;
            $wpdb->delete($wpdb->prefix . 'hotel_has_amenity',
                array('amenity_id' => $amenity_id));
        }

        /**
         *
         * Method to get service data from database
         * @return array
         */

        public static function has_get_services()
        {
            global $wpdb;
            $service = $wpdb->prefix . 'hotel_has_service';
            $query_result = $wpdb->get_results("SELECT * FROM `$service`",
                ARRAY_A);
            return $query_result;
        }

        /**
         *
         * Method to create service
         *
         */
        public static function has_service_create()
        {
            $data['name'] = sanitize_text_field($_POST['name']);
            $data['type'] = sanitize_text_field($_POST['type']);
            $data['price'] = sanitize_text_field($_POST['price']);
            global $wpdb;
            $wpdb->insert($wpdb->prefix . 'hotel_has_service',
                $data);
        }

        /**
         *
         * Method to edit service
         *
         */
        public static function has_service_edit()
        {
            $service_id = sanitize_text_field($_POST['service_id']);
            $data['name'] = sanitize_text_field($_POST['name']);
            $data['type'] = sanitize_text_field($_POST['type']);
            $data['price'] = sanitize_text_field($_POST['price']);

            global $wpdb;
            $wpdb->update($wpdb->prefix . 'hotel_has_service',
                $data,
                array('service_id' => $service_id));
        }

        /**
         *
         * Method to delete service
         *
         */
        public static function has_service_delete()
        {
            $service_id = sanitize_text_field($_POST['service_id']);
            global $wpdb;
            $wpdb->delete($wpdb->prefix . 'hotel_has_service',
                array('service_id' => $service_id));
        }

        /**
         *
         * Method to get service name
         *
         */
        public static function has_get_service_name($service_id)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_service';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `service_id` = $service_id",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['name'];
            }
        }

        /**
         *
         * Method to save translations
         *
         */
        public static function has_save_translate()
        {
            global $wpdb;
            $index = sanitize_text_field($_POST['index']);
            $data['description'] = sanitize_text_field($_POST['custom_translation' . $index]);
            $wpdb->update($wpdb->prefix . 'hotel_has_en_lang',
                $data,
                array('text_id' => $index));
        }

        /**
         *
         * Method to save general settings
         *
         */
        public static function has_save_general_settings()
        {
            global $wpdb;

            $data['description'] = sanitize_text_field($_POST['hotel_name']);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'hotel_name'));

            $data['description'] = sanitize_text_field($_POST['address']);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'address'));

            $data['description'] = sanitize_text_field($_POST['phone']);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'phone'));

            $data['description'] = sanitize_text_field($_POST['email']);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'email'));

            $data['description'] = sanitize_text_field($_POST['admin_notification']);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'admin_notification'));

            $data['description'] = sanitize_text_field($_POST['customer_notification']);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'customer_notification'));

            $data['description'] = sanitize_text_field($_POST['country_id']);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'country_id'));

            $data['description'] = sanitize_text_field($_POST['currency_location']);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'currency_location'));

            $data['description'] = sanitize_text_field($_POST['vat_percentage']);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'vat_percentage'));

            $data['description'] = sanitize_text_field($_POST['logo_url']);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'logo_url'));
        }

        /**
         *
         * Method to save payment settings
         *
         */
        public static function has_save_payment_settings()
        {
            global $wpdb;

            /**
             *
             * Saving PayPal settings
             *
             */
            $paypal_array = array();
            $paypal_data['active'] = sanitize_text_field($_POST['paypal_active_status']);
            $paypal_data['mode'] = sanitize_text_field($_POST['paypal_mode']);
            $paypal_data['sandbox_client_id'] = sanitize_text_field($_POST['paypal_sandbox_client_id']);
            $paypal_data['production_client_id'] = sanitize_text_field($_POST['paypal_production_client_id']);
            $paypal_data['currency'] = sanitize_text_field($_POST['paypal_currency']);
            array_push($paypal_array,
                $paypal_data);
            $paypal_json = json_encode($paypal_array);
            $data['description'] = sanitize_text_field($paypal_json);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'paypal'));

            /**
             *
             * Saving Stripe settings
             *
             */
            $stripe_array = array();
            $stripe_data['active'] = sanitize_text_field($_POST['stripe_active_status']);
            $stripe_data['testmode'] = sanitize_text_field($_POST['stripe_test_mode']);
            $stripe_data['public_test_key'] = sanitize_text_field($_POST['stripe_public_test_key']);
            $stripe_data['secret_test_key'] = sanitize_text_field($_POST['stripe_secret_test_key']);
            $stripe_data['public_live_key'] = sanitize_text_field($_POST['stripe_public_live_key']);
            $stripe_data['secret_live_key'] = sanitize_text_field($_POST['stripe_secret_live_key']);
            $stripe_data['currency'] = sanitize_text_field($_POST['stripe_currency']);
            array_push($stripe_array,
                $stripe_data);
            $stripe_json = json_encode($stripe_array);
            $data['description'] = sanitize_text_field($stripe_json);
            $wpdb->update($wpdb->prefix . 'hotel_has_settings',
                $data,
                array('type' => 'stripe'));
        }

        /**
         *
         * Method to get settings values from database
         * @param $type string
         * @return mixed
         */
        public static function has_get_settings($type)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_settings';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `type` = '$type'",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['description'];
            }
        }

        /**
         *
         * Method to get currency symbol and it's position
         * @param $amount integer
         * @return string
         */
        public static function has_currency($amount)
        {
            global $wpdb;
            $plugin_country_id = self::has_get_settings('country_id');
            $currency_location = self::has_get_settings('currency_location');
            $table = $wpdb->prefix . 'hotel_has_country';
            $currency_symbol = $wpdb->get_var($wpdb->prepare("SELECT currency_symbol FROM $table WHERE country_id = %d",
                $plugin_country_id));

            if ($currency_location == 'left') {
                $currency_string = $currency_symbol . $amount;
            } else if ($currency_location == 'right') {
                $currency_string = $amount . $currency_symbol;
            }

            return $currency_string;
        }

        /**
         *
         * Method to get currency symbol
         * @return string
         */
        public static function has_get_currency_symbol()
        {
            global $wpdb;
            $plugin_country_id = self::has_get_settings('country_id');
            $table = $wpdb->prefix . 'hotel_has_country';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `country_id` = '$plugin_country_id'",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row['currency_symbol'];
            }
        }

        /**
         *
         * Method to get country list from database
         * @return array
         *
         */
        public static function has_get_countries()
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_country';
            $query_result = $wpdb->get_results("SELECT * FROM $table",
                ARRAY_A);
            return $query_result;
        }

        /**
         *
         * Method to get synchronization data from database
         * @param $room_type_id integer
         * @param $type string
         * @return mixed
         */
        public static function has_get_sync_data($room_type_id,
                                                 $type)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_sync';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_type_id` = $room_type_id AND `type` = '$type'",
                ARRAY_A);
            foreach ($query_result as $row) {
                return $row;
            }
        }


        /**
         *
         * Method to save synchronization data from Sync page
         *
         */
        public static function has_save_sync_data()
        {
            global $wpdb;

            $room_type_id = sanitize_text_field($_POST['room_type_id']);

            $airbnb_url = $_POST['airbnb_url'];
            $airbnb_status = sanitize_text_field($_POST['airbnb_status']);
            $airbnb_sync_time = sanitize_text_field($_POST['airbnb_sync_time']);

            $google_url = $_POST['google_url'];
            $google_status = sanitize_text_field($_POST['google_status']);
            $google_sync_time = sanitize_text_field($_POST['google_sync_time']);

            $booking_com_url = $_POST['booking_com_url'];
            $booking_com_status = sanitize_text_field($_POST['booking_com_status']);
            $booking_com_sync_time = sanitize_text_field($_POST['booking_com_sync_time']);

            if (self::has_get_sync_data($room_type_id, 'airbnb_feed')) {
                $wpdb->update($wpdb->prefix . 'hotel_has_sync',
                    array('description' => $airbnb_url),
                    array('room_type_id' => $room_type_id, 'type' => 'airbnb_feed'));
                $wpdb->update($wpdb->prefix . 'hotel_has_sync',
                    array('status' => $airbnb_status),
                    array('room_type_id' => $room_type_id, 'type' => 'airbnb_feed'));
                $wpdb->update($wpdb->prefix . 'hotel_has_sync',
                    array('sync_time' => $airbnb_sync_time),
                    array('room_type_id' => $room_type_id, 'type' => 'airbnb_feed'));
            } else {
                $wpdb->insert($wpdb->prefix . 'hotel_has_sync',
                    array('room_type_id' => $room_type_id,
                          'type' => 'airbnb_feed',
                          'description' => $airbnb_url,
                          'status' => $airbnb_status,
                          'sync_time' => $airbnb_sync_time));
            }

            if (self::has_get_sync_data($room_type_id, 'google_feed')) {
                $wpdb->update($wpdb->prefix . 'hotel_has_sync',
                    array('description' => $google_url),
                    array('room_type_id' => $room_type_id, 'type' => 'google_feed'));
                $wpdb->update($wpdb->prefix . 'hotel_has_sync',
                    array('status' => $google_status),
                    array('room_type_id' => $room_type_id, 'type' => 'google_feed'));
                $wpdb->update($wpdb->prefix . 'hotel_has_sync',
                    array('sync_time' => $google_sync_time),
                    array('room_type_id' => $room_type_id, 'type' => 'google_feed'));
            } else {
                $wpdb->insert($wpdb->prefix . 'hotel_has_sync',
                    array('room_type_id' => $room_type_id,
                          'type' => 'google_feed',
                          'description' => $google_url,
                          'status' => $google_status,
                          'sync_time' => $google_sync_time));
            }

            if (self::has_get_sync_data($room_type_id, 'booking_com_feed')) {
                $wpdb->update($wpdb->prefix . 'hotel_has_sync',
                    array('description' => $booking_com_url),
                    array('room_type_id' => $room_type_id, 'type' => 'booking_com_feed'));
                $wpdb->update($wpdb->prefix . 'hotel_has_sync',
                    array('status' => $booking_com_status),
                    array('room_type_id' => $room_type_id, 'type' => 'booking_com_feed'));
                $wpdb->update($wpdb->prefix . 'hotel_has_sync',
                    array('sync_time' => $booking_com_sync_time),
                    array('room_type_id' => $room_type_id, 'type' => 'booking_com_feed'));
            } else {
                $wpdb->insert($wpdb->prefix . 'hotel_has_sync',
                    array('room_type_id' => $room_type_id,
                        'type' => 'booking_com_feed',
                        'description' => $booking_com_url,
                        'status' => $booking_com_status,
                        'sync_time' => $booking_com_sync_time));
            }
        }

    }
}
