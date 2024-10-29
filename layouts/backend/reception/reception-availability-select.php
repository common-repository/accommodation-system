<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ReceptionAvailabilitySelect')){
        class ReceptionAvailabilitySelect extends ReceptionAvailability{

            function __construct(){
                parent::__construct();
            }

            public static function reception_availability_select_layout(){
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
                                <!-- LIST OF ROOM TYPES -->
                                <select name="room_type_id" id="room_type_id" onchange="load_rooms()" class="form-control">
                                    <option value="0"><?php echo $txt->txt("All room types") ?></option>
                                    <?php
                                        $room_types = $method->has_get_room_type();
                                        foreach ($room_types as $row) :
                                            ?>
                                            <option value="<?php echo $row['room_type_id']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                        <?php
                                        endforeach;
                                    ?>
                                </select>

                            </td>
                            <td style="padding:0px 10px;">
                                <?php echo $txt->txt("Select a room") ?>
                            </td>
                            <td>

                                <!-- LIST OF ALL ROOM TYPES -->
                                <select name="room_id" id="room_type_0" class="rooms form-control" onchange="load_rooms()"
                                        style="width:150px;">
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


                                <!-- LIST OF SELECTED TYPE'S ROOMS -->
                                <?php
                                    foreach ($room_types as $row):
                                        ?>
                                        <select name="room_id" id="room_type_<?php echo $row['room_type_id']; ?>"
                                                style="display:none; width:150px;" class="rooms form-control"
                                                onchange="load_rooms()">
                                            <?php
                                                $rooms = $method->has_get_room_by_type($row['room_type_id']);
                                                foreach ($rooms as $row2) :
                                                    ?>
                                                    <option value="<?php echo $row2['room_id']; ?>">
                                                        <?php echo $row2['name']; ?>
                                                    </option>
                                                <?php
                                                endforeach;
                                            ?>
                                        </select>
                                    <?php
                                    endforeach;
                                ?>
                            </td>
                        </tr>
                    </table>
                </center>
                <hr> <?php

            }

        }
    }