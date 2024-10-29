<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ScheduleDeletePrice')){
        class ScheduleDeletePrice extends Schedule{

            function __construct(){
                parent::__construct();
            }

            public static function schedule_delete_price(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $room_type_id = sanitize_text_field($_POST['param1']);
                $current_year = sanitize_text_field($_POST['param2']);
                ?>
                <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="pricing-delete">
                    <input type="hidden" name="action" value="has">
                    <input type="hidden" name="task" value="delete_pricing">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                    <input type="hidden" name="room_type_id" value="<?php echo $room_type_id; ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <!-- NEW PRICE DETAIL -->
                            <fieldset>
                                <legend><?php echo $txt->txt("Remove custom price") ?></legend>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Date from") ?></label>
                                    <input type="text" class="form-control datepicker" name="from_timestamp" value=""
                                           autocomplete="off" id="from_timestamp">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Date to") ?></label>
                                    <input type="text" class="form-control datepicker" name="to_timestamp" value=""
                                           autocomplete="off" id="to_timestamp">
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset>
                                <div class="form-group">
                                    <div style="float:right;">
                                        <button type="submit"
                                                class="btn btn-primary btn-sm"><?php echo $txt->txt("Delete custom pricing") ?></button>
                                        <button type="button" class="btn btn-default btn-sm"
                                                data-dismiss="modal"><?php echo $txt->txt("Close") ?></button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                </form>

                <script>
                    jQuery(document)
                    .ready(function(){


                        // Configuration for ajax form submission
                        var options = {
                            beforeSubmit: validate,
                            success     : response_pricing_delete,
                            resetForm   : true
                        };

                        // Binding the form for ajax submission
                        jQuery('.pricing-delete')
                        .submit(function(){
                            jQuery(this)
                            .ajaxSubmit(options);

                            // prevents normal form submission
                            return false;
                        });

                        function validate(){
                            return true;
                        }

                        function response_pricing_delete(){
                            jQuery('#modal')
                            .modal('hide');
                            has_ajax_call('schedule-pricing-manager',
                                          'false',
                                          'false',
                                          'pricing', <?php echo $room_type_id;?>, <?php echo $current_year;?>);

                            notify('<?php _e("Pricing updated") ?>');
                        }


                        // Make the datepicker input fields
                        jQuery("#to_timestamp")
                        .datepicker(
                                {
                                    dateFormat: 'dd M, yy'
                                });

                        jQuery("#from_timestamp")
                        .datepicker(
                                {
                                    dateFormat: 'dd M, yy',
                                    onSelect  : function(){
                                        var date2 = jQuery('#from_timestamp')
                                        .datepicker('getDate');
                                        date2.setDate(date2.getDate()+1);
                                        //alert(date2);
                                        //date2.setDate(date2.getDate() + 1);
                                        //jQuery('#to_timestamp').val(date2);
                                        //sets minDate to dt1 date + 1
                                        jQuery('#to_timestamp')
                                        .datepicker('option',
                                                    'minDate',
                                                    date2);
                                    }
                                });

                    });
                </script> <?php

            }

        }
    }