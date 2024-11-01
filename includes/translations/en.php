<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('EnLang')){
        class EnLang{

            function __construct(){
            }

            public function en_lang(){
                self::create_en_table();
                self::add_en_data();
            }

            private static function create_en_table(){
                global $wpdb;
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

                $en_lang = $wpdb->prefix . 'hotel_has_en_lang';
                $sql = "CREATE TABLE IF NOT EXISTS $en_lang (
                                `text_id` int(11) NOT NULL AUTO_INCREMENT,
                                `page` longtext COLLATE utf8_unicode_ci NOT NULL,
                                `default` longtext COLLATE utf8_unicode_ci NOT NULL,
                                `description` longtext COLLATE utf8_unicode_ci NOT NULL,
                                PRIMARY KEY (`text_id`)
                              ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
                dbDelta($sql);
            }

            private static function add_en_data(){
                global $wpdb;
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

                $en_lang = $wpdb->prefix . 'hotel_has_en_lang';
                $wpdb->get_results("SELECT * FROM $en_lang");
                if ($wpdb->num_rows == 0){
                    $sql = "INSERT INTO $en_lang (`page`, `default`, `description`) VALUES 
                               ('RECEPTION', 'Reception', 'Reception'),
                               ('RECEPTION','Reservations', 'Reservations'),
                               ('RECEPTION', 'Filter', 'Filter'),
                               ('RECEPTION', 'Booking status', 'Booking status'),
                               ('RECEPTION', 'Reservation', 'Reservation'),
                               ('RECEPTION', 'Completed', 'Completed'),
                               ('RECEPTION', 'By name', 'By name'),
                               ('RECEPTION', 'By date', 'by date'),
                               ('RECEPTION', 'Date range', 'Date range'),
                               ('RECEPTION', 'Today', 'Today'),
                               ('RECEPTION', 'Tomorrow', 'Tomorrow'),
                               ('RECEPTION', 'Next 7 Days', 'Next 7 Days'),
                               ('RECEPTION', 'This Month', 'This Month'),
                               ('RECEPTION', 'Next Month', 'Next Month'),
                               ('RECEPTION', 'Next 6 Months', 'Next 6 Months'),
                               ('RECEPTION', 'Yesterday', 'Yesterday'),
                               ('RECEPTION', 'Last 7 Days', 'Last 7 Days'),
                               ('RECEPTION', 'Last Month', 'Last Month'),
                               ('RECEPTION', 'Last 6 Months', 'Last 6 Months'),
                               ('RECEPTION', 'Create booking', 'Create booking'),
                               ('RECEPTION', 'Details', 'Details'),
                               ('RECEPTION', 'Booking ID', 'Booking ID'),
                               ('RECEPTION', 'Date', 'Date'),
                               ('RECEPTION', 'Status', 'Status'),
                               ('RECEPTION', 'Guest', 'Guest'),
                               ('RECEPTION', 'Total', 'Total'),
                               ('RECEPTION', 'bookings found', 'bookings found'),
                               ('RECEPTION', 'ID', 'ID'),
                               ('RECEPTION', 'Pending', 'Pending'),
                               ('RECEPTION', 'Approved', 'Approved'),
                               ('RECEPTION', 'Canceled', 'Canceled'),
                               ('RECEPTION', 'Created by', 'Created by'),
                               ('RECEPTION', 'Guest detail', 'Guest detail'),
                               ('RECEPTION', 'Name', 'Name'),
                               ('RECEPTION', 'Click on a booking from list or from calendar, to view details', 'Click on a booking from list or from calendar, to view details'),
                               ('RECEPTION', 'Email', 'Email'),
                               ('RECEPTION', 'Address', 'Address'),
                               ('RECEPTION', 'Phone', 'Phone'),
                               ('RECEPTION', 'guests', 'guests'),
                               ('RECEPTION', 'nights', 'nights'),
                               ('RECEPTION', 'Total guests', 'Total guests'),
                               ('RECEPTION', 'Summary', 'Summary'),
                               ('RECEPTION', 'Edit', 'Edit'),
                               ('RECEPTION', 'Payment', 'Payment'),
                               ('RECEPTION', 'Room allocation', 'Room allocation'),
                               ('RECEPTION', 'Services selected', 'Services selected'),
                               ('RECEPTION', 'Invoice', 'Invoice'),
                               ('RECEPTION', 'Room Pricing', 'Room Pricing'),
                               ('RECEPTION', 'Service Pricing', 'Service Pricing'),
                               ('RECEPTION', 'V.A.T', 'V.A.T'),
                               ('RECEPTION', 'Total payable', 'Total payable'),
                               ('RECEPTION', 'Paid', 'Paid'),
                               ('RECEPTION', 'Guest name or phone', 'Guest name or phone'),
                               ('RECEPTION', 'Name or phone number', 'Name or phone number'),
                               ('RECEPTION', 'Filter booking', 'Filter booking'),
                               ('RECEPTION', 'Booking detail', 'Booking detail'),
                               ('RECEPTION', 'Guest name', 'Guest name'),
                               ('RECEPTION', 'Checkin date', 'Checkin date'),
                               ('RECEPTION', 'Checkout date', 'Checkout date'),
                               ('RECEPTION', 'Room allocation', 'Room allocation'),
                               ('RECEPTION', 'Search', 'Search'),
                               ('RECEPTION', 'Available rooms', 'Available rooms'),
                               ('RECEPTION', '+ Add room', '+ Add room'),
                               ('RECEPTION', 'Room', 'Room'),
                               ('RECEPTION', 'Update', 'Update'),
                               ('RECEPTION', 'Price', 'Price'),
                               ('RECEPTION', 'Hotel Service', 'Hotel Service'),
                               ('RECEPTION', 'Night', 'Night'),
                               ('RECEPTION', 'Name must be filled up!', 'Name must be filled up!'),
                               ('RECEPTION', 'There is no room allocated for this reservation. Please add a room.', 'There is no room allocated for this reservation. Please add a room.'),
                               ('RECEPTION', 'There are no selected rooms', 'There are no selected rooms'),
                               ('RECEPTION', 'Reservation added successfully', 'Reservation added successfully'),
                               ('RECEPTION', 'Reservation updated successfully', 'Reservation updated successfully'),
                               ('RECEPTION', 'Reservation deleted successfully', 'Reservation deleted successfully'),
                               ('RECEPTION', 'Payment completed', 'Payment completed'),
                               ('RECEPTION', 'Amount must be filled up', 'Amount must be filled up'),
                               ('RECEPTION', 'Booking added', 'Booking added'),
                               ('RECEPTION', 'Are you sure to delete this booking?', 'Are you sure to delete this booking?'),
                               ('RECEPTION', 'Deleted data cannot be recovered.', 'Deleted data cannot be recovered.'),
                               ('RECEPTION', 'Room Availability & Status', 'Room Availability & Status'),
                               ('RECEPTION', 'Create room types, and rooms to watch availability', 'Create room types, and rooms to watch availability'),
                               ('RECEPTION', 'Select room type', 'Select room type'),
                               ('RECEPTION', 'All room types', 'All room types'),
                               ('RECEPTION', 'Select a room', 'Select a room'),
                               ('RECEPTION', 'Booking status of room', 'Booking status of room'),
                               ('RECEPTION', 'Payable amount', 'Payable amount'),
                               ('RECEPTION', 'Payment history', 'Payment history'),
                               ('RECEPTION', 'Due', 'Due'),
                               ('RECEPTION', 'Unit', 'Unit'),
                               ('RECEPTION', 'Total', 'Total'),
                               ('RECEPTION', 'Take payment', 'Take payment'),
                               ('RECEPTION', 'Payment date', 'Payment date'),
                               ('RECEPTION', 'Close', 'Close'),                                
                               ('ROOMS', 'Rooms', 'Rooms'),
                               ('ROOMS', 'Manage Room', 'Manage Room'),
                               ('ROOMS', 'Filter', 'Filter'),
                               ('ROOMS', 'Total', 'Total'),
                               ('ROOMS', 'rooms found', 'rooms found'),
                               ('ROOMS', 'First you need to create the room type', 'First you need to create the room type'),
                               ('ROOMS', 'Name', 'Name'),
                               ('ROOMS', 'Type', 'Type'),
                               ('ROOMS', 'Floor', 'Floor'),
                               ('ROOMS', 'Edit', 'Edit'),
                               ('ROOMS', 'Delete', 'Delete'),
                               ('ROOMS', '+ Add new room', '+ Add new room'),
                               ('ROOMS', 'Floor - all', 'Floor - all'),
                               ('ROOMS', 'Manage Room Type', 'Manage Room Type'),
                               ('ROOMS', 'Capacity', 'Capacity'),
                               ('ROOMS', 'Price', 'Price'),
                               ('ROOMS', '+ Add new room type', '+ Add new room type'),
                               ('ROOMS', 'Manage Floor', 'Manage Floor'),
                               ('ROOMS', 'Note', 'Note'),
                               ('ROOMS', '+ Add new floor', '+ Add new floor'),
                               ('ROOMS', 'e.g. 1st floor', 'e.g. 1st floor'),
                               ('ROOMS', 'Floor name', 'Floor name'),
                               ('ROOMS', 'Create floor', 'Create floor'),
                               ('ROOMS', 'Close', 'Close'),
                               ('ROOMS', 'Are you sure?', 'Are you sure?'),
                               ('ROOMS', 'Delete', 'Delete'),
                               ('ROOMS', 'e.g. deluxe', 'e.g. deluxe'),
                               ('ROOMS', 'Featured image', 'Featured image'),
                               ('ROOMS', 'Select image', 'Select image'),
                               ('ROOMS', 'Guest capacity', 'Guest capacity'),
                               ('ROOMS', 'Hold ctrl(on windows) or cmd(on mac) and select multiple', 'Hold ctrl(on windows) or cmd(on mac) and select multiple'),
                               ('ROOMS', 'e.g. $50', 'e.g. $50'),
                               ('ROOMS', 'Basic price', 'Basic price'),
                               ('ROOMS', 'Create room type', 'Create room type'),
                               ('ROOMS', 'Room type', 'Room type'),
                               ('ROOMS', 'Room name', 'Room name'),
                               ('ROOMS', 'e.g. 308, 102', 'e.g. 308, 102'),
                               ('ROOMS', 'Create room', 'Create room'),
                               ('ROOMS', 'Floors', 'Floors'),
                               ('ROOMS', 'Bed(s)', 'Bed(s)'),
                                ('ROOMS', 'Permissions', 'Permissions'),
                               ('ROOMS', 'You need to add a basic price!', 'You need to add a basic price!'),
                               ('ROOMS', 'Room type added successfully', 'Room type added successfully'),
                               ('ROOMS', 'Room added successfully', 'Room added successfully'),
                               ('ROOMS', 'Floor added successfully', 'Floor added successfully'),
                               ('ROOMS', 'Room type updated successfully', 'Room type updated successfully'),
                               ('ROOMS', 'Room updated successfully', 'Room updated successfully'),
                               ('ROOMS', 'Floor updated successfully', 'Floor updated successfully'),
                               ('ROOMS', 'Are you sure ?', 'Are you sure ?'),
                               ('ROOMS', 'Room deleted successfully', 'Room deleted successfully'),
                               ('ROOMS', 'Room type deleted successfully', 'Room type deleted successfully'),
                               ('ROOMS', 'Floor deleted successfully', 'Floor deleted successfully'),
                               ('SCHEDULE', 'Schedule', 'Schedule'),
                               ('SCHEDULE', 'Create room types to set custom prices', 'Create room types to set custom prices'),
                               ('SCHEDULE', 'Room Pricing Management', 'Room Pricing Management'),
                               ('SCHEDULE', 'Select room type', 'Select room type'),
                               ('SCHEDULE', 'Price manager', 'Price manager'),
                               ('SCHEDULE', 'Room type', 'Room type'),
                               ('SCHEDULE', 'Base price', 'Base price'),
                               ('SCHEDULE', 'Year', 'Year'),
                               ('SCHEDULE', 'Create custom price', 'Create custom price'),
                               ('SCHEDULE', 'Reset custom price', 'Reset custom price'),
                               ('SCHEDULE', 'Set week days', 'Set week days'),
                               ('SCHEDULE', 'Monday', 'Monday'),
                               ('SCHEDULE', 'Tuesday', 'Tuesday'),
                               ('SCHEDULE', 'Wednesday', 'Wednesday'),
                               ('SCHEDULE', 'Thursday', 'Thursday'),
                               ('SCHEDULE', 'Friday', 'Friday'),
                               ('SCHEDULE', 'Saturday', 'Saturday'),
                               ('SCHEDULE', 'Remove custom price', 'Remove custom price'),
                               ('SCHEDULE', 'Delete custom pricing', 'Delete custom pricing'),
                               ('SCHEDULE', 'Sunday', 'Sunday'),
                               ('SCHEDULE', 'Set price', 'Set price'),
                               ('SCHEDULE', 'Date from', 'Date from'),
                               ('SCHEDULE', 'Month/Date', 'Month/Date'),
                               ('SCHEDULE', 'Date to', 'Date to'),
                               ('SCHEDULE', 'New price', 'New price'),
                               ('SCHEDULE', 'Create custom pricing', 'Create custom pricing'),
                               ('SCHEDULE', 'Close', 'Close'),
                               ('SCHEDULE', 'Pricing updated!', 'Pricing updated!'),
                               ('SCHEDULE', 'Room updated', 'Room updated'),
                               ('SCHEDULE', 'Update room', 'Update room'),
                               ('SCHEDULE', 'Deleted!', 'Deleted!'),
                               ('OPTIONS', 'Options', 'Options'),
                               ('OPTIONS', 'Manage Services', 'Manage Services'),
                               ('OPTIONS', 'Services', 'Services'),
                               ('OPTIONS', 'Service added successfully', 'Service added successfully'),
                               ('OPTIONS', 'Amenity added successfully', 'Amenity added successfully'),
                               ('OPTIONS', 'Service updated successfully', 'Service updated successfully'),
                               ('OPTIONS', 'Amenity updated successfully', 'Amenity updated successfully'),
                               ('OPTIONS', 'Amenities', 'Amenities'),
                               ('OPTIONS', 'Type', 'Type'),
                               ('OPTIONS', 'Price', 'Price'),
                               ('OPTIONS', 'Edit', 'Edit'),
                               ('OPTIONS', 'Delete', 'Delete'),
                               ('OPTIONS', 'Amenity deleted successfully', 'Amenity deleted successfully'),
                               ('OPTIONS', 'Service deleted successfully', 'Service deleted successfully'),
                               ('OPTIONS', 'Add new service', 'Add new service'),
                               ('OPTIONS', 'Add new amenity', 'Add new amenity'),
                               ('OPTIONS', 'e.g. airport pickup', 'e.g. airport pickup'),
                               ('OPTIONS', 'Service name', 'Service name'),
                               ('OPTIONS', 'Price/Unit price', 'Price/Unit price'),
                               ('OPTIONS', 'Add fixed price', 'Add fixed price'),
                               ('OPTIONS', 'Multiply number of guests', 'Multiply number of guests'),
                               ('OPTIONS', 'Multiply number of nights', 'Multiply number of nights'),
                               ('OPTIONS', 'Create service', 'Create service'),
                               ('OPTIONS', 'Close', 'Close'),
                               ('OPTIONS', 'Service added', 'Service added'),
                               ('OPTIONS', 'Service updated', 'Service updated'),
                               ('OPTIONS', 'Manage Amenities', 'Manage Amenities'),
                               ('OPTIONS', 'Description', 'Description'),
                               ('OPTIONS', 'e.g. 1st amenity', 'e.g. 1st amenity'),
                               ('OPTIONS', 'Amenity name', 'Amenity name'),
                               ('OPTIONS', 'Create amenity', 'Create amenity'),
                               ('SETTINGS', 'Settings', 'Settings'),
                               ('SETTINGS', 'Hotel Settings', 'Hotel Settings'),
                               ('SETTINGS', 'General settings', 'General settings'),
                               ('SETTINGS', 'General', 'General'),
                               ('SETTINGS', 'General settings updated', 'General settings updated'),
                               ('SETTINGS', 'Payment settings updated', 'Payment settings updated'),
                               ('SETTINGS', 'Payment', 'Payment'),
                               ('SETTINGS', 'Style', 'Style'),
                               ('SETTINGS', 'Hotel name', 'Hotel name'),
                               ('SETTINGS', 'Phone', 'Phone'),
                               ('SETTINGS', 'Currency', 'Currency'),
                               ('SETTINGS', 'Vat Percentage', 'Vat Percentage'),
                               ('SETTINGS', 'Enable admin notification', 'Enable admin notification'),
                               ('SETTINGS', 'Enable user notification', 'Enable user notification'),
                               ('SETTINGS', 'Address', 'Address'),
                               ('SETTINGS', 'Email', 'Email'),
                               ('SETTINGS', 'Currency position', 'Currency position'),
                               ('SETTINGS', 'Yes', 'Yes'),
                               ('SETTINGS', 'No', 'No'),
                               ('SETTINGS', 'Left', 'Left'),
                               ('SETTINGS', 'Right', 'Right'),
                               ('SETTINGS', 'Select logo', 'Select logo'),
                               ('SETTINGS', 'Update settings', 'Update settings'),
                               ('SETTINGS', 'PayPal settings', 'PayPal settings'),
                               ('SETTINGS', 'Active', 'Active'),
                               ('SETTINGS', 'Mode', 'Mode'),
                               ('SETTINGS', 'Sandbox', 'Sandbox'),
                               ('SETTINGS', 'Production', 'Production'),
                               ('SETTINGS', 'Sandbox client ID', 'Sandbox client ID'),
                               ('SETTINGS', 'Production client ID', 'Production client ID'),
                               ('SETTINGS', 'Currency', 'Currency'),
                               ('SETTINGS', 'Stripe settings', 'Stripe settings'),
                               ('SETTINGS', 'Test Mode', 'Test Mode'),
                               ('SETTINGS', 'On', 'On'),
                               ('SETTINGS', 'Off', 'Off'),
                               ('SETTINGS', 'Test mode public key', 'Test mode public key'),
                               ('SETTINGS', 'Test mode secret key', 'Test mode secret key'),
                               ('SETTINGS', 'Live mode public key', 'Live mode public key'),
                               ('SETTINGS', 'Live mode secret key', 'Live mode secret key'),
                               ('SYNC', 'Sync', 'Sync'),
                               ('SYNC', 'Synchronization', 'Synchronization'),
                               ('SYNC', 'Select room', 'Select room'),
                               ('SYNC', 'Year', 'Year'),
                               ('SYNC', 'AirBnB sync', 'AirBnB sync'),
                               ('SYNC', 'AirBnB feed URL', 'AirBnB feed URL'),
                               ('SYNC', 'AirBnB sync time (seconds)', 'AirBnB sync time (seconds)'),
                               ('SYNC', 'Google Calendars sync', 'Google Calendars sync'),
                               ('SYNC', 'Google Calendars feed URL', 'Google Calendars feed URL'),
                               ('SYNC', 'Google sync time (seconds)', 'Google sync time (seconds)'),
                               ('SYNC', 'Booking.com sync', 'Booking.com sync'),
                               ('SYNC', 'Booking.com feed URL', 'Booking.com feed URL'),
                               ('SYNC', 'Booking.com sync time (seconds)', 'Booking.com sync time (seconds)'),
                               ('SYNC', 'Update settings', 'Update settings'),
                               ('SYNC', 'Create room types to synchronize', 'Create room types to synchronize'),
                               ('SYNC', 'iCal feed URL', 'iCal feed URL'),
                               ('TRANSLATE', 'Translate', 'Translate'),
                               ('TRANSLATE', 'Manage Translations', 'Manage Translations'),
                               ('TRANSLATE', 'Frontend', 'Frontend'),
                               ('TRANSLATE', 'translations will be automatically saved after typing...', 'translations will be automatically saved after typing...'),
                               ('TRANSLATE', 'Translations updated', 'Translations updated'),
                               ('WALLET', 'Wallet', 'Wallet'),
                               ('WALLET', 'Payment report', 'Payment report'),
                               ('WALLET', 'Select date range', 'Select date range'),
                               ('WALLET', 'Filter', 'Filter'),
                               ('WALLET', 'Date', 'Date'),
                               ('WALLET', 'Amount', 'Amount'),
                               ('WALLET', 'Details', 'Details'),
                               ('WALLET', 'Total', 'Total'),
                               ('WALLET', 'Today', 'Today'),
                               ('WALLET', 'Yesterday', 'Yesterday'),
                               ('WALLET', 'Last 7 Days', 'Last 7 Days'),
                               ('WALLET', 'Last 30 Days', 'Last 30 Days'),
                               ('WALLET', 'This Month', 'This Month'),
                               ('WALLET', 'Last Month', 'Last Month'),
                               ('WALLET', 'Custom range', 'Custom range'),
                               ('WALLET', 'Apply', 'Apply'),
                               ('WALLET', 'Cancel', 'Cancel'),
                               ('FRONTEND', 'Select date', 'Select date'),
                               ('FRONTEND', 'Select room', 'Select room'),
                               ('FRONTEND', 'Guest details', 'Guest details'),
                               ('FRONTEND', 'Payment & confirmation', 'Payment & confirmation'),
                               ('FRONTEND', 'Check-in', 'Check-in'),
                               ('FRONTEND', 'Check-out', 'Check-out'),
                               ('FRONTEND', 'Guests', 'Guests'),
                               ('FRONTEND', 'Search Rooms', 'Search Rooms'),
                               ('FRONTEND', 'room', 'room'),
                               ('FRONTEND', 'Max Guests', 'Max Guests'),
                               ('FRONTEND', 'Room Quantity', 'Room Quantity'),
                               ('FRONTEND', 'Select this room', 'Select this room'),
                               ('FRONTEND', 'Selected Room(s)', 'Selected Room(s)'),
                               ('FRONTEND', 'Quantity', 'Quantity'),
                               ('FRONTEND', 'Price', 'Price'),
                               ('FRONTEND', 'Confirm Rooms', 'Confirm Rooms'),
                               ('FRONTEND', 'Enter your details', 'Enter your details'),
                               ('FRONTEND', 'Your name', 'Your name'),
                               ('FRONTEND', 'Phone', 'Phone'),
                               ('FRONTEND', 'Email', 'Email'),
                               ('FRONTEND', 'Total guests', 'Total guests'),
                               ('FRONTEND', 'Address', 'Address'),
                               ('FRONTEND', 'Message', 'Message'),
                               ('FRONTEND', 'Room type', 'Room type'),
                               ('FRONTEND', 'Room quantity', 'Room quantity'),
                               ('FRONTEND', 'You will be redirected to a payment page.', 'You will be redirected to a payment page.'),
                               ('FRONTEND', 'pets', 'Pets allowed'),
                               ('FRONTEND', 'no-pets', 'No pets allowed'),
                               ('FRONTEND', 'smoking', 'Smoking allowed'),
                               ('FRONTEND', 'no-smoking', 'No smoking allowed'),
                               ('FRONTEND', 'single', 'Single bed'),
                               ('FRONTEND', 'double', 'Double bed'),
                               ('FRONTEND', 'king', 'King bed'),
                               ('FRONTEND', 'queen', 'Queen bed'),
                               ('FRONTEND', 'twin', 'Twin bed'),
                               ('FRONTEND', 'couch', 'Couch'),
                               ('FRONTEND', '2xtwin', '2 x Twin beds'),
                               ('FRONTEND', '2xsingle', '2 x Single beds'),
                               ('FRONTEND', 'Total', 'Total'),
                               ('FRONTEND', 'guest', 'guest'),
                               ('FRONTEND', 'night', 'night'),
                               ('FRONTEND', 'Additional Services', 'Additional Services'),
                               ('FRONTEND', 'Confirm your booking', 'Confirm your booking'),
                               ('FRONTEND', 'Reservation completed!', 'Reservation completed!'),
                               ('FRONTEND', 'Booking Summary', 'Booking Summary'),
                               ('FRONTEND', 'Booking ID', 'Booking ID'),
                               ('FRONTEND', 'Choose a payment method', 'Choose a payment method'),
                               ('FRONTEND', 'Cash', 'Cash'),
                               ('FRONTEND', 'Pay cash on arrival', 'Pay cash on arrival'),
                               ('FRONTEND', 'Stripe', 'Stripe'),
                               ('FRONTEND', 'Pay with Stripe', 'Pay with Stripe'),
                               ('FRONTEND', 'PayPal', 'PayPal'),
                               ('FRONTEND', 'Almost done... Please choose a payment method', 'Almost done... Please choose a payment method'),
                               ('FRONTEND', 'Thanks for your payment', 'Thanks for your payment'),
                               ('FRONTEND', 'Paying with a credit card will automatically approve your reservation', 'Paying with a credit card will automatically approve your reservation'),
                               ('FRONTEND', 'Paying with PayPal will automatically approve your reservation', 'Paying with PayPal will automatically approve your reservation'),
                               ('FRONTEND', 'If you choose to pay on arrival, the reservation will be placed in pending status', 'If you choose to pay on arrival, the reservation will be placed in pending status'),
                               ('FRONTEND', 'Your reservation have just been confirmed. If you have any questions, please do not hesitate to contact us. Thank you!', 'Your reservation have just been confirmed. If you have any questions, please do not hesitate to contact us. Thank you!');";

                    dbDelta($sql);
                }
            }

        }
    }