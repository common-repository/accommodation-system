<?php
/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/
    if (!class_exists('RoomList')){
        class RoomList extends Controller{

            /**
             *
             *  Constructor called when RoomList class instance is created.
             *
             */
            function __construct(){
                parent::__construct();
            }

            /**
             *
             * Room list layout
             *
             *   function: load load_room_list layout
             *
             */
            public static function room_list(){
                /**
                 *
                 * Instantiate Controller class for plugin path variables
                 *
                 * Instantiate Methods class to call methods
                 *
                 * HTML layout
                 *
                 */
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $checkin_date = sanitize_text_field($_POST['param1']);
                $checkout_date = sanitize_text_field($_POST['param2']);
                $guest_number = sanitize_text_field($_POST['param3']);

                $checkin_timestamp = strtotime($checkin_date);
                $checkout_timestamp = strtotime($checkout_date);

                //echo $checkin_date.$checkout_date.$guest_number;
                $vat = $method->has_get_settings('vat_percentage');
                ?>

                <div class="chb-booking-room-list">
                    <?php
                        $room_types = $method->has_get_room_type();
                        foreach ($room_types as $row):

                            /**
                             *
                             *  Counting the number of available rooms for each room type.
                             *
                             */
                            global $wpdb;
                            $room_counter = 0;
                            $room_type_id = $row['room_type_id'];
                            $room = $wpdb->prefix . 'hotel_has_room';
                            $query_result = $wpdb->get_results("SELECT * FROM `$room` WHERE `room_type_id` = $room_type_id ",
                                                               ARRAY_A);
                            foreach ($query_result as $row1):

                                $exclude_flag = false;

                                /**
                                 *
                                 *  Flag variable for checking if a room is available for booking
                                 *
                                 *  If a room is already in booking status within the asked checkin & checkout timestamp
                                 *
                                 *  Checking within the room booking history of a single room
                                 *
                                 */
                                $booking_room = $wpdb->prefix . 'hotel_has_booking_room';
                                $room_id = $row1['room_id'];
                                $query_result2 = $wpdb->get_results("SELECT * FROM  `$booking_room` WHERE `room_id` = $room_id",
                                                                    ARRAY_A);
                                foreach ($query_result2 as $row2):

                                    if ($checkin_timestamp >= $row2['checkin_timestamp'] && $checkin_timestamp < $row2['checkout_timestamp']){
                                        $exclude_flag = true;
                                        break;
                                    }
                                    if ($checkout_timestamp > $row2['checkin_timestamp'] && $checkout_timestamp <= $row2['checkout_timestamp']){
                                        $exclude_flag = true;
                                        break;
                                    }
                                    if ($checkin_timestamp <= $row2['checkin_timestamp'] && $checkout_timestamp >= $row2['checkout_timestamp']){
                                        $exclude_flag = true;
                                        break;
                                    }

                                endforeach;

                                /**
                                 *
                                 *  Exclude this room from available list
                                 *
                                 */
                                if ($exclude_flag == true){
                                    continue;
                                }
                                else{
                                    $room_counter++;
                                }
                            endforeach;

                            /**
                             *
                             *  Hide the room type that doesn't have available rooms.
                             *
                             */
                            if ($room_counter == 0){
                                continue;
                            }

                            /**
                             *
                             *  1 Room price of the type, within the date range
                             *
                             */
                            $room_price = $method->has_get_room_price($room_id,
                                                                      $checkin_timestamp,
                                                                      $checkout_timestamp);
                            ?>
                            <div class="chb-booking-single-room">
                                <div class="chb-booking-single-room-box">
                                    <div class="chb-booking-single-room-image">
                                        <img src="<?php echo !empty($row['image_url']) ? $row['image_url'] : $controller->plugin_url . 'assets/css/frontend/icons/image-placeholder.jpg'; ?>"
                                             alt="" class="img-fluid">
                                        <div class="chb-booking-single-room-price">
                                            <?php echo $method->has_currency($room_price); ?>
                                            <small>/ <?php echo $txt->txt("room") ?></small>
                                        </div>
                                        <div class="room-type-beds">
                                            <?php
                                            $beds_json = $row['bed_type'];
                                            $beds_array = json_decode($beds_json);
                                            $permissions_json = $row['permissions'];
                                            $permissions_array = json_decode($permissions_json);
                                            $array = array_merge($beds_array, $permissions_array);
                                            foreach ($array as $row2):
                                                ?>
                                                <div class="single-bed">
                                                    <div class="has-tooltip" id="<?php echo $row2 ?>">
                                                        <img src="<?php echo $controller->plugin_url . 'assets/css/frontend/icons/'.$row2.'.png'; ?>">
                                                        <span class="has-tooltiptext"><?php echo $txt->txt($row2);?></span>
                                                    </div>
                                                </div>
                                            <?php
                                            endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="chb-booking-single-room-details">
                                        <h4 class="room-type-name"><?php echo $row['name']; ?></h4>
                                        <p class="room-type-text">
                                            <?php echo $row['description']; ?>
                                        </p>

                                        <div class="room-type-amenities clearfix">
                                            <?php
                                                $amenities_json = $row['amenities'];
                                                $amenities_array = json_decode($amenities_json);
                                                foreach ($amenities_array as $row2):
                                                    ?>
                                                    <div class="single-amenity">
                                                        <?php echo $method->get_amenity_name_by_id($row2); ?>
                                                    </div>
                                                <?php
                                                endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="chb-booking-single-room-select">
                                    <div class="has-row">
                                        <div class="has-col-sm">
                                            <div class="max-guests">
                                                <p class="d-inline-block"><?php echo $txt->txt("Max Guests") ?>
                                                    - <?php echo $row['capacity']; ?></p>
                                                <p class="d-inline-block guest-icon">
                                                    <?php for ($i = 1; $i <= $row['capacity']; $i++): ?>
                                                        <i class="fa fa-user"></i>
                                                    <?php endfor; ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="has-col-sm">
                                            <div class="room-quantity clearfix">
                                                <div class="has-form-group pull-right">
                                                    <p class="d-inline-block"><?php echo $txt->txt("Room Quantity") ?></p>
                                                    <p class="d-inline-block qunatity-select">
                                                        <select class="select_room_quantity"
                                                                id="room_quantity_<?php echo $room_type_id; ?>">

                                                            <?php
                                                                for ($i = 1; $i <= $room_counter; $i++):
                                                                    ?>
                                                                    <option value="<?php echo $i; ?>">
                                                                        <?php echo $i; ?></option>
                                                                <?php
                                                                endfor;
                                                            ?>
                                                        </select>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="has-col-sm">
                                            <div class="room-select text-right">
                                                <div class="has-form-group">
                                                    <button type="submit" class="has-button"
                                                            onclick="select_room_type('<?php echo $row['room_type_id']; ?>',
                                                                    '<?php echo $row['name']; ?>',
                                                                    '<?php echo $room_price; ?>',
                                                                    '<?php echo $checkin_timestamp; ?>',
                                                                    '<?php echo $checkout_timestamp; ?>',
                                                                    '<?php echo $checkin_date; ?>',
                                                                    '<?php echo $checkout_date; ?>',
                                                                    '<?php echo (int)$vat; ?>')">
                                                        <?php echo $txt->txt("Select this room") ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endforeach;
                    ?>


                </div>

                <script>

                </script> <?php
            }

        }
    }