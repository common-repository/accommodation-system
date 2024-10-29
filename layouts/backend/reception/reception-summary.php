<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ReceptionSummary')){
        class ReceptionSummary extends Reception{

            function __construct(){
                parent::__construct();
            }

            public static function reception_summary_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                $booking_id = sanitize_text_field($_POST['param1']);
                $sub_total_room_price = 0;
                $sub_total_service_price = 0;

                $vat_percentage = $method->has_get_settings('vat_percentage');
                global $wpdb;
                $booking = $wpdb->prefix . 'hotel_has_booking';
                $query_result = $wpdb->get_results("SELECT * FROM `$booking` WHERE `booking_id` = $booking_id ",
                                                   ARRAY_A);

                foreach ($query_result as $row):
                    ?>
                    <div class="row">
                        <div class="main-body-section">
                            <h3 class="panel-title"><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/reception/details-24.png'; ?>"> <?php echo $txt->txt($txt->txt("Details")) ?>
                            </h3>
                            <div class="col-md-6">
                                <button type="button"
                                        onclick="has_ajax_call('reception-booking-edit', 'true', 'false', 'modal_body', <?php echo $booking_id; ?>)"
                                        class="has-button-default">
                                    <i class="fa fa-pencil"></i> <?php echo $txt->txt("edit") ?>
                                </button>
                                <button type="button" class="has-button-default"
                                        onclick="has_ajax_call('reception-payment', 'true', 'false', 'modal_body', <?php echo $booking_id; ?>)">
                                    <i class="fa fa-credit-card"></i>
                                    <?php echo $txt->txt("payment") ?>
                                </button>
                                <button type="button" class="has-button-default"
                                        onclick="has_ajax_call('reception-delete', 'true', 'false', 'modal_body', <?php echo $booking_id; ?>)">
                                    <i class="fa fa-trash"></i>
                                    <?php echo $txt->txt("Delete") ?>
                                </button>
                            </div>
                        </div>
                        <hr style="margin: 10px;">
                        <!-- Filter toggling button -->

                    </div>
                    <div class="row">

                        <div class="col-md-6" style="text-align:left;">
                            <h5><?php echo $txt->txt("Created by") . ' ' ?><span class="badge badge-info"><?php echo $row['created_by']?></h5>
                        </div>
                        <div class="col-md-3" style="text-align:right;">

                        </div>
                    </div>

                    <div class="row">
                        <!-- GUEST PERSONAL DETAIL -->
                        <div class="col-md-6">
                            <h6><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/reception/user-24.png'; ?>"> <?php echo $txt->txt("Guest detail") ?></h6>
                            <table class="table table-striped">
                                <tr>
                                    <td>
                                        <?php echo $txt->txt("Name") ?>
                                    </td>
                                    <td>
                                        <?php echo $row['name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $txt->txt("Email") ?>
                                    </td>
                                    <td>
                                        <?php echo $row['email']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $txt->txt("Address") ?>
                                    </td>
                                    <td>
                                        <?php echo $row['address']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $txt->txt("Phone") ?>
                                    </td>
                                    <td>
                                        <?php echo $row['phone']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $txt->txt("Total guests") ?>
                                    </td>
                                    <td>
                                        <?php echo $row['total_guest']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $txt->txt("Summary") ?>
                                    </td>
                                    <td>
                                        <?php echo $row['summary']; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- ROOM ALLOCATION DETAIL -->
                        <div class="col-md-6">
                            <h6><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/reception/room-24.png'; ?>"> <?php echo $txt->txt("Room allocation") ?></h6>
                            <table class="table table-striped">
                                <tbody>
                                <?php
                                    $allocated_rooms = $method->has_get_booking_allocated_rooms($booking_id);
                                    foreach ($allocated_rooms as $row2):
                                        ?>
                                        <tr>
                                            <td>
                                                <i class="fa fa-dot"></i>
                                                <?php echo $method->has_get_room_name($row2['room_id']); ?>
                                            </td>
                                            <td>
                                        <span class="small_text">
                                            <?php echo date('d M, Y',
                                                            $row2['checkin_timestamp']); ?> -
                                            <?php echo date('d M, Y',
                                                            $row2['checkout_timestamp']); ?>
                                        </span>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $method->has_currency($row2['price']);
                                                    $sub_total_room_price += $row2['price'];
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <!-- service selected -->
                        <div class="col-md-6">
                            <h6><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/reception/services-24.png'; ?>"> <?php echo $txt->txt("Services selected") ?></h6>
                            <table class="table table-striped">
                                <?php
                                    $booking_services = $method->has_get_booking_attached_services($booking_id);
                                    foreach ($booking_services as $row2):
                                        if ($row2['type'] == '1'){
                                            $sub_total_service_price += $row2['price'];
                                        }
                                        if ($row2['type'] == '2'){
                                            $sub_total_service_price += ($row2['price']*$row2['guest_number']);
                                        }
                                        if ($row2['type'] == '3'){
                                            $sub_total_service_price += ($row2['price']*$row2['night_number']);
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <?php
                                                    echo $method->has_get_service_name($row2['service_id']);
                                                ?>
                                            </td>
                                            <td align="right">
                                                <?php
                                                    if ($row2['type'] == '2'){
                                                        echo $row2['guest_number'] . ' ' . $txt->txt('guests');
                                                    }
                                                    if ($row2['type'] == '3'){
                                                        echo $row2['night_number'] . ' ' . $txt->txt('nights');
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                ?>
                            </table>
                        </div>

                        <!-- payment summary -->
                        <div class="col-md-6">
                            <h6><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/reception/invoice-24.png'; ?>"> <?php echo $txt->txt("Invoice") ?></h6>
                            <table class="table table-striped">
                                <tr>
                                    <td>
                                        <?php echo $txt->txt("Room Pricing") ?>
                                    </td>
                                    <td align="left">
                                        <?php echo $method->has_currency($sub_total_room_price); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $txt->txt("Service Pricing") ?>
                                    </td>
                                    <td align="left">
                                        <?php echo $method->has_currency($sub_total_service_price); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $txt->txt("V.A.T") ?> (<?php echo $vat_percentage; ?>%)
                                    </td>
                                    <td align="left">
                                        <?php
                                            $sub_total = $sub_total_room_price + $sub_total_service_price;
                                            $vat_amount = round($sub_total*$vat_percentage/100);
                                            echo $method->has_currency($vat_amount);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $txt->txt("Total payable") ?>
                                    </td>
                                    <td align="left">
                                        <b>
                                            <?php
                                                $grand_total = $sub_total + $vat_amount;
                                                echo $method->has_currency($grand_total);
                                            ?>
                                        </b>
                                    </td>
                                </tr>
                                <?php
                                    $total_paid_amount = 0;
                                    $payments = $method->has_get_booking_payments($booking_id);
                                    foreach ($payments as $row2):
                                        $total_paid_amount += $row2['amount'];
                                    endforeach;
                                ?>
                                <tr>
                                    <td>
                                        <b><?php echo $txt->txt("Paid") ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo $method->has_currency($total_paid_amount); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b><?php echo $txt->txt("Due") ?></b>
                                    </td>
                                    <td>
                                        <b><?php echo $method->has_currency($grand_total - $total_paid_amount); ?></b>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>


                <?php
                endforeach;
                ?>
                <style>
                    .small_text{
                        font-size: 10px;
                        color: #999;
                    }
                </style> <?php

            }

        }
    }