<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Services')){
        class Services extends Rooms{

            /*
             *
             *  Constructor called when Services class instance is created.
             *
             */
            function __construct(){
                parent::__construct();
            }

            /*
             *
             *  function services_layout()
             *
             *      page: Options
             *
             *      display HTML layout for section Services
             *
             */
            public static function services_layout(){
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
                                <h3 class="panel-title"><?php echo $txt->txt("Manage Services") ?></h3>
                            </div>
                            <div class="panel-body">
                                <button type="button" class="has-button-default"
                                        onclick="has_ajax_call('services-add', 'true', 'false', 'modal_body')	"
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
                                                            echo 'Add fixed price';
                                                        }
                                                        if ($row['type'] == '2'){
                                                            echo 'Multiply number of guest';
                                                        }
                                                        if ($row['type'] == '3'){
                                                            echo 'Multiply number of night';
                                                        }
                                                    ?>
                                                </td>
                                                <td><?php echo $row['price']; ?></td>
                                                <td>
                                                    <button type="button" class="has-button-default"
                                                            onclick="has_ajax_call('services-edit', 'true', 'false', 'modal_body', <?php echo $row['service_id']; ?>)">
                                                        <?php echo $txt->txt("edit") ?>
                                                    </button>
                                                    <button type="button" class="has-button-default"
                                                            onclick="has_ajax_call('services-delete', 'true', 'false', 'modal_body', <?php echo $row['service_id']; ?>)">
                                                        <?php echo $txt->txt("delete") ?>
                                                    </button>
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