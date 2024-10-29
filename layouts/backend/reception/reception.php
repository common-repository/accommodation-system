<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Reception')){
        class Reception extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function main(){
                $controller = new Controller();
                include $controller->plugin_path . 'layouts/backend/header/header.php';
                include $controller->plugin_path . 'includes/translations/translations.php';
                $header = new HASTemplateHeader();
                $txt = new Translation;
                $header->template_header();
                self::reception_layout();
            }

            public static function reception_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                ?>

                <div class="main-ajax-response" id="main-ajax-response">
                    <div class="row">
                        <div class="col-md-6">
                            <?php include 'reception-filter.php';
                                ReceptionFilter::reception_filter_layout();
                            ?>
                            <div id="booking_list_holder">

                            </div>
                        </div>
                        <div class="col-md-6 " id="booking_detail_top">
                            <div class="main-body-section">
                                <h3 class="panel-title"><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/reception/details-24.png'; ?>"></i> <?php echo $txt->txt("Details") ?>
                                </h3>
                            </div>
                            <hr style="margin: 10px;">
                            <div id="booking_detail">
                                <center style="margin:100px 0px;">
                                    <h5 style=" color:#9e9e9e;">
                                        <i class="fa fa-hand-pointer-o" style="font-size:20px;"></i>
                                        <?php echo $txt->txt("Click on a booking from list or from calendar, to view details") ?>
                                    </h5>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php include 'reception-availability.php';
                                ReceptionAvailability::reception_availability_layout();
                            ?>
                        </div>
                    </div>
                </div>
                <?php require_once $controller->plugin_path . 'layouts/backend/header/modal.php';
            }

        }
    }