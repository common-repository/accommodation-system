<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('HASSync')){
        class HASSync extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function sync_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                ?>

                <div class="row">
                    <div class="panel panel-primary">
                        <div class="main-body-section">
                            <h3 class="panel-title"><?php echo $txt->txt('Synchronization') ?></h3>
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

                                if ($room_type_number > 0 && $room_number >0){
                                    include 'sync-management.php';
                                    $sync_management = new SyncManagement();
                                    $sync_management->sync_management_layout();
                                }
                                else{ ?>
                                    <center style="margin:100px 0px;">
                                        <h5 style=" color:#9e9e9e;">
                                            <i class="fa fa-plus-circle" style="font-size:20px;"></i>
                                            <?php echo $txt->txt("Create room types to synchronize") ?>
                                            <?php '</center>'; ?>
                                        </h5>
                                    </center> <?php
                                }
                            ?>
                            <div id="platforms"></div>

                        </div>
                    </div>
                </div>

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
                        var room_id = jQuery("#rooms")
                        .val();
                        var year = jQuery("#year")
                        .val();
                        has_ajax_call('sync-platforms',
                                      'false',
                                      'false',
                                      'platforms',
                                      room_id,
                                      year);
                    }
                </script>


                <script>

                </script>
                <?php

            }

        }
    }