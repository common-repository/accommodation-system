<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('GeneralSettings')){
        class GeneralSettings extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function general_settings_layout(){
                $controller = new Controller;
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method_api = new Methods;
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <div class="row" style="margin-top:30px;">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="main-body-section">
                                <h3 class="panel-title"><?php echo $txt->txt("Hotel Settings") ?></h3>
                            </div>
                            <div class="panel-body">
                                <form method="post" action="<?php echo admin_url(); ?>admin-post.php"
                                      class="general-settings">
                                    <input type="hidden" name="action" value="has">
                                    <input type="hidden" name="task" value="save_general_settings">
                                    <input type="hidden" name="nonce"
                                           value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">

                                    <!-- GENERAL HOTEL SETTINGS -->
                                    <fieldset>
                                        <legend>
                                            <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/settings/settings-24.png'; ?>"> <?php echo $txt->txt("General settings") ?>
                                        </legend>
                                        <hr>
                                        <div class="form-group col-md-12" style="text-align:center;">
                                            <img src="<?php echo $method_api->has_get_settings('logo_url'); ?>"
                                                 id="logo_image"
                                                 style="height:100px; min-width:100px; border:1px solid #ccc; padding: 2px; margin:10px;">
                                            <br>
                                            <input type="hidden" name="logo_url"
                                                   value="<?php echo $method_api->has_get_settings('logo_url'); ?>"
                                                   id="logo_url">
                                            <button class="has-button-default" onclick="open_media_uploader()"
                                                    type="button"><?php echo $txt->txt("Select logo") ?></button>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Hotel name") ?></label>
                                            <input type="text" class="form-control" name="hotel_name" id="hotel_name"
                                                   value="<?php echo $method_api->has_get_settings('hotel_name'); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Address") ?></label>
                                            <input type="text" class="form-control" name="address"
                                                   value="<?php echo $method_api->has_get_settings('address'); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Phone") ?></label>
                                            <input type="text" class="form-control" name="phone"
                                                   value="<?php echo $method_api->has_get_settings('phone'); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Email") ?></label>
                                            <input type="text" class="form-control" name="email"
                                                   value="<?php echo $method_api->has_get_settings('email'); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Currency") ?></label>
                                            <select class="form-control" name="country_id">
                                                <?php
                                                    $saved_country_id = $method_api->has_get_settings('country_id');
                                                    $countries = $method_api->has_get_countries();
                                                    foreach ($countries as $row):
                                                        if ($row['currency_symbol'] == ''){
                                                            continue;
                                                        }
                                                        ?>
                                                        <option value="<?php echo $row['country_id']; ?>"
                                                                <?php if ($saved_country_id == $row['country_id']){
                                                                    echo 'selected';
                                                                } ?>>
                                                            <?php echo $row['currency_name'] . ' , ' . $row['currency_symbol']; ?>
                                                        </option>
                                                    <?php
                                                    endforeach;
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                            $saved_currency_location = $method_api->has_get_settings('currency_location');
                                            $admin_notification = $method_api->has_get_settings('admin_notification');
                                            $customer_notification = $method_api->has_get_settings('customer_notification');
                                        ?>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Currency position") ?></label>
                                            <select class="form-control" name="currency_location">
                                                <option value="right" <?php if ($saved_currency_location == 'right'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("Right") ?></option>
                                                <option value="left" <?php if ($saved_currency_location == 'left'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("Left") ?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Enable admin notification") ?></label>
                                            <select class="form-control" name="admin_notification">
                                                <option value="yes" <?php if ($admin_notification == 'yes'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("Yes") ?></option>
                                                <option value="no" <?php if ($admin_notification == 'no'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("No") ?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Enable user notification") ?></label>
                                            <select class="form-control" name="customer_notification">
                                                <option value="yes" <?php if ($customer_notification == 'yes'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("Yes") ?></option>
                                                <option value="no" <?php if ($customer_notification == 'no'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("No") ?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Vat Percentage") ?></label>
                                            <input type="text" class="form-control" name="vat_percentage"
                                                   value="<?php echo $method_api->has_get_settings('vat_percentage'); ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="submit" class="btn btn-sm btn-primary" value="<?php echo $txt->txt('Update settings') ?>">
                                        </div>
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    jQuery(document)
                    .ready(function(){
                        // Configuration for ajax form submission
                        var options = {
                            beforeSubmit: validate,
                            success     : response_settings_saved,
                            resetForm   : false
                        };

                        // Binding the form for ajax submission
                        jQuery('.general-settings')
                        .submit(function(){
                            jQuery(this)
                            .ajaxSubmit(options);

                            // prevents normal form submission
                            return false;
                        });


                    });

                    function validate(){
                        if (jQuery('#hotel_name')
                        .val() == ''){
                            notify_warning('Hotel name must be filled up!');
                            notify('<?php echo $txt->txt('Hotel name must be filled up!') ?>');

                            jQuery('#name')
                            .focus();
                            return false;
                        }
                        return true;
                    }

                    function response_settings_saved(){

                        has_ajax_call();

                        notify('<?php echo $txt->txt('General settings updated') ?>');
                    }

                    // WP MEDIA UPLOADER FOR LOGO UPLOADING

                    var media_uploader = null;

                    function open_media_uploader(){
                        media_uploader = wp.media({
                                                      frame   : "post",
                                                      state   : "insert",
                                                      multiple: false
                                                  });

                        media_uploader.on("insert",
                                          function(){
                                              var json = media_uploader.state()
                                                                       .get("selection")
                                                                       .first()
                                                                       .toJSON();

                                              var image_url = json.url;
                                              var image_caption = json.caption;
                                              var image_title = json.title;

                                              jQuery("#logo_url")
                                              .val(image_url);
                                              jQuery("#logo_image")
                                              .attr("src",
                                                    image_url);
                                          });

                        media_uploader.open();
                    }
                </script>


                <?php include $controller->plugin_path . 'layouts/backend/header/modal.php';
            }

        }
    }
