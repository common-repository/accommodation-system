<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Schedule')){
        class Schedule extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function schedule_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <div class="row" style="margin:20px;">
                    <div class="panel panel-primary">
                        <div class="main-body-section">
                            <h3 class="panel-title"><?php echo $txt->txt("Room Pricing Management") ?></h3>
                        </div>
                        <div class="panel-body">

                            <?php
                                // checking if any room type and room exists or not
                                global $wpdb;
                                $has_room = $wpdb->prefix . 'hotel_has_room';
                                $has_room_type = $wpdb->prefix . 'hotel_has_room_type';
                                $wpdb->get_results("SELECT * FROM $has_room_type");
                                $room_type_number = $wpdb->num_rows;
                                $wpdb->get_results("SELECT * FROM $has_room");
                                $room_number = $wpdb->num_rows;

                                if ($room_type_number > 0 && $room_number > 0){
                                    include 'schedule-pricing.php';
                                    $schedule_pricing = new SchedulePricing();
                                    $schedule_pricing->schedule_pricing_layout();
                                }
                                else{ ?>
                                    <center style="margin:100px 0px;">
                                        <h5 style=" color:#9e9e9e;">
                                            <i class="fa fa-plus-circle" style="font-size:20px;"></i>
                                            <?php echo $txt->txt("Create room types to set custom prices") ?>
                                            <?php '</center>'; ?>
                                        </h5>
                                    </center> <?php
                                }
                            ?>
                            <div id="pricing"></div>

                        </div>
                    </div>
                </div>

                <?php include $controller->plugin_path . 'layouts/backend/header/modal.php'; ?>

                <script>

                    jQuery(document)
                    .ready(function(){
                        <?php
                        if ($room_type_number > 0 && $room_number > 0) {
                        ?>
                        load_pricing();
                        <?php
                        }?>
                    });

                    function load_pricing(){
                        var room_type_id = jQuery("#room_type")
                        .val();
                        var year = jQuery("#year")
                        .val();
                        has_ajax_call('schedule-pricing-manager',
                                      'false',
                                      'false',
                                      'pricing',
                                      room_type_id,
                                      year);
                    }
                </script> <?php

            }

        }
    }