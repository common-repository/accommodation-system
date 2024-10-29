<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('RoomFloorEdit')){
        class RoomFloorEdit extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function room_floor_edit_modal(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $floor_id = sanitize_text_field($_POST['param1']);
                global $wpdb;
                $floor = $wpdb->prefix . 'hotel_has_floor';
                $query_result = $wpdb->get_results("SELECT * FROM `$floor` WHERE `floor_id` = $floor_id",
                                                   ARRAY_A);
                foreach ($query_result as $row):
                    ?>
                    <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="floor-edit">
                        <input type="hidden" name="action" value="has">
                        <input type="hidden" name="task" value="edit_floor">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                        <input type="hidden" name="floor_id" value="<?php echo $floor_id; ?>"

                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $txt->txt("Name") ?></label>
                                <input type="text" class="form-control"
                                       placeholder="<?php echo $txt->txt("Room type") ?>" name="name"
                                       value="<?php echo $row['name']; ?>">
                                <small class="form-text text-muted"><?php echo $txt->txt("e.g. 1st floor") ?></small>
                            </div>
                            <div class="form-group">
                                <label><?php echo $txt->txt("Note") ?></label>
                                <input type="text" class="form-control" name="note" value="<?php echo $row['note']; ?>">
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
                            success     : response_floor_edit,
                            resetForm   : true
                        };

                        // binding the form for ajax submission
                        jQuery('.floor-edit')
                        .submit(function(){
                            jQuery(this)
                            .ajaxSubmit(options);

                            // prevents normal form submission
                            return false;
                        });
                    });

                    function validate(){
                        return true;
                    }

                    function response_floor_edit(){
                        jQuery('#modal')
                        .modal('hide');
                        has_ajax_call('room-floor',
                                      'false',
                                      'false',
                                      'tab3');
                        notify('<?php echo $txt->txt("Flood updated successfully") ?>');
                    }

                </script> <?php

            }

        }
    }