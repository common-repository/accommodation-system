<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

if (!class_exists('MasterSync')){

    class MasterSync extends Controller{

        /**
         *
         * Constructor called when MasterSync class instance is created.
         *
         */
        function __construct()
        {

        }

        /**
         *
         * Call sync methods to add reservations from external sources
         *
         * variable: $controller (class instance)
         *           $method (class instance)
         *
         * function: has_get_room_type()
         *           has_get_sync_data()
         *           airbnb_sync()
         *           google_sync()
         *           booking_com_sync()
         *
         */
        function sync(){
            $controller = new Controller();
            include $controller->plugin_path . 'includes/models/methods-api.php';
            include $controller->plugin_path . 'includes/sync/airbnb-sync.php';
            include $controller->plugin_path . 'includes/sync/google-sync.php';
            include $controller->plugin_path . 'includes/sync/booking-com-sync.php';
            $method = new Methods();
            $room_types = $method::has_get_rooms_for_sync();
            if(!empty($room_types)) {
                foreach ($room_types as $room_type) {
                    $room_type_id = $room_type['room_id'];
                    $airbnb_data = $method->has_get_sync_data($room_type_id, 'airbnb_feed');
                    $airbnb_url = $airbnb_data['description'];
                    $airbnb_status = $airbnb_data['status'];
                    $airbnb_sync_time = $airbnb_data['sync_time'];
                    $airbnb_last_updated = $airbnb_data['last_updated'];

                    $airbnb_update = (strtotime(date('Y-m-d H:i:s')) - strtotime($airbnb_last_updated)) >= $airbnb_sync_time ? 'true' : 'false';

                    if ($airbnb_status == '1' && $airbnb_update === 'true') {
                        $airbnb_reservations = new AirBnBSync();
                        $airbnb_reservations->airbnb_sync($room_type_id, $airbnb_url);
                    }

                    $google_data = $method->has_get_sync_data($room_type_id, 'google_feed');
                    $google_url = $google_data['description'];
                    $google_status = $google_data['status'];
                    $google_sync_time = $google_data['sync_time'];
                    $google_last_updated = $google_data['last_updated'];

                    $google_update = (strtotime(date('Y-m-d H:i:s')) - strtotime($google_last_updated)) >= $google_sync_time ? 'true' : 'false';

                    if ($google_status == '1' && $google_update === 'true') {
                        $google_reservations = new GoogleSync();
                        $google_reservations->google_sync($room_type_id, $google_url);
                    }

                    $booking_com_data = $method->has_get_sync_data($room_type_id, 'booking_com_feed');
                    $booking_com_url = $booking_com_data['description'];
                    $booking_com_status = $booking_com_data['status'];
                    $booking_com_sync_time = $booking_com_data['sync_time'];
                    $booking_com_last_updated = $booking_com_data['last_updated'];

                    $booking_com_update = (strtotime(date('Y-m-d H:i:s')) - strtotime($booking_com_last_updated)) >= $booking_com_sync_time ? 'true' : 'false';

                    if ($booking_com_status == '1' && $booking_com_update === 'true') {
                        $booking_com_reservations = new BookingComSync();
                        $booking_com_reservations->booking_com_sync($room_type_id, $booking_com_url);
                    }

                }
            }

        }

        /**
         *
         * generate .ics (iCal) file to be exported for booking platforms
         *
         */
        function generate_ical($room_id){
            $name = 'calendar';
            $slug = strtolower(str_replace(array(' ', "'", '.'), array('_', '', ''), $name));
            header("Content-Type: text/Calendar; charset=utf-8");
            header("Content-Disposition: inline; filename={$slug}.ics");
            echo "BEGIN:VCALENDAR\n";
            echo "PRODID:-//HAS//EN\n";
            echo "CALSCALE:GREGORIAN\n";
            echo "VERSION:2.0\n";
            echo "X-WR-TIMEZONE:UTC\n";
            echo "METHOD:PUBLISH\n"; // requied by Outlook

            global $wpdb;
            $table = $wpdb->prefix . 'hotel_has_booking_room';
            $query_result = $wpdb->get_results("SELECT * FROM $table WHERE `room_id` = $room_id",
                ARRAY_A);
            foreach ($query_result as $key => $row) {
                $booking_id = $row['booking_id'];
                $table = $wpdb->prefix . 'hotel_has_booking';
                $booking = $wpdb->get_results("SELECT * FROM $table WHERE `booking_id` = $booking_id",
                    ARRAY_A);

                    /**
                     * Get the event ID
                     */
                    $event_id = $booking[0]['booking_id'];
                    /**
                     * If no event ID or event_id is not an integer, do nothing
                     */
                    if ( !$event_id || !is_numeric( $event_id ) ) {
                        die();
                    }
                    /**
                     * Event information
                     */
                    //$event = get_event($event_id);
                    $event = array(
                        'event_name' => $booking[0]['name'],
                        'event_description' => $booking[0]['summary'],
                        'event_start' => $row['checkin_timestamp'],
                        'event_end' => $row['checkout_timestamp'],
                        'event_venue' => array(
                            'venue_name' => 'Test Venue',
                            'venue_address' => $booking[0]['address'],
                            'venue_address_two' => 'none',
                            'venue_city' => 'none',
                            'venue_state' => 'none',
                            'venue_postal_code' => 'none'
                        )
                    );

                    $venue = $event['event_venue'];
                    $location = $venue['venue_address'];
                    $start = date('Ymd', $event['event_start']);
                    $end = date('Ymd', $event['event_end']);
                    $description = $event['event_description'];
                    $guest_name = $event['event_name'];

                    echo "BEGIN:VEVENT\n";
                    echo "UID:".date('Ymd').'T'.date('His')."-".rand()."\n"; // required by Outlok
                    echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n"; // required by Outlook
                    echo "DTSTART;VALUE=DATE:{$start}\n";
                    echo "DTEND;VALUE=DATE:{$end}\n";
                    echo "LOCATION:{$location}\n";
                    echo "SUMMARY:{$guest_name}\n";
                    echo "DESCRIPTION: {$description}\n";
                    echo "END:VEVENT\n";


            }
            echo "END:VCALENDAR\n";


        }


    }

}