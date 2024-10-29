<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('PaymentGatewaysSettings')){
        class PaymentGatewaysSettings extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function payment_gateways_settings_layout(){
                $controller = new Controller;
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method_api = new Methods;
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                ?>
                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="main-body-section">
                                <h3 class="panel-title"><?php echo $txt->txt("Hotel Settings") ?></h3>
                            </div>
                            <div class="panel-body">
                                <form method="post" action="<?php echo admin_url(); ?>admin-post.php"
                                      class="payment-settings">
                                    <input type="hidden" name="action" value="has">
                                    <input type="hidden" name="task" value="save_payment_settings">
                                    <input type="hidden" name="nonce"
                                           value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                                    <br>
                                    <fieldset>
                                        <!---------- PAYPAL API SETTINGS ---------->
                                        <legend>
                                            <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/settings/paypal-32.png'; ?>"> <?php echo $txt->txt("PayPal settings") ?>
                                        </legend>
                                        <hr>
                                        <?php
                                            $paypal_settings_json = $method_api->has_get_settings('paypal');
                                            $paypal_settings_array = json_decode($paypal_settings_json);

                                            $paypal_active_status = $paypal_settings_array[0]->active;
                                            $paypal_mode = $paypal_settings_array[0]->mode;

                                            $paypal_sandbox_client_id = $paypal_settings_array[0]->sandbox_client_id;
                                            $paypal_production_client_id = $paypal_settings_array[0]->production_client_id;

                                            $paypal_currency = $paypal_settings_array[0]->currency;
                                        ?>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Active") ?> </label>
                                            <select class="form-control" name="paypal_active_status">
                                                <option value="1" <?php if ($paypal_active_status == '1'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("Yes") ?></option>
                                                <option value="0" <?php if ($paypal_active_status == '0'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("No") ?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Mode") ?> </label>
                                            <select class="form-control" name="paypal_mode">
                                                <option value="sandbox" <?php if ($paypal_mode == 'sandbox'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("Sandbox") ?></option>
                                                <option value="production" <?php if ($paypal_mode == 'production'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("Production") ?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Sandbox client ID") ?> </label>
                                            <input type="text" class="form-control" name="paypal_sandbox_client_id"
                                                   value="<?php echo $paypal_sandbox_client_id; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Production client ID") ?> </label>
                                            <input type="text" class="form-control" name="paypal_production_client_id"
                                                   value="<?php echo $paypal_production_client_id; ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Currency </label>
                                            <select class="form-control" name="paypal_currency">
                                                <?php
                                                    $paypal_currencies = array('AUD',
                                                                               'CAD',
                                                                               'EUR',
                                                                               'GBP',
                                                                               'JPY',
                                                                               'USD',
                                                                               'NZD',
                                                                               'CHF',
                                                                               'HKD',
                                                                               'SGD',
                                                                               'SEK',
                                                                               'DKK',
                                                                               'PLN',
                                                                               'NOK',
                                                                               'HUF',
                                                                               'CZK',
                                                                               'ILS',
                                                                               'MXN',
                                                                               'BRL',
                                                                               'MYR',
                                                                               'PHP',
                                                                               'TWD',
                                                                               'THB',
                                                                               'TRY');
                                                    for ($i = 0; $i < sizeof($paypal_currencies); $i++):
                                                        ?>
                                                        <option value="<?php echo $paypal_currencies[$i]; ?>"
                                                                <?php if ($paypal_currency == $paypal_currencies[$i]){
                                                                    echo 'selected';
                                                                } ?>>

                                                            <?php echo $paypal_currencies[$i]; ?></option>
                                                    <?php endfor; ?>

                                            </select>
                                        </div>
                                        <!---------- STRIPE API SETTINGS ---------->
                                        <legend>
                                            <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/settings/stripe-32.png'; ?>"> <?php echo $txt->txt('Stripe settings') ?>
                                        </legend>
                                        <hr>
                                        <?php
                                            $stripe_settings_json = $method_api->has_get_settings('stripe');
                                            $stripe_settings_array = json_decode($stripe_settings_json);

                                            $stripe_active_status = $stripe_settings_array[0]->active;
                                            $stripe_test_mode = $stripe_settings_array[0]->testmode;

                                            $stripe_public_test_key = $stripe_settings_array[0]->public_test_key;
                                            $stripe_secret_test_key = $stripe_settings_array[0]->secret_test_key;

                                            $stripe_public_live_key = $stripe_settings_array[0]->public_live_key;
                                            $stripe_secret_live_key = $stripe_settings_array[0]->secret_live_key;

                                            $stripe_currency = $stripe_settings_array[0]->currency;
                                        ?>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Active") ?> </label>
                                            <select class="form-control" name="stripe_active_status">
                                                <option value="1" <?php if ($stripe_active_status == '1'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("Yes") ?></option>
                                                <option value="0" <?php if ($stripe_active_status == '0'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("No") ?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Test mode") ?> </label>
                                            <select class="form-control" name="stripe_test_mode">
                                                <option value="on" <?php if ($stripe_test_mode == 'on'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("On") ?></option>
                                                <option value="off" <?php if ($stripe_test_mode == 'off'){
                                                    echo 'selected';
                                                } ?>>
                                                    <?php echo $txt->txt("Off") ?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Test mode public key") ?> </label>
                                            <input type="text" class="form-control" name="stripe_public_test_key"
                                                   value="<?php echo $stripe_public_test_key; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Test mode secret key") ?> </label>
                                            <input type="text" class="form-control" name="stripe_secret_test_key"
                                                   value="<?php echo $stripe_secret_test_key; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Live mode public key") ?> </label>
                                            <input type="text" class="form-control" name="stripe_public_live_key"
                                                   value="<?php echo $stripe_public_live_key; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><?php echo $txt->txt("Live mode secret key ") ?></label>
                                            <input type="text" class="form-control" name="stripe_secret_live_key"
                                                   value="<?php echo $stripe_secret_live_key; ?>">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label><?php echo $txt->txt("Currency") ?> </label>
                                            <select class="form-control" name="stripe_currency">

                                                <?php
                                                    $stripe_currencies = array('USD',
                                                                               'AED',
                                                                               'AFN',
                                                                               'ALL',
                                                                               'AMD',
                                                                               'ANG',
                                                                               'AOA',
                                                                               'ARS',
                                                                               'AUD',
                                                                               'AWG',
                                                                               'AZN',
                                                                               'BAM',
                                                                               'BBD',
                                                                               'BDT',
                                                                               'BGN',
                                                                               'BIF',
                                                                               'BMD',
                                                                               'BND',
                                                                               'BOB',
                                                                               'BRL',
                                                                               'BSD',
                                                                               'BWP',
                                                                               'BZD',
                                                                               'CAD',
                                                                               'CDF',
                                                                               'CHF',
                                                                               'CLP',
                                                                               'CNY',
                                                                               'COP',
                                                                               'CRC',
                                                                               'CVE',
                                                                               'CZK',
                                                                               'DJF',
                                                                               'DKK',
                                                                               'DOP',
                                                                               'DZD',
                                                                               'EGP',
                                                                               'ETB',
                                                                               'EUR',
                                                                               'FJD',
                                                                               'FKP',
                                                                               'GBP',
                                                                               'GEL',
                                                                               'GIP',
                                                                               'GMD',
                                                                               'GNF',
                                                                               'GTQ',
                                                                               'GYD',
                                                                               'HKD',
                                                                               'HNL',
                                                                               'HRK',
                                                                               'HTG',
                                                                               'HUF',
                                                                               'IDR',
                                                                               'ILS',
                                                                               'INR',
                                                                               'ISK',
                                                                               'JMD',
                                                                               'JPY',
                                                                               'KES',
                                                                               'KGS',
                                                                               'KHR',
                                                                               'KMF',
                                                                               'KRW',
                                                                               'KYD',
                                                                               'KZT',
                                                                               'LAK',
                                                                               'LBP',
                                                                               'LKR',
                                                                               'LRD',
                                                                               'LSL',
                                                                               'MAD',
                                                                               'MDL',
                                                                               'MGA',
                                                                               'MKD',
                                                                               'MMK',
                                                                               'MNT',
                                                                               'MOP',
                                                                               'MRO',
                                                                               'MUR',
                                                                               'MVR',
                                                                               'MWK',
                                                                               'MXN',
                                                                               'MYR',
                                                                               'MZN',
                                                                               'NAD',
                                                                               'NGN',
                                                                               'NIO',
                                                                               'NOK',
                                                                               'NPR',
                                                                               'NZD',
                                                                               'PAB',
                                                                               'PEN',
                                                                               'PGK',
                                                                               'PHP',
                                                                               'PKR',
                                                                               'PLN',
                                                                               'PYG',
                                                                               'QAR',
                                                                               'RON',
                                                                               'RSD',
                                                                               'RUB',
                                                                               'RWF',
                                                                               'SAR',
                                                                               'SBD',
                                                                               'SCR',
                                                                               'SEK',
                                                                               'SGD',
                                                                               'SHP',
                                                                               'SLL',
                                                                               'SOS',
                                                                               'SRD',
                                                                               'STD',
                                                                               'SVC',
                                                                               'SZL',
                                                                               'THB',
                                                                               'TJS',
                                                                               'TOP',
                                                                               'TRY',
                                                                               'TTD',
                                                                               'TWD',
                                                                               'TZS',
                                                                               'UAH',
                                                                               'UGX',
                                                                               'UYU',
                                                                               'UZS',
                                                                               'VND',
                                                                               'VUV',
                                                                               'WST',
                                                                               'XAF',
                                                                               'XCD',
                                                                               'XOF',
                                                                               'XPF',
                                                                               'YER',
                                                                               'ZAR',
                                                                               'ZMW');
                                                    for ($i = 0; $i < sizeof($stripe_currencies); $i++):
                                                        ?>
                                                        <option value="<?php echo $stripe_currencies[$i]; ?>"
                                                                <?php if ($stripe_currency == $stripe_currencies[$i]){
                                                                    echo 'selected';
                                                                } ?>>

                                                            <?php echo $stripe_currencies[$i]; ?></option>
                                                    <?php endfor; ?>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="submit" class="btn btn-sm btn-primary" value="<?php echo $txt->txt('Update settings')?>">
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
                                        jQuery('.payment-settings')
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
                                            notify('<?php echo $txt->txt('Hotel name must be filled up!') ?>');
                                            jQuery('#name')
                                            .focus();
                                            return false;
                                        }
                                        return true;
                                    }

                                    function response_translations_saved(){

                                        has_ajax_call();

                                        notify('<?php echo $txt->txt('Payment settings updated') ?>');
                                    }

                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include $controller->plugin_path . 'layouts/backend/header/modal.php';
            }
        }
    }
