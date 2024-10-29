<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Settings')){
        class Settings extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function settings_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <div class="bs-component">
                    <div class="row-sidebar">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item active" style="float: left;">
                                    <a class="nav-link active" data-toggle="tab" href="#tab1"
                                       onclick="has_ajax_call('general-settings', 'false', 'false', 'tab1')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/settings/settings.png'; ?>"> <?php echo $txt->txt("General") ?></a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link" data-toggle="tab" href="#tab2"
                                       onclick="has_ajax_call('payment-gateways-settings', 'false', 'false', 'tab2')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/settings/payment-settings.png'; ?>"> <?php echo $txt->txt("Payment") ?></a>
                                </li>

                            <!--
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link" data-toggle="tab" href="#tab3"
                                       onclick="has_ajax_call('style-settings', 'false', 'false', 'tab3')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/settings/style.png'; ?>"> </i> <?php echo $txt->txt("Style") ?></a>
                                </li>
                            -->
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade in active" id="tab1">
                                    <?php _e("loading",
                                             self::$text_domain) ?>..
                                </div>
                                <div class="tab-pane fade" id="tab2">
                                    <?php _e("loading",
                                             self::$text_domain) ?>..
                                </div>
                                <div class="tab-pane fade" id="tab3">
                                    <?php _e("loading",
                                             self::$text_domain) ?>..
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    jQuery(document)
                    .ready(function(){
                        has_ajax_call('general-settings',
                                      'false',
                                      'false',
                                      'tab1');
                    });
                </script>
                <?php
                include $controller->plugin_path . 'layouts/backend/header/modal.php';
            }

        }
    }