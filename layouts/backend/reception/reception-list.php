<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ReceptionList')){
        class ReceptionList extends Reception{

            function __construct(){
                parent::__construct();
            }

            public static function reception_list_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $status = sanitize_text_field($_POST['param1']);
                $filter_date_from = sanitize_text_field($_POST['param2']);
                $filter_date_to = sanitize_text_field($_POST['param3']);
                $guest = sanitize_text_field($_POST['param4']);
                $filter_timestamp_from = strtotime($filter_date_from);
                $filter_timestamp_to = strtotime($filter_date_to);
                ?>


                <!-- Booking numbers-->
                <div class="row" style="clear: both;">
                    <div class="col-md-12">
                        <!-- Booking listing table -->
                        <table class="table table-striped table-hover ">
                            <thead class="thead-dark">
                            <tr>
                                <th><?php echo $txt->txt("Booking ID") ?></th>
                                <th><?php echo $txt->txt("Date") ?></th>
                                <th><?php echo $txt->txt("Status") ?></th>
                                <th><?php echo $txt->txt("Guest") ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $counter = 0;
                                global $wpdb;
                                $booking = $wpdb->prefix . 'hotel_has_booking';
                                $query_result = $wpdb->get_results("SELECT * FROM `$booking` WHERE status = 2 OR status = 1 OR status = 3",
                                                                   ARRAY_A);
                                if ($guest != ''){
                                    $query_result = $wpdb->get_results("SELECT * FROM `$booking` WHERE status = true AND (name LIKE '%$guest%' OR phone LIKE '%$guest%') ",
                                                                       ARRAY_A);
                                }
                                foreach ($query_result as $row):
                                    // Finding the room allocation date range
                                    $booking_id = $row['booking_id'];
                                    $booking_room_table = $wpdb->prefix . 'hotel_has_booking_room';
                                    $room_allocation_minimum_timestamp = $wpdb->get_var("SELECT MIN(checkin_timestamp) FROM $booking_room_table WHERE booking_id = $booking_id");
                                    $room_allocation_maximum_timestamp = $wpdb->get_var("SELECT MAX(checkout_timestamp) FROM $booking_room_table WHERE booking_id = $booking_id");

                                    // Check if this booking is within the filtered date range
                                    if ($status != 2){
                                        $flag = 0;
                                        if ($room_allocation_minimum_timestamp >= $filter_timestamp_from && $room_allocation_minimum_timestamp <= $filter_timestamp_to){
                                            $flag = 1;
                                        }
                                        if ($room_allocation_maximum_timestamp >= $filter_timestamp_from && $room_allocation_maximum_timestamp <= $filter_timestamp_to){
                                            $flag = 1;
                                        }
                                        if ($room_allocation_minimum_timestamp <= $filter_timestamp_from && $room_allocation_maximum_timestamp >= $filter_timestamp_to){
                                            $flag = 1;
                                        }
                                        if ($flag == 0){
                                            continue;
                                        }
                                    }

                                    ?>
                                    <tr style="cursor: pointer;" class="" id="row_<?php echo $row['booking_id']; ?>"
                                        onClick="load_booking('<?php echo $row['booking_id']; ?>')">

                                        <td><?php echo $row['booking_id']; ?></td>
                                        <td style="font-size:11px;">
                                            <?php echo date("d M",
                                                            $room_allocation_minimum_timestamp); ?> -
                                            <?php echo date("d M",
                                                            $room_allocation_maximum_timestamp); ?>
                                        </td>
                                        <td>
                                            <?php
                                                if ($row['status'] == '1'){
                                                    ?><span class="reservation_status<?php echo $row['status'];?>"><?php echo $txt->txt("Pending") ?></span><?php
                                                }
                                                else if ($row['status'] == '2'){
                                                    ?><span class="reservation_status<?php echo $row['status'];?>"><?php echo $txt->txt("Approved") ?></span><?php
                                                }
                                                else if ($row['status'] == '3'){
                                                    ?><span class="reservation_status<?php echo $row['status'];?>"><?php echo $txt->txt("Canceled") ?></span><?php
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $row['name']; ?></td>
                                    </tr>
                                    <?php
                                    ++$counter;
                                endforeach;

                            ?>
                            </tbody>
                        </table>
                        <h6><i class="fa fa-bars"></i>
                             <?php echo $txt->txt('Total') . ' ' . $counter . ' ' . $txt->txt("bookings found") ?></h6>
                    </div>
                </div>
                <hr style="margin:5px 0px;">


                <style type="text/css">
                    .status_selector{
                        margin: 2px;
                    }
                </style>

                <script>

                    // Show a single booking detail by clicking on a single booking list item
                    function load_booking(booking_id){
                        jQuery(".info")
                        .removeClass("info");
                        jQuery("#row_"+booking_id)
                        .addClass("info");
                        has_ajax_call('reception-summary',
                                      'false',
                                      'false',
                                      'booking_detail_top',
                                      booking_id);
                    }

                    // Loading the first booking from list.
                    // If any booking is targetted to show after add / update, it will be selected
                    jQuery(document)
                    .ready(function(){
                        /*if (load_booking_id > 0) {
                            load_booking(load_booking_id);
                        }
                        else {
                            load_booking(first_booking_id);
                        }*/
                    });


                </script> <?php
            }

        }
    }