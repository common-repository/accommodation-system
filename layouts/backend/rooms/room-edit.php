<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('RoomEdit')){
        class RoomEdit extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function room_edit_modal(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $room_id = sanitize_text_field($_POST['param1']);
                global $wpdb;
                $room = $wpdb->prefix . 'hotel_has_room';
                $query_result = $wpdb->get_results("SELECT * FROM `$room` WHERE `room_id` = $room_id",
                                                   ARRAY_A);
                foreach ($query_result as $row):
                    ?>
                    <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="room-edit">
                        <input type="hidden" name="action" value="has">
                        <input type="hidden" name="task" value="edit_room">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                        <input type="hidden" name="room_id" value="<?php echo $room_id; ?>"

                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $txt->txt("Room type") ?></label>
                                <select class="form-control" name="room_type_id">
                                    <?php
                                        global $wpdb;
                                        $room_type = $wpdb->prefix . 'hotel_has_room_type';
                                        $query_result2 = $wpdb->get_results("SELECT * FROM `$room_type`",
                                                                            ARRAY_A);
                                        foreach ($query_result2 as $row2):
                                            ?>
                                            <option value="<?php echo $row2['room_type_id']; ?>" <?php if ($row['room_type_id'] == $row2['room_type_id']){
                                                echo 'selected';
                                            } ?>>
                                                <?php echo $row2['name']; ?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php echo $txt->txt("Floor") ?></label>
                                <select class="form-control" name="floor_id">
                                    <?php
                                        global $wpdb;
                                        $floor = $wpdb->prefix . 'hotel_has_floor';
                                        $query_result2 = $wpdb->get_results("SELECT * FROM `$floor`",
                                                                            ARRAY_A);
                                        foreach ($query_result2 as $row2):
                                            ?>
                                            <option value="<?php echo $row2['floor_id']; ?>" <?php if ($row['floor_id'] == $row2['floor_id']){
                                                echo 'selected';
                                            } ?>>
                                                <?php echo $row2['name']; ?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php echo $txt->txt("Room Name") ?></label>
                                <input type="text" class="form-control"
                                       placeholder="<?php echo $txt->txt("Room name") ?>" name="name"
                                       value="<?php echo $row['name']; ?>" id="name">
                                <small class="form-text text-muted"><?php echo $txt->txt("e.g. 308, 102") ?></small>
                            </div>
                            <div class="form-group">
                                <div style="float:right;">
                                    <button type="submit"
                                            class="btn btn-primary btn-sm"><?php echo $txt->txt("Update") ?></button>
                                    <button type="button" class="btn btn-default btn-sm"
                                            data-dismiss="modal"><?php echo $txt->txt("Close") ?></button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                <?php
                endforeach;
                ?>


                <script type="text/javascript">
                    // ajax form plugin calls at each modal loading,
                    jQuery(document)
                    .ready(function(){

                        // configuration for ajax form submission
                        var options = {
                            beforeSubmit: validate,
                            success     : response_room_edit,
                            resetForm   : true
                        };

                        // binding the form for ajax submission
                        jQuery('.room-edit')
                        .submit(function(){
                            jQuery(this)
                            .ajaxSubmit(options);

                            // prevents normal form submission
                            return false;
                        });
                    });

                    function validate(){
                        if (jQuery('#name')
                        .val() == ''){
                            notify_warning('<?php echo $txt->txt("Name must be filled up!") ?>');
                            jQuery('#name')
                            .focus();
                            return false;
                        }
                        return true;
                    }

                    function response_room_edit(){
                        jQuery('#modal')
                        .modal('hide');
                        has_ajax_call('room',
                                      'false',
                                      'false',
                                      'tab2');
                        notify('<?php echo $txt->txt("Room updated successfully") ?>');
                    }

                </script> <?php

            }

        }
    }