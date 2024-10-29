<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Translate')){
        class Translate extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function translate_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <div class="bs-component">
                    <div class="row-sidebar">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item active" style="float: left;">
                                    <a class="nav-link" data-toggle="tab" href="#tab1"
                                       onclick="has_ajax_call('translate-pages', 'false', 'false', 'tab1')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/translate/translate.png'; ?>"> <?php echo $txt->txt("Reception") ?></a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link"
                                       onclick="scroll_to('ROOMS')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/translate/translate.png'; ?>"> <?php echo $txt->txt("Rooms") ?></a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link"
                                       onclick="scroll_to('SCHEDULE')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/translate/translate.png'; ?>"> <?php echo $txt->txt("Schedule") ?></a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link"
                                       onclick="scroll_to('OPTIONS')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/translate/translate.png'; ?>"> <?php echo $txt->txt("Options") ?></a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link"
                                       onclick="scroll_to('WALLET')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/translate/translate.png'; ?>"> <?php echo $txt->txt("Wallet") ?></a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link"
                                       onclick="scroll_to('SETTINGS')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/translate/translate.png'; ?>"> <?php echo $txt->txt("Settings") ?></a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link"
                                       onclick="scroll_to('TRANSLATE')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/translate/translate.png'; ?>"> <?php echo $txt->txt("Translate") ?></a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link"
                                       onclick="scroll_to('SYNC')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/translate/translate.png'; ?>"> <?php echo $txt->txt("Synchronization") ?></a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link"
                                       onclick="scroll_to('FRONTEND')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/translate/translate.png'; ?>"></i> <?php echo $txt->txt("Frontend") ?></a>
                                </li>
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
                                <div class="tab-pane fade" id="tab4">
                                    <?php _e("loading",
                                             self::$text_domain) ?>..
                                </div>
                                <div class="tab-pane fade" id="tab5">
                                    <?php _e("loading",
                                             self::$text_domain) ?>..
                                </div>
                                <div class="tab-pane fade" id="tab6">
                                    <?php _e("loading",
                                        self::$text_domain) ?>..
                                </div>
                                <div class="tab-pane fade" id="tab7">
                                    <?php _e("loading",
                                        self::$text_domain) ?>..
                                </div>
                                <div class="tab-pane fade" id="tab8">
                                    <?php _e("loading",
                                        self::$text_domain) ?>..
                                </div>
                                <div class="tab-pane fade" id="tab9">
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
                        has_ajax_call('translate-pages',
                                      'false',
                                      'false',
                                      'tab1');
                    });
                    function scroll_to(param){
                        document.getElementById("category_"+param).scrollIntoView({behavior: "smooth"})
                    }
                </script>

                <script>
                    jQuery(document)
                    .ready(function(){
                        // Configuration for ajax form submission
                        var options = {
                            beforeSubmit: validate,
                            success     : response_translation_saved,
                            resetForm   : false
                        };

                        // Binding the form for ajax submission
                        jQuery('.translate')
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
                            jQuery('#name')
                            .focus();
                            return false;
                        }
                        return true;
                    }

                    function response_translation_saved(){

                        has_ajax_call();

                        notify('translations updated');
                    }

                </script>
                <?php include $controller->plugin_path . 'layouts/backend/header/modal.php';
            }

        }
    }