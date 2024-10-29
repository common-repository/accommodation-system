<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/
    if (!class_exists('Amenities')){
        class Amenities extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function amenities_layout(){
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
                                <h3 class="panel-title"><?php echo $txt->txt("Manage Amenities") ?></h3>
                            </div>
                            <div class="panel-body">

                                <button type="button" class="has-button-default"
                                        onclick="has_ajax_call('amenities-add', 'true', 'false', 'modal_body')	"
                                        style="float: right; margin-bottom:15px;">
                                    <?php echo $txt->txt("Add new amenity") ?></button>

                                <!-- Room type listing -->
                                <table class="table table-striped table-hover ">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $txt->txt("Name") ?></th>
                                        <th><?php echo $txt->txt("Description") ?></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $counter = 1;
                                        global $wpdb;
                                        $amenity = $wpdb->prefix . 'hotel_has_amenity';
                                        $query_result = $wpdb->get_results("SELECT * FROM `$amenity`",
                                                                           ARRAY_A);
                                        foreach ($query_result as $row):
                                            ?>
                                            <tr>
                                                <td><?php echo $counter++; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['description']; ?></td>
                                                <td>
                                                    <button type="button" class="has-button-default"
                                                            onclick="has_ajax_call('amenities-edit', 'true', 'false', 'modal_body', <?php echo $row['amenity_id']; ?>)">
                                                        <?php echo $txt->txt("edit") ?></button>
                                                    <button type="button" class="has-button-default"
                                                            onclick="has_ajax_call('amenities-delete', 'true', 'false', 'modal_body', <?php echo $row['amenity_id']; ?>)">
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