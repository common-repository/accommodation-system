<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ScheduleAddPrice')){
        class ScheduleAddPrice extends Schedule{

            function __construct(){
                parent::__construct();
            }

            public static function schedule_add_price(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $room_type_id = sanitize_text_field($_POST['param1']);
                $current_year = sanitize_text_field($_POST['param2']);
                ?>
                <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="pricing-add">
                    <input type="hidden" name="action" value="has">
                    <input type="hidden" name="task" value="create_pricing">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                    <input type="hidden" name="room_type_id" value="<?php echo $room_type_id; ?>">

                    <div class="row">
                        <div class="col-md-12">
                            <!-- WEEK DAYS DETAIL -->
                            <fieldset>
                                <legend><?php _e("Set week days") ?></legend>
                                <div class="form-group">
                                    <input type="checkbox" class="icheck" checked name="monday" value="yes">
                                    <label><?php echo $txt->txt("Monday") ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" class="icheck" checked name="tuesday" value="yes">
                                    <label><?php echo $txt->txt("Tuesday") ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" class="icheck" checked name="wednesday" value="yes">
                                    <label><?php echo $txt->txt("Wednesday") ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" class="icheck" checked name="thursday" value="yes">
                                    <label><?php echo $txt->txt("Thursday") ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" class="icheck" checked name="friday" value="yes">
                                    <label><?php echo $txt->txt("Friday") ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" class="icheck" checked name="saturday" value="yes">
                                    <label><?php echo $txt->txt("Saturday") ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" class="icheck" checked name="sunday" value="yes">
                                    <label><?php echo $txt->txt("Sunday") ?></label>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <!-- NEW PRICE DETAIL -->
                            <fieldset>
                                <legend><?php echo $txt->txt("Set price") ?></legend>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Date from") ?></label>
                                    <input type="text" class="form-control datepicker" name="from_timestamp" value=""
                                           autocomplete="off" id="from_timestamp">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Date to") ?></label>
                                    <input type="text" class="form-control datepicker" name="to_timestamp" value=""
                                           autocomplete="off" id="to_timestamp" onblur="year();">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("New price") ?></label>
                                    <input type="text" class="form-control" name="price" value="" id="price">
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
                                                class="btn btn-primary btn-sm"><?php echo $txt->txt("Create custom pricing") ?></button>
                                        <button type="button" class="btn btn-default btn-sm"
                                                data-dismiss="modal"><?php _e("Close") ?></button>
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
                            success     : response_pricing_add,
                            resetForm   : true
                        };

                        // Binding the form for ajax submission
                        jQuery('.pricing-add')
                        .submit(function(){
                            jQuery(this)
                            .ajaxSubmit(options);

                            // prevents normal form submission
                            return false;
                        });

                        function validate(){
                            if (jQuery('#price')
                            .val() == ''){
                                notify_warning("<?php _e('Price must be filled up!') ?>");
                                jQuery('#name')
                                .focus();
                                return false;
                            }
                            return true;
                        }

                        function response_pricing_add(){
                            jQuery('#modal')
                            .modal('hide');
                            has_ajax_call('schedule-pricing-manager',
                                          'false',
                                          'false',
                                          'pricing', <?php echo $room_type_id;?>, <?php echo $current_year;?>);

                            notify("<?php _e('pricing updated!') ?>");
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

                        // Customize icheck
                        jQuery('.icheck')
                        .each(function(){
                            var self       = jQuery(this),
                                label      = self.next(),
                                label_text = label.text();

                            label.remove();
                            self.iCheck({
                                            checkboxClass: 'icheckbox_line-orange',
                                            radioClass   : 'iradio_line-orange',
                                            insert       : '<div class="icheck_line-icon"></div>'+label_text
                                        });
                        });
                    });

                    function year(){
                        var to_timestamp = jQuery('#to_timestamp')
                        .val();
                    }
                </script> <?php
            }

        }
    }
