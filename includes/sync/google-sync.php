<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('GoogleSync')){

        class GoogleSync extends Controller{

            function __construct(){
                parent::__construct();
            }

            public function google_sync($room_type_id,
                                        $google_url){
                $controller     = new Controller;
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method         = new Methods;
                $ical           = new HASiCal($google_url);
                $events         = $ical->eventsByDate();
                global $wpdb;

                foreach ($events as $date => $events){
                    foreach ($events as $event){
                        $check_in = strtotime($event->dateStart);
                        $check_out = strtotime($event->dateEnd);
                        $location = $event -> location;
                        $summary = $event->summary;
                        $description = $event->description;
                        global $wpdb;

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

                                if ($check_in >= $row2['checkin_timestamp'] && $check_in < $row2['checkout_timestamp']){
                                    $exclude_flag = true;
                                    break;
                                }
                                if ($check_out > $row2['checkin_timestamp'] && $check_out <= $row2['checkout_timestamp']){
                                    $exclude_flag = true;
                                    break;
                                }
                                if ($check_in <= $row2['checkin_timestamp'] && $check_out >= $row2['checkout_timestamp']){
                                    $exclude_flag = true;
                                    break;
                                }

                            endforeach;

                            /** Exclude this room, as it is not available */
                            if ($exclude_flag == true){
                                continue;
                            }
                            else{
                                /** insert in the booking_room table */
                                $method->has_create_booking_google('google',
                                                                    $check_in,
                                                                    $check_out,
                                                                    $room_type_id,
                                                                    $location,
                                                                    $summary,
                                                                    $description);
                            }

                    }
                }

                $wpdb->update($wpdb->prefix . 'hotel_has_sync',
                    array('last_updated' => date('Y-m-d H:i:s')),
                    array('room_type_id' => $room_type_id, 'type' => 'google_feed'));

            }

        }
    }