<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ServicesDelete')){
        class ServicesDelete extends Reception{

            function __construct(){
                parent::__construct();
            }

            public static function services_delete_modal(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $service_id = sanitize_text_field($_POST['param1']);

                    ?>

                    <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="service-delete">
                        <input type="hidden" name="action" value="has">
                        <input type="hidden" name="task" value="services_delete">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                        <input type="hidden" name="service_id" value="<?php echo $service_id; ?>"

                        <div class="row">
                            <div class="col-md-12">

                                <!-- GUEST PERSONAL DETAIL INFORMATION -->
                                <fieldset>
                                    <legend><?php echo $txt->txt("Are you sure ?") ?></legend>
                                    <div class="form-group">
                                        <label><?php echo $txt->txt("Deleted data cannot be recovered.") ?></label>

                                    </div>
                                    <div class="form-group">
                                        <div style="float:right;">
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"><?php echo $txt->txt("Delete") ?></button>
                                            <button type="button" class="btn btn-default btn-sm"
                                                    data-dismiss="modal"><?php echo $txt->txt("Close") ?></button>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                    </form>


                    <script type="text/javascript">
                        // Ajax form plugin calls at each modal loading,
                        jQuery(document)
                        .ready(function(){

                            // Configuration for ajax form submission
                            var options = {
                                beforeSubmit: validate,
                                success     : response_service_delete,
                                resetForm   : true
                            };

                            // Binding the form for ajax submission
                            jQuery('.service-delete')
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

                        // Loads the updated booking in the list
                        function response_service_delete(){
                            jQuery('#modal')
                            .modal('hide');
                            notify('<?php echo $txt->txt("Service deleted successfully") ?>');
                            jQuery("#row_<?php echo $service_id;?>")
                            .remove();
                            has_ajax_call('services',
                                          'false',
                                          'false',
                                          'tab1');
                        }


                    </script>

                <?php
            }

        }
    }