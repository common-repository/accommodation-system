<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('WalletStats')){
        class WalletStats extends Wallet{

            function __construct(){
                parent::__construct();
            }

            public static function wallet_stats_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $start_date = sanitize_text_field($_POST['param1']);
                $end_date = sanitize_text_field($_POST['param2']);
                $start_timestamp = strtotime($start_date);
                $end_timestamp = strtotime($end_date);
                ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <?php echo $txt->txt("Date") ?>
                                </th>
                                <th>
                                    <?php echo $txt->txt("Amount") ?>
                                </th>
                                <th>
                                    <?php echo $txt->txt("Details") ?>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $total_amount = 0;
                                global $wpdb;
                                $table = $wpdb->prefix . 'hotel_has_payment';
                                $query_result = $wpdb->get_results("SELECT * FROM `$table` WHERE `timestamp` >= $start_timestamp AND `timestamp` <= $end_timestamp",
                                                                   ARRAY_A);
                                foreach ($query_result as $row):
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo date("d M, Y",
                                                            $row['timestamp']); ?>
                                        </td>
                                        <td>
                                            <?php echo $method->has_currency($row['amount']);
                                                $total_amount += $row['amount']; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-default"
                                                    onclick="has_ajax_call('reception-summary', 'true', 'false', 'modal_body', <?php echo $row['booking_id']; ?>)">
                                                <?php _e("booking detail") ?>
                                            </button>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            ?>
                            </tbody>
                        </table>
                        <hr>
                        <h5><?php echo $txt->txt('Total') . ' ' . $method->has_currency($total_amount); ?></h5>
                    </div>
                </div> <?php
            }

        }
    }