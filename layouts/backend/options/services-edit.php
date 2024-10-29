<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ServicesEdit')){
        class ServicesEdit extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function services_edit(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $service_id = sanitize_text_field($_POST['param1']);
                global $wpdb;
                $service = $wpdb->prefix . 'hotel_has_service';
                $query_result = $wpdb->get_results("SELECT * FROM `$service` WHERE `service_id` = $service_id",
                                                   ARRAY_A);
                foreach ($query_result as $row):
                    ?>
                    <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="service-edit">
                        <input type="hidden" name="action" value="has">
                        <input type="hidden" name="task" value="edit_service">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                        <input type="hidden" name="service_id" value="<?php echo $service_id; ?>"

                        <fieldset>
                            <div class="form-group">
                                <label><?php echo $txt->txt("Name") ?></label>
                                <input type="text" class="form-control" placeholder="<?php _e("Room type") ?>" name="name"
                                       value="<?php echo $row['name']; ?>">
                                <small class="form-text text-muted"><?php echo $txt->txt("e.g. airport pickup") ?></small>
                            </div>
                            <div class="form-group">
                                <label><?php echo $txt->txt("Type") ?></label>
                                <select class="form-control" name="type">
                                    <option value="1" <?php if ($row['type'] == '1'){
                                        echo 'selected';
                                    } ?>><?php echo $txt->txt("Add fixed price") ?></option>
                                    <option value="2" <?php if ($row['type'] == '2'){
                                        echo 'selected';
                                    } ?>><?php echo $txt->txt("Multiply number of guests") ?></option>
                                    <option value="3" <?php if ($row['type'] == '3'){
                                        echo 'selected';
                                    } ?>><?php echo $txt->txt("Multiply number of nights") ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php _e("Price") ?></label>
                                <input type="text" class="form-control" name="price" value="<?php echo $row['price']; ?>">
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
                            success     : response_service_edit,
                            resetForm   : true
                        };

                        // binding the form for ajax submission
                        jQuery('.service-edit')
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

                    function response_service_edit(){
                        jQuery('#modal')
                        .modal('hide');
                        has_ajax_call('services',
                                      'false',
                                      'false',
                                      'tab1');
                        notify('<?php echo $txt->txt("Service updated successfully") ?>');
                    }

                </script><?php
            }

        }
    }