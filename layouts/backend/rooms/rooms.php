<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Rooms')){
        class Rooms extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function rooms_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                ?>
                <div class="bs-component">
                    <div class="row-sidebar">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item active" style="float: left;">
                                    <a class="nav-link active" data-toggle="tab" href="#tab1"
                                       onclick="has_ajax_call('room-type', 'false', 'false', 'tab1')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/rooms/room-types.png'; ?>"> <?php echo $txt->txt("Room type") ?></a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link" data-toggle="tab" href="#tab2"
                                       onclick="has_ajax_call('room', 'false', 'false', 'tab2')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/rooms/rooms.png'; ?>"> <?php echo $txt->txt("Rooms") ?>
                                    </a>
                                </li>
                                <li class="nav-item" style="float: left;">
                                    <a class="nav-link" data-toggle="tab" href="#tab3"
                                       onclick="has_ajax_call('room-floor', 'false', 'false', 'tab3')">
                                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/rooms/floors.png'; ?>"> <?php echo $txt->txt("Floors") ?>
                                    </a>
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
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    jQuery(document)
                    .ready(function(){
                        has_ajax_call('room-type',
                                      'false',
                                      'false',
                                      'tab1');
                    });
                </script>
                <?php include $controller->plugin_path . 'layouts/backend/header/modal.php';
            }
        }
    }