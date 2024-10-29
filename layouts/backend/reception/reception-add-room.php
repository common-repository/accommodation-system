<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ReceptionAddRoom')){
        class ReceptionAddRoom extends Reception{

            function __construct(){
                parent::__construct();
            }

            public static function reception_add_room_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $room_id = sanitize_text_field($_POST['room_id']);
                $checkin_date = sanitize_text_field($_POST['checkin_date']);
                $checkout_date = sanitize_text_field($_POST['checkout_date']);

                $checkin_timestamp = strtotime($checkin_date);
                $checkout_timestamp = strtotime($checkout_date);

                $room_name = $method->has_get_room_name($room_id);

                $price = $method->has_get_room_price($room_id,
                                                     $checkin_timestamp,
                                                     $checkout_timestamp);
                ?>
                <tr>
                    <td>
                        <?php echo $room_name; ?>
                        <input type="hidden" name="rooms[]" value="<?php echo $room_id; ?>" id="available-rooms">
                    </td>
                    <td>
                        <?php echo $checkin_date; ?> <?php echo '<br>'; ?> <?php echo $checkout_date; ?>
                        <input type="hidden" name="checkin_timestamps[]" value="<?php echo $checkin_timestamp; ?>">
                        <input type="hidden" name="checkout_timestamps[]" value="<?php echo $checkout_timestamp; ?>">
                    </td>
                    <td>
                        <?php echo $price; ?>
                        <input type="hidden" name="prices[]" value="<?php echo $price; ?>">
                    </td>
                    <td>
                        <i class="fa fa-times btn_delete_room" style="cursor:pointer; color:#9e9e9e;"></i>
                    </td>
                </tr> <?php
            }

        }
    }

