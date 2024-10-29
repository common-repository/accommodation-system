<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('RoomList')){
        class RoomList extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function room_list_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $room_type_id = sanitize_text_field($_POST['param1']);
                $floor_id = sanitize_text_field($_POST['param2']);
                global $wpdb;
                $room = $wpdb->prefix . 'hotel_has_room';

                if ($room_type_id == '0' && $floor_id == '0'){
                    $query_result = $wpdb->get_results("SELECT * FROM `$room` ",
                                                       ARRAY_A);
                }
                else if ($room_type_id == '0' && $floor_id != '0'){
                    $query_result = $wpdb->get_results("SELECT * FROM `$room` WHERE `floor_id` = $floor_id",
                                                       ARRAY_A);
                }
                else if ($room_type_id != '0' && $floor_id == '0'){
                    $query_result = $wpdb->get_results("SELECT * FROM `$room` WHERE `room_type_id` = $room_type_id",
                                                       ARRAY_A);
                }
                else if ($room_type_id != '0' && $floor_id != '0'){
                    $query_result = $wpdb->get_results("SELECT * FROM `$room` WHERE `room_type_id` = $room_type_id AND `floor_id` = $floor_id",
                                                       ARRAY_A);
                }

                $number_of_rooms = count($query_result);
                ?>

                <h5>
                    <?php echo $txt->txt("Total") ?> <?php echo $number_of_rooms; ?> <?php echo $txt->txt("rooms found") ?>
                </h5>
                <div class="container-items">
                    <?php
                        foreach ($query_result as $row){
                            $type = $method->get_room_type_name_by_id($row['room_type_id']);
                            $floor = $method->get_floor_name_by_id($row['floor_id']);
                            ?>
                            <div class="container-item">
                                <div class="container-item-name"><?php echo $row['name']; ?></div>
                                <div class="container-item-type">
                                    <?php
                                        if(isset($type)){
                                            echo $type;
                                        }
                                        else echo ' - ';
                                    ?>
                                </div>
                                <div class="container-item-floor">
                                    <?php
                                        if (isset($floor)){
                                            echo $floor;
                                        }
                                        else echo ' - ';
                                    ?>
                                </div>
                                <span>
                                    <button type="button" class="has-button-default"
                                            onclick="has_ajax_call('room-edit', 'true', 'false', 'modal_body', <?php echo $row['room_id']; ?>)">
                                            <?php echo $txt->txt("edit") ?>
                                    </button>
                                    <button type="button" class="has-button-default"
                                            onclick="has_ajax_call('room-delete', 'true', 'false', 'modal_body', <?php echo $row['room_id']; ?>)">
                                            <?php echo $txt->txt("delete") ?>
                                    </button>
                                </span>
                            </div>
                            <?php
                        }
                    ?>
                </div>

                <?php

            }
        }
    }
