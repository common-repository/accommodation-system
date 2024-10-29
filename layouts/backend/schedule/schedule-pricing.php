<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('SchedulePricing')){
        class SchedulePricing extends Schedule{

            function __construct(){
                parent::__construct();
            }

            public function schedule_pricing_layout(){
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
                                <?php _e("Select room type") ?>
                            </td>
                            <td>
                                <select name="room_type_id" id="room_type" onchange="load_pricing()" class="form-control">
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
                                <?php echo $txt->txt("Year") ?>
                            </td>
                            <td>
                                <select name="year" id="year" onchange="load_pricing()" class="form-control">
                                    <?php
                                        for ($i = 2019; $i <= 2030; $i++) :
                                            ?>
                                            <option value="<?php echo $i; ?>" <?php if (date("Y") == $i){
                                                echo 'selected';
                                            } ?>>
                                                <?php echo $i; ?></option>
                                        <?php
                                        endfor;
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>

                </center> <?php

            }

        }
    }
