<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Room')){
        class Room extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function room_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                global $wpdb;
                $has_room_type = $wpdb->prefix . 'hotel_has_room_type';
                $wpdb->get_results("SELECT * FROM $has_room_type");
                $room_type_number = $wpdb->num_rows;

                ?>
                <div class="row" style="margin-top:30px;">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="main-body-section">
                                <h3 class="panel-title"><?php echo $txt->txt('Manage Room') ?></h3>
                            </div>
                            <div class="panel-body">
                                <?php if ($room_type_number > 0){ ?>
                                <button type="button" class="has-button-default"
                                        onclick="has_ajax_call('room-add', 'true', 'false', 'modal_body')	"
                                        style="float: right; margin-bottom:15px;">
                                    <?php echo $txt->txt("+ Add new room") ?>
                                </button>
                                <div class="form-group">
                                    <label style="float: left; margin:13px;"><?php echo $txt->txt('Filter') ?>
                                        : </label>
                                    <select class="form-control" id="room_type" onChange="reload_room_list()"
                                            style="float: left; margin: 10px;">
                                        <option value="0"><?php echo $txt->txt("All room types") ?></option>
                                        <?php
                                            global $wpdb;
                                            $room_type = $wpdb->prefix . 'hotel_has_room_type';
                                            $query_result = $wpdb->get_results("SELECT * FROM `$room_type`",
                                                                               ARRAY_A);
                                            foreach ($query_result as $row):
                                                ?>
                                                <option value="<?php echo $row['room_type_id']; ?>">
                                                    <?php echo $row['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                    </select>
                                    <select class="form-control" id="floor" onChange="reload_room_list()"
                                            style="float: left; margin: 10px;">
                                        <option value="0"><?php echo $txt->txt('Floor - all') ?></option>
                                        <?php
                                            $floor = $wpdb->prefix . 'hotel_has_floor';
                                            $query_result = $wpdb->get_results("SELECT * FROM `$floor`",
                                                                               ARRAY_A);
                                            foreach ($query_result as $row):
                                                ?>
                                                <option value="<?php echo $row['floor_id']; ?>">
                                                    <?php echo $row['name']; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                                <hr style="clear: both;">
                                <!-- Room type listing -->
                                <div id="room-list">

                                </div>
                                <?php }
                                else {
                                    ?><center style="margin:100px 0px;">
                                    <h5 style=" color:#9e9e9e;">
                                        <i class="fa fa-plus-circle" style="font-size:20px;"></i>
                                        <?php echo $txt->txt("First you need to create the room type") ?>
                                        <?php '</center>'; ?>
                                    </h5>
                                </center> <?php
                                }?>

                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function reload_room_list(){
                        room_type_id = jQuery("#room_type")
                        .val();
                        floor_id = jQuery("#floor")
                        .val();
                        has_ajax_call('room-list',
                                      'false',
                                      'false',
                                      'room-list',
                                      room_type_id,
                                      floor_id);
                    }

                    jQuery(document)
                    .ready(function(){
                        has_ajax_call('room-list',
                                      'false',
                                      'false',
                                      'room-list',
                                      '0',
                                      '0');
                    });
                </script>
                <?php

            }

        }
    }