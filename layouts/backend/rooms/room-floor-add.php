<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('RoomFloorAdd')){
        class RoomFloorAdd extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function room_floor_add_modal(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="floor-add">
                    <input type="hidden" name="action" value="has">
                    <input type="hidden" name="task" value="create_floor">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">

                    <fieldset>
                        <div class="form-group">
                            <label><?php echo $txt->txt("Name") ?></label>
                            <input type="text" class="form-control"
                                   placeholder="<?php echo $txt->txt("Floor name") ?>" name="name" value=""
                                   id="name" autofocus>
                            <small class="form-text text-muted"><?php echo $txt->txt("e.g. 1st floor") ?></small>
                        </div>
                        <div class="form-group">
                            <label><?php echo $txt->txt("Note") ?></label>
                            <input type="text" class="form-control" name="note" value="">
                        </div>
                        <div class="form-group">
                            <div style="float:right;">
                                <button type="submit"
                                        class="btn btn-primary btn-sm"><?php echo $txt->txt("Create floor") ?></button>
                                <button type="button" class="btn btn-default btn-sm"
                                        data-dismiss="modal"><?php echo $txt->txt("Close") ?></button>
                            </div>
                        </div>
                    </fieldset>
                </form>


                <script type="text/javascript">
                    // ajax form plugin calls at each modal loading,
                    jQuery(document)
                    .ready(function(){

                        // configuration for ajax form submission
                        var options = {
                            beforeSubmit: validate,
                            success     : response_room_type_add,
                            resetForm   : true
                        };

                        // binding the form for ajax submission
                        jQuery('.floor-add')
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
                            notify_warning("<?php echo $txt->txt('Name must be filled up!') ?>");
                            jQuery('#name')
                            .focus();
                            return false;
                        }
                        return true;
                    }

                    function response_room_type_add(){
                        jQuery('#modal')
                        .modal('hide');
                        has_ajax_call('room-floor',
                                      'false',
                                      'false',
                                      'tab3');
                        notify("<?php echo $txt->txt('Floor added successfully') ?>");
                    }

                </script> <?php

            }

        }
    }