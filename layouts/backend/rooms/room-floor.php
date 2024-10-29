<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('RoomFloor')){
        class RoomFloor extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function room_floor_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <div class="row" style="margin-top:30px;">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="main-body-section">
                                <h3 class="panel-title"><?php echo $txt->txt("Manage Floor") ?></h3>
                            </div>
                            <div class="panel-body">
                                <button type="button" class="has-button-default"
                                        onclick="has_ajax_call('room-floor-add', 'true', 'false', 'modal_body')	"
                                        style="float: right; margin-bottom:15px;">
                                    <?php echo $txt->txt("+ Add new floor") ?></button>

                                <!-- Room type listing -->
                                <table class="table table-striped table-hover ">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $txt->txt("Name") ?></th>
                                        <th><?php echo $txt->txt("note") ?></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $counter = 1;
                                        global $wpdb;
                                        $floor = $wpdb->prefix . 'hotel_has_floor';
                                        $query_result = $wpdb->get_results("SELECT * FROM `$floor`",
                                                                           ARRAY_A);
                                        foreach ($query_result as $row):
                                            ?>
                                            <tr>
                                                <td><?php echo $counter++; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['note']; ?></td>
                                                <td>
                                                    <button type="button" class="has-button-default"
                                                            onclick="has_ajax_call('room-floor-edit', 'true', 'false', 'modal_body', <?php echo $row['floor_id']; ?>)">
                                                        <?php echo $txt->txt("edit") ?></button>
                                                    <button type="button" class="has-button-default"
                                                            onclick="has_ajax_call('room-floor-delete', 'true', 'false', 'modal_body', <?php echo $row['floor_id']; ?>)">
                                                        <?php echo $txt->txt("delete") ?></button>
                                                </td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

            }

        }
    }