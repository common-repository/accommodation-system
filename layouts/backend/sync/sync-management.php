<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('SyncManagement')){
        class SyncManagement extends HASSync{

            function __construct(){
                parent::__construct();
            }

            public function sync_management_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <center>
                    <table>
                        <tr>
                            <td style="padding:0px 10px;">
                                <?php echo $txt->txt("Select room type") ?>
                            </td>
                            <td>
                                <select name="room_id" id="rooms" onchange="load_pricing()" class="form-control">
                                    <?php
                                        $rooms = $method->has_get_rooms();
                                        foreach ($rooms as $row) :
                                            ?>
                                            <option value="<?php echo $row['room_id']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                        <?php
                                        endforeach;
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>

                </center> <?php

            }

        }
    }
