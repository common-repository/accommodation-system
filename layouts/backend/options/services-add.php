<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ServicesAdd')){
        class ServicesAdd extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function services_add_modal(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="service-add">
                    <input type="hidden" name="action" value="has">
                    <input type="hidden" name="task" value="create_service">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">

                    <fieldset>
                        <div class="form-group">
                            <label><?php _e("Name",
                                            self::$text_domain) ?></label>
                            <input type="text" class="form-control"
                                   placeholder="<?php echo $txt->txt("service name") ?>" name="name" value=""
                                   id="name" autofocus>
                            <small class="form-text text-muted"><?php echo $txt->txt("e.g. airport pickup") ?></small>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" name="type">
                                <option value="1"><?php echo $txt->txt("Add fixed price") ?></option>
                                <option value="2"><?php echo $txt->txt("Multiply number of guests") ?></option>
                                <option value="3"><?php echo $txt->txt("Multiply number of nights") ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php _e("Price / Unit price",
                                            self::$text_domain) ?></label>
                            <input type="text" class="form-control" name="price" value="">
                        </div>
                        <div class="form-group">
                            <div style="float:right;">
                                <button type="submit"
                                        class="btn btn-primary btn-sm"><?php echo $txt->txt("Create service") ?></button>
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
                            success     : response_service_add,
                            resetForm   : true
                        };

                        // binding the form for ajax submission
                        jQuery('.service-add')
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

                    function response_service_add(){
                        jQuery('#modal')
                        .modal('hide');
                        has_ajax_call('services',
                                      'false',
                                      'false',
                                      'tab1');
                        notify('<?php echo $txt->txt("Service added successfully") ?>');
                    }

                </script> <?php

            }

        }
    }