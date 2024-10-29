<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('Wallet')){

        class Wallet extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function wallet_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                ?>
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="main-body-section">
                            <h3 class="panel-title"><?php echo $txt->txt("Payment report") ?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-3" style="text-align: center;">
                                    <h6><?php echo $txt->txt("Select Date Range") ?></h6>
                                </div>
                                <div class="col-md-3">
                                    <div id="reportrange"
                                         style="background: #fff; cursor: pointer; padding: 7px 15px; border: 1px solid #ccc;	">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <b class="caret"></b>
                                    </div>
                                    <input type="hidden" id="start_date" name="start_date" value="">
                                    <input type="hidden" id="end_date" name="end_date" value="">
                                </div>
                                <div class="col-md-3" style="text-align: center">
                                    <button class="has-button-default" onclick="load_report()"><?php echo $txt->txt("Filter") ?></button>
                                </div>
                            </div>
                            <hr>
                            <div id="report_holder"></div>
                        </div>
                    </div>
                </div>

                <?php include $controller->plugin_path . 'layouts/backend/header/modal.php'; ?>

                <script>

                    jQuery(document)
                    .ready(function() {

                        // Making daterangepicker
                        var start = moment().startOf('month');
                        var end = moment().endOf('month');

                        function cb(start, end)
                        {
                            jQuery('#reportrange span').html(start.format('D MMM, YYYY')+' - '+end.format('D MMM, YYYY'));
                            jQuery('#start_date').val(start.format('D MMM, YYYY'));
                            jQuery('#end_date').val(end.format('D MMM, YYYY'));
                        }

                        jQuery('#reportrange')
                        .daterangepicker({
                                             startDate: start,
                                             endDate  : end,
                                             ranges   : {
                                                 '<?php echo $txt->txt("Today") ?>'       : [moment(), moment()],
                                                 '<?php echo $txt->txt("Yesterday") ?>'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                                 '<?php echo $txt->txt("Last 7 Days") ?>' : [moment().subtract(6, 'days'), moment()],
                                                 '<?php echo $txt->txt("Last 30 Days") ?>': [moment().subtract(29, 'days'), moment()],
                                                 '<?php echo $txt->txt("This Month") ?>'  : [moment().startOf('month'), moment().endOf('month')],
                                                 '<?php echo $txt->txt("Last Month") ?>'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                                             }
                                         }, cb);
                        cb(start, end);
                        load_report();
                    });

                    function load_report(){
                        // Loading the default report page
                        var start_date = jQuery('#start_date').val();
                        var end_date = jQuery('#end_date').val();
                        has_ajax_call('wallet-stats', 'false', 'false', 'report_holder', start_date, end_date);
                    }
                </script> <?php
            }

        }
    }