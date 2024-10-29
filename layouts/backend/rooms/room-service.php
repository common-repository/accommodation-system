<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('RoomService')){
        class RoomService extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function room_service_layout(){
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
                                <h3 class="panel-title"><?php echo $txt->txt("Manage Room Service") ?></h3>
                            </div>
                            <div class="panel-body">

                                <button type="button" class="btn btn-success btn-sm"
                                        onclick="ajax_call('modal-service-add', 'true', 'false', 'modal_body')	"
                                        style="float: right; margin-bottom:15px;">
                                    + <?php echo $txt->txt("Add new service") ?>
                                </button>

                                <!-- Room type listing -->
                                <table class="table table-striped table-hover ">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $txt->txt("Services") ?></th>
                                        <th><?php echo $txt->txt("Type") ?></th>
                                        <th><?php echo $txt->txt("Price") ?></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $counter = 1;
                                        $services = $method->has_get_services();
                                        foreach ($services as $row):
                                            ?>
                                            <tr>
                                                <td><?php echo $counter++; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td>
                                                    <?php
                                                        if ($row['type'] == '1'){
                                                            echo $txt->txt('Add fixed price');
                                                        }
                                                        if ($row['type'] == '2'){
                                                            echo $txt->txt('Multiply number of guests');
                                                        }
                                                        if ($row['type'] == '3'){
                                                            echo $txt->txt('Multiply number of nights');
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo $row['price']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-xs"
                                                            onclick="has_ajax_call('room-service-edit', 'true', 'false', 'modal_body', <?php echo $row['service_id']; ?>)">
                                                        <?php echo $txt->txt("edit") ?></button>
                                                    <button type="button" class="btn btn-default btn-xs"
                                                            onclick="has_ajax_call('delete-room-service', 'false', 'true', 'tab2', <?php echo $row['service_id']; ?>, 'room-service')">
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