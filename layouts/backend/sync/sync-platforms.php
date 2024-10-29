<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('SyncPlatforms')){

        class SyncPlatforms extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function sync_platforms_layout(){
                $controller = new Controller;
                include $controller->plugin_path . 'includes/models/methods-api.php';
                include $controller->plugin_path . 'includes/sync/airbnb-sync.php';
                include $controller->plugin_path . 'includes/sync/google-sync.php';
                $method = new Methods;
                $room_type_id = sanitize_text_field($_POST['param1']);
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                

                ?>
                <div class="col-md-12">
                    <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="sync-platforms">
                        <input type="hidden" name="action" value="has">
                        <input type="hidden" name="task" value="save_sync_data">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                        <input type="hidden" name="room_type_id" value="<?php echo $room_type_id; ?>">
                        <fieldset>
                            <!---------- AIRBNB ---------->
                            <legend><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/sync/airbnb-32.png'; ?>"> <?php echo $txt->txt("AirBnB sync") ?></legend>

                            <?php
                                $airbnb_data = $method->has_get_sync_data($room_type_id, 'airbnb_feed');
                                $airbnb_url = $airbnb_data['description'];
                                $airbnb_status = $airbnb_data['status'];
                                $airbnb_sync_time = $airbnb_data['sync_time'];

                            ?>
                            <div class="form-group col-md-3">
                                <label><?php echo $txt->txt("Active") ?> </label>
                                <select class="form-control" name="airbnb_status">
                                    <option value="1" <?php if ($airbnb_status == '1'){
                                        echo 'selected';
                                    } ?>>
                                        <?php echo $txt->txt("Yes") ?></option>
                                    <option value="0" <?php if ($airbnb_status == '0' || $airbnb_status == ''){
                                        echo 'selected';
                                    } ?>>
                                        <?php echo $txt->txt("No") ?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?php echo $txt->txt("AirBnB feed URL") ?> </label>
                                <input type="text" class="form-control" name="airbnb_url"
                                       value="<?php echo $airbnb_url !== ''
                                               ? $airbnb_url
                                               : ''; ?>">
                                <hr>
                            </div>
                            <div class="form-group col-md-3">
                                <label><?php echo $txt->txt("AirBnB sync time (seconds)") ?> </label>
                                <input type="text" class="form-control" name="airbnb_sync_time"
                                       value="<?php echo $airbnb_sync_time != ''
                                           ? $airbnb_sync_time
                                           : '3600'; ?>">
                                <hr>
                            </div>


                            <!---------- GOOGLE CALENDARS ---------->
                            <legend><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/sync/google-32.png'; ?>"> <?php echo $txt->txt('Google Calendars sync')?></legend>

                            <?php
                                $google_data = $method->has_get_sync_data($room_type_id, 'google_feed');
                                $google_url = $google_data['description'];
                                $google_status = $google_data['status'];
                                $google_sync_time = $google_data['sync_time'];
                            ?>
                            <div class="form-group col-md-3">
                                <label><?php echo $txt->txt("Active") ?> </label>
                                <select class="form-control" name="google_status">
                                    <option value="1" <?php if ($google_status == '1'){
                                        echo 'selected';
                                    } ?>>
                                        <?php echo $txt->txt("Yes") ?></option>
                                    <option value="0" <?php if ($google_status == '0' || $google_status == ''){
                                        echo 'selected';
                                    } ?>>
                                        <?php echo $txt->txt("No") ?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?php echo $txt->txt("Google Calendars feed URL") ?> </label>
                                <input type="text" class="form-control" name="google_url"
                                       value="<?php echo $google_url !== ''
                                               ? $google_url
                                               : ''; ?>">
                                <hr>
                            </div>
                            <div class="form-group col-md-3">
                                <label><?php echo $txt->txt("Google sync time (seconds)") ?> </label>
                                <input type="text" class="form-control" name="google_sync_time"
                                       value="<?php echo $google_sync_time != ''
                                           ? $google_sync_time
                                           : '3600'; ?>">
                                <hr>
                            </div>

                            <!---------- BOOKING.COM ---------->
                            <legend><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/sync/booking-32.png'; ?>"> <?php echo $txt->txt("Booking.com sync") ?></legend>

                            <?php
                            $booking_com_data = $method->has_get_sync_data($room_type_id, 'booking_com_feed');
                            $booking_com_url = $booking_com_data['description'];
                            $booking_com_status = $booking_com_data['status'];
                            $booking_com_sync_time = $booking_com_data['sync_time'];

                            ?>
                            <div class="form-group col-md-3">
                                <label><?php echo $txt->txt("Active") ?> </label>
                                <select class="form-control" name="booking_com_status">
                                    <option value="1" <?php if ($booking_com_status == '1'){
                                        echo 'selected';
                                    } ?>>
                                        <?php echo $txt->txt("Yes") ?></option>
                                    <option value="0" <?php if ($booking_com_status == '0' || $booking_com_status == ''){
                                        echo 'selected';
                                    } ?>>
                                        <?php echo $txt->txt("No") ?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?php echo $txt->txt("Booking.com feed URL") ?> </label>
                                <input type="text" class="form-control" name="booking_com_url"
                                       value="<?php echo $booking_com_url !== ''
                                           ? $booking_com_url
                                           : ''; ?>">
                                <hr>
                            </div>
                            <div class="form-group col-md-3">
                                <label><?php echo $txt->txt("Booking.com sync time (seconds)") ?> </label>
                                <input type="text" class="form-control" name="booking_com_sync_time"
                                       value="<?php echo $booking_com_sync_time != ''
                                           ? $booking_com_sync_time
                                           : '3600'; ?>">
                                <hr>
                            </div>

                            <!---------- ICAL FEED ---------->
                            <legend><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/sync/ical-32.png'; ?>"> <?php echo $txt->txt("iCal feed URL") ?></legend>

                            <div class="form-group col-md-6">
                                <input class="form-control" name="ical_feed"
                                       value="<?php echo get_site_url() . "?" . "ical_feed=true" . "_" . "feed_ID" . "_" . "$room_type_id";?>"> <?php

	                                    ?>
                                <hr>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="submit" class="btn btn-sm btn-primary" value="<?php echo $txt->txt("Update settings")?>">
                            </div>

                        </fieldset>





                    </form>
                    <script>
                        jQuery(document)
                        .ready(function(){
                            // Configuration for ajax form submission
                            var options = {
                                beforeSubmit: validate,
                                success     : response_translations_saved,
                                resetForm   : false
                            };

                            // Binding the form for ajax submission
                            jQuery('.sync-platforms')
                            .submit(function(){
                                jQuery(this)
                                .ajaxSubmit(options);

                                // prevents normal form submission
                                return false;
                            });


                        });

                        function validate(){
                            if (jQuery('#hotel_name').val() == ''){
                                notify_warning('Hotel name must be filled up!');
                                jQuery('#name')
                                .focus();
                                return false;
                            }
                            return true;
                        }

                        function response_translations_saved(){

                            has_ajax_call();

                            notify('sync data updated');
                        }

                    </script>
                </div> <?php
            }

        }

    }
