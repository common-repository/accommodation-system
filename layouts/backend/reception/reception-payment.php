<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ReceptionPayment')){
        class ReceptionPayment extends Reception{

            function __construct(){
                parent::__construct();
            }

            public static function reception_payment(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $booking_id = sanitize_text_field($_POST['param1']);
                $sub_total_room_price = 0;
                $sub_total_service_price = 0;
                $grand_total = 0;
                $vat_percentage = $method->has_get_settings('vat_percentage');

                global $wpdb;
                $booking = $wpdb->prefix . 'hotel_has_booking';
                $query_result = $wpdb->get_results("SELECT * FROM `$booking` WHERE `booking_id` = $booking_id ",
                                                   ARRAY_A);

                foreach ($query_result as $row):
                    ?>

                    <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="booking-payment">
                        <input type="hidden" name="action" value="has">
                        <input type="hidden" name="task" value="take_payment">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>"

                        <div class="row">
                            <div class="col-md-6">
                                <!-- PAYABLE AMOUNT DETAIL INFORMATION -->
                                <fieldset>
                                    <legend><?php echo $txt->txt("Payable amount") ?></legend>
                                    <table class="table table-striped" id="rooms">
                                        <thead>
                                        <tr>
                                            <th><?php echo $txt->txt("Room") ?></th>
                                            <th><?php echo $txt->txt("Date") ?></th>
                                            <th><?php echo $txt->txt("Price") ?></th>
                                        </tr>
                                        </thead>
                                        <tbody id="booking_room_list">
                                        <?php
                                            $booking_rooms = $method->has_get_booking_allocated_rooms($booking_id);
                                            foreach ($booking_rooms as $row2):
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $method->has_get_room_name($row2['room_id']); ?>
                                                        <input type="hidden" name="rooms[]"
                                                               value="<?php echo $row2['room_id']; ?>">
                                                    </td>
                                                    <td>
                                                        <?php echo date("d M, Y",
                                                                        $row2['checkin_timestamp']); ?> -
                                                        <?php echo date("d M, Y",
                                                                        $row2['checkout_timestamp']); ?>
                                                        <input type="hidden" name="checkin_timestamps[]"
                                                               value="<?php echo $row2['checkin_timestamp']; ?>">
                                                        <input type="hidden" name="checkout_timestamps[]"
                                                               value="<?php echo $row2['checkout_timestamp']; ?>">
                                                    </td>
                                                    <td>
                                                        <?php
                                                            echo $method->has_currency($row2['price']);
                                                            $sub_total_room_price += $row2['price'];
                                                        ?>
                                                        <input type="hidden" name="prices[]"
                                                               value="<?php echo $row2['price']; ?>">
                                                    </td>
                                                </tr>
                                            <?php
                                            endforeach;
                                        ?>
                                        </tbody>
                                    </table>

                                    <table class="table table-striped" id="rooms">
                                        <thead>
                                        <tr>
                                            <th><?php echo $txt->txt("Services") ?></th>
                                            <th><?php echo $txt->txt("Unit") ?></th>
                                            <th><?php echo $txt->txt("Price") ?></th>
                                        </tr>
                                        </thead>
                                        <tbody id="booking_service_list">
                                        <?php
                                            $booking_services = $method->has_get_booking_attached_services($booking_id);
                                            foreach ($booking_services as $row3):
                                                ?>
                                                <tr>
                                                    <td><?php echo $method->has_get_service_name($row3['service_id']); ?></td>
                                                    <td>
                                                        <?php
                                                            if ($row3['type'] == 2){
                                                                echo $row3['guest_number'] . ' guest x ' . $method->has_currency($row3['price']);
                                                            }
                                                            if ($row3['type'] == 3){
                                                                echo $row3['night_number'] . ' night x ' . $method->has_currency($row3['price']);
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if ($row3['type'] == 1){
                                                                $service_individual_price = $row3['price'];
                                                            }
                                                            if ($row3['type'] == 2){
                                                                $service_individual_price = $row3['price']*$row3['guest_number'];
                                                            }
                                                            if ($row3['type'] == 3){
                                                                $service_individual_price = $row3['price']*$row3['night_number'];
                                                            }

                                                            echo $method->has_currency($service_individual_price);
                                                            $sub_total_service_price += $service_individual_price;
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            endforeach;
                                        ?>
                                        </tbody>
                                    </table>

                                    <table class="table table-striped">
                                        <tr>
                                            <td>
                                                <?php echo $txt->txt('Room Pricing'); ?>
                                            </td>
                                            <td align="left">
                                                <?php echo $method->has_currency($sub_total_room_price); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php echo $txt->txt('Service Pricing'); ?>
                                            </td>
                                            <td align="left">
                                                <?php echo $method->has_currency($sub_total_service_price); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Vat (<?php echo $vat_percentage; ?>%)
                                            </td>
                                            <td align="left">
                                                <?php

                                                    $vat_amount = round(($sub_total_room_price + $sub_total_service_price)*$vat_percentage/100);
                                                    echo $method->has_currency($vat_amount);
                                                ?>
                                            </td>
                                        </tr>
                                        <!--
                                                <tr>
                                                        <td>
                                                                Discount
                                                        </td>
                                                        <td align="left" width="30%">

                                                                <span id="discount_edit_form" style="display:none;">
                                                                        <input type="text" class="form-control" name="discount" value="<?php echo $row['discount']; ?>"
                                                                                style="width:60px;text-align:right;float:left;margin-right:5px;" >
                                                                        <button type="submit" class="btn btn-sm">
                                                                                <i class="fa fa-check"></i>
                                                                        </button>
                                                                </span>

                                                                <span id="discount_amount" style="display:block;">
                                                                        $<?php //echo $row['discount'];
                                        ?>
                                                                        <i class="fa fa-pencil"></i>
                                                                </span>
                                                        </td>
                                                </tr>
                                                -->
                                        <tr>
                                            <td>
                                                <b><?php echo $txt->txt('Total'); ?></b>
                                            </td>
                                            <td align="left">
                                                <b>
                                                    <?php
                                                        $grand_total = $sub_total_room_price + $sub_total_service_price + $vat_amount;
                                                        echo $method->has_currency($grand_total);
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>
                            <div class="col-md-6">

                                <!-- ROOM ALLOCATION INFORMATION -->
                                <fieldset>
                                    <legend><?php echo $txt->txt("Payment history") ?></legend>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th><?php echo $txt->txt("Date") ?></th>
                                            <th><?php echo $txt->txt("Price") ?></th>
                                        </tr>
                                        </thead>
                                        <?php
                                            $total_paid_amount = 0;
                                            $payments = $method->has_get_booking_payments($booking_id);
                                            foreach ($payments as $row2):
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo date("d M, Y",
                                                                        $row2['timestamp']); ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            echo $method->has_currency($row2['amount']);
                                                            $total_paid_amount += $row2['amount'];
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
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


                                </fieldset>

                                <!-- ROOM ALLOCATION INFORMATION -->
                                <fieldset>
                                    <legend><?php echo $txt->txt("Take payment") ?></legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $txt->txt("Payment date") ?></label>
                                                <input type="text" class="form-control datepicker" name="date"
                                                       readonly style="cursor:pointer;"
                                                       value="<?php echo date('d M, Y'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $txt->txt("Amount") ?></label>
                                                <input type="text" class="form-control" name="amount" id="amount"
                                                       style="text-align:right;" autofocus>
                                            </div>
                                        </div>
                                    </div>


                                </fieldset>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <div class="form-group">
                                        <div style="float:right;">
                                            <button type="submit"
                                                    class="btn btn-primary btn-sm"><?php echo $txt->txt("Take payment") ?></button>
                                            <button type="button" class="btn btn-default btn-sm"
                                                    data-dismiss="modal"><?php echo $txt->txt("Close") ?></button>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                    </form>


                    <script type="text/javascript">
                        // Ajax form plugin calls at each modal loading,
                        jQuery(document)
                        .ready(function(){

                            // Configuration for ajax form submission
                            var options = {
                                beforeSubmit: validate,
                                success     : response_take_payment,
                                resetForm   : true
                            };

                            // Binding the form for ajax submission
                            jQuery('.booking-payment')
                            .submit(function(){
                                jQuery(this)
                                .ajaxSubmit(options);

                                // prevents normal form submission
                                return false;
                            });


                            // Make the datepicker input fields
                            jQuery(".datepicker")
                            .datepicker(
                                    {
                                        dateFormat: 'dd M, yy'
                                    });


                            // Bind the delete button with available room list deletion
                            jQuery(".btn_delete_room")
                            .click(function(event){
                                jQuery(this)
                                .parent()
                                .parent()
                                .remove();
                            });

                        });

                        function validate(){
                            if (jQuery('#amount')
                            .val() == ''){
                                notify_warning('<?php echo $txt->txt("Amount must be filled up") ?>');
                                jQuery('#amount')
                                .focus();
                                return false;
                            }
                            return true;
                        }

                        // Loads the updated booking in the list
                        function response_take_payment(){
                            jQuery('#modal')
                            .modal('hide');
                            load_booking(<?php echo $booking_id;?>);
                            notify('<?php echo $txt->txt("Payment completed") ?>');
                        }


                    </script>

                <?php
                endforeach;
            }

        }
    }