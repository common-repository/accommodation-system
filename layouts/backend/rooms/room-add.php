<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('RoomAdd')){
        class RoomAdd extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function room_add_modal(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="room-add">
                    <input type="hidden" name="action" value="has">
                    <input type="hidden" name="task" value="create_room">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Room type") ?></label>
                                    <select class="form-control" name="room_type_id">
                                        <?php
                                            global $wpdb;
                                            $room_type = $wpdb->prefix . 'hotel_has_room_type';
                                            $query_result = $wpdb->get_results("SELECT * FROM `$room_type`",
                                                                               ARRAY_A);
                                            foreach ($query_result as $row):
                                                ?>
                                                <option value="<?php echo $row['room_type_id']; ?>">
                                                    <?php echo $row['name']; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Floor") ?></label>
                                    <select class="form-control" name="floor_id">
                                        <?php
                                            global $wpdb;
                                            $floor = $wpdb->prefix . 'hotel_has_floor';
                                            $query_result = $wpdb->get_results("SELECT * FROM `$floor`",
                                                                               ARRAY_A);
                                            foreach ($query_result as $row):
                                                ?>
                                                <option value="<?php echo $row['floor_id']; ?>">
                                                    <?php echo $row['name']; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Room Name") ?></label>
                                    <input type="text" class="form-control" placeholder="Room name" name="name" value=""
                                           id="name" autofocus>
                                    <small class="form-text text-muted"><?php echo $txt->txt("e.g. 308, 102") ?></small>
                                </div>
                                <div class="form-group">
                                    <div style="float:right;">
                                        <button type="submit"
                                                class="btn btn-primary btn-sm"><?php echo $txt->txt("Create room") ?></button>
                                        <button type="button" class="btn btn-default btn-sm"
                                                data-dismiss="modal"><?php echo $txt->txt("Close") ?></button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>


                <script type="text/javascript">
                    // ajax form plugin calls at each modal loading,
                    jQuery(document)
                    .ready(function(){

                        // configuration for ajax form submission
                        var options = {
                            beforeSubmit: validate,
                            success     : response_room_add,
                            resetForm   : true
                        };

                        // binding the form for ajax submission
                        jQuery('.room-add')
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
                            notify_warning('Name must be filled up!');
                            jQuery('#name')
                            .focus();
                            return false;
                        }
                        return true;
                    }

                    function response_room_add(){
                        jQuery('#modal')
                        .modal('hide');
                        has_ajax_call('room',
                                      'false',
                                      'false',
                                      'tab2');
                        notify('<?php echo $txt->txt("Room added successfully") ?>');
                    }

                </script> <?php

            }

        }
    }