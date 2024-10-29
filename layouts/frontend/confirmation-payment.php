<?php
/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/
if (!class_exists('ConfirmationPayment')){
    class ConfirmationPayment extends Controller{

        function __construct(){
            parent::__construct();
        }

        public static function confirmation_payment(){
            $controller = new Controller();
            include $controller->plugin_path . 'includes/models/methods-api.php';
            $method = new Methods();
            include $controller->plugin_path . 'includes/translations/translations.php';
            $txt = new Translation;

            $booking_id = sanitize_text_field($_POST['booking_id']);

            // paypal settings
            $paypal_settings_json = $method->has_get_settings('paypal');
            $paypal_settings_array = json_decode($paypal_settings_json);

            $paypal_active_status = $paypal_settings_array[0]->active;
            $paypal_mode = $paypal_settings_array[0]->mode;

            $paypal_sandbox_client_id = $paypal_settings_array[0]->sandbox_client_id;
            $paypal_production_client_id = $paypal_settings_array[0]->production_client_id;

            $paypal_currency = $paypal_settings_array[0]->currency;

            // stripe settings
            $stripe_settings_json = $method->has_get_settings('stripe');
            $stripe_settings_array = json_decode($stripe_settings_json);

            $stripe_active_status = $stripe_settings_array[0]->active;
            $stripe_test_mode = $stripe_settings_array[0]->testmode;

            $stripe_public_test_key = $stripe_settings_array[0]->public_test_key;
            $stripe_secret_test_key = $stripe_settings_array[0]->secret_test_key;

            $stripe_public_live_key = $stripe_settings_array[0]->public_live_key;
            $stripe_secret_live_key = $stripe_settings_array[0]->secret_live_key;

            $stripe_currency = $stripe_settings_array[0]->currency;

            if ($stripe_test_mode == 'on'){
                $stripe_public_key = $stripe_public_test_key;
            }
            else if ($stripe_test_mode == 'off'){
                $stripe_public_key = $stripe_public_live_key;
            }

            ?>
            <div class="chb-booking-title">
                <h3><?php echo $txt->txt("Almost done... Please choose a payment method") ?></h3>
            </div>
            <div class="chb-booking-payment-wrap">
                <div class="has-container">
                    <div class="has-row">
                        <div class="has-col-lg-4">
                            <div class="chb-booking-summary-main">
                                <div class="chb-booking-summary">

                                    <!-- Booking Rooms Summary -->
                                    <h4 class="chb-booking-summary-title"><?php echo $txt->txt("Booking Summary") ?></h4>
                                    <div id="cart-rooms"></div>

                                    <!-- Booking Services Summary -->
                                    <h4 class="chb-booking-summary-title"><?php echo $txt->txt("Additional Services") ?></h4>
                                    <div class="chb-booking-sidebar-additional-service">

                                        <ul class="service-list" id="cart-services">

                                        </ul>
                                    </div>
                                    <div class="chb-booking-summary-total">
                                        <span><?php echo $txt->txt("Total") ?> :
                                            <span id="total_price"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="has-col-lg-8">
                            <div class="chb-booking-payment-box">
                                <div class="chb-booking-id-box text-center">
                                    <h4 class="chb-booking-id-title"><?php echo $txt->txt("Booking ID") . ' ' . $booking_id;  ?></h4>
                                </div>

                                <div id="payment_completion_message" style="display:none;">
                                    <div class="chb-booking-confirmed">
                                        <div class="has-container has-row">
                                            <div class="has-col-lg-12">
                                                <div class="chb-booking-confirmed-box text-center">
                                                    <h5 class="chb-payment-method-title text-center"><?php echo $txt->txt("Thanks for your payment") ?></h5>
                                                    <p><?php echo $txt->txt("Your reservation have just been confirmed. If you have any questions, please do not hesitate to contact us. Thank you!") ?></p>
                                                    <div class="has-row-contact">
                                                        <div class="has-col-lg-12">
                                                                <p>
                                                                    <?php echo $method->has_get_settings('phone'); ?>
                                                                </p>
                                                        </div>
                                                        <div class="has-col-lg-12">
                                                                <p>
                                                                    <?php echo $method->has_get_settings('email'); ?>
                                                                </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="payment_processors" style="display:block;">
            <!--                        <h5 class="chb-payment-method-title text-center"><?php echo $txt->txt("Choose a payment method") ?></h5>        -->
                                    <div class="chb-booking-payment-box-fields text-center">
                                        <div class="payment-options">
                                            <div class="has-form-group has-col-md-4">
                                                <div class="">
                                                    <label onclick="load_payment('cash')">
                                                        <input type="radio" name="inlineRadioOptions" value="cash" />
                                                        <span class="gateway-card">
                                                            <img src="<?php echo $controller->plugin_url . 'assets/css/frontend/icons/checkout_cash.png'; ?>">
                                                            <strong><?php echo $txt->txt("Cash") ?></strong>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php
                                            if ($stripe_active_status == 1):
                                                ?>
                                                <div class="has-form-group has-col-md-4">
                                                    <div class="">
                                                        <label onclick="load_payment('stripe')">
                                                            <input type="radio" name="inlineRadioOptions"
                                                                   value="stripe" />
                                                            <span class="gateway-card">
                                                            <img src="<?php echo $controller->plugin_url . 'assets/css/frontend/icons/checkout_card.png'; ?>">
                                                            <strong><?php echo $txt->txt("Stripe") ?></strong>
                                                        </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php
                                            endif;
                                            ?>

                                            <?php
                                            if ($paypal_active_status == 1):
                                                ?>
                                                <div class="has-form-group has-col-md-4">
                                                    <div class="">
                                                        <label onclick="load_payment('paypal')">
                                                            <input type="radio" name="inlineRadioOptions"
                                                                   value="paypal" />
                                                            <span class="gateway-card">
                                                            <img src="<?php echo $controller->plugin_url . 'assets/css/frontend/icons/checkout_paypal.png'; ?>">
                                                            <strong><?php echo $txt->txt("PayPal") ?></strong>
                                                        </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                        <div id="payment_button_holder" style="min-height:95px;"
                                             class="has-col-md-5 offset-md-4">
                                            <!-- cash button -->
                                            <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="cash-payment">
                                                <input type="hidden" name="action" value="has">
                                                <input type="hidden" name="task" value="cash_payment">
                                                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                                                <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                                                <button type="submit" class="has-button" onclick="cash_payment()"
                                                        style="display:none;"
                                                        id="button_cash"><?php echo $txt->txt("Pay cash on arrival") ?>
                                                </button>
                                            </form>

                                            <!-- PAYPAL PAYMENT FORM -->
                                            <div id="button_paypal" style="display:none;" onclick="waiting_response()"></div>

                                            <!-- stripe button -->
                                            <button class="has-button" id="button_stripe" style="display:none;" onclick="waiting_response()">
                                                <?php echo $txt->txt("Pay with Stripe") ?>
                                            </button>

                                            <!-- stripe payment hidden form -->
                                            <form action="<?php echo admin_url(); ?>admin-post.php" method="post"
                                                  id="stripe_form" class="stripe-ajax-handler-form">

                                                <input type="hidden" name="action" value="has">
                                                <input type="hidden" name="task" value="create_booking_stripe_payment">
                                                <input type="hidden" name="nonce"
                                                       value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">

                                                <input type="hidden" name="stripe_token" id="stripe_token" value="">
                                                <input type="hidden" name="amount" value="" id="total_amount_stripe">
                                                <input type="hidden" name="booking_id"
                                                       value="<?php echo $booking_id; ?>">
                                                <button type="submit" style="display: none;" id="stripe-submit"></button>
                                            </form>

                                            <!-- paypal payment hidden form -->
                                            <form action="<?php echo admin_url(); ?>admin-post.php" method="post"
                                                  id="paypal_form">

                                                <input type="hidden" name="action" value="has">
                                                <input type="hidden" name="task" value="create_booking_paypal_payment">
                                                <input type="hidden" name="nonce"
                                                       value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">

                                                <input type="hidden" name="amount" value="" id="total_amount_paypal">
                                                <input type="hidden" name="booking_id"
                                                       value="<?php echo $booking_id; ?>">
                                                <button type="submit" style="display: none;"
                                                        id="paypal-submit">
                                                </button>
                                            </form>
                                        </div>
                                        <div class="has-row-final-price">
                                            <div class="total-price">
                                                <p id="notice_payment_method"><?php echo $txt->txt("Choose a payment method")?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                var total_amount = 0;
                var stripe_chargeable_amount = 0; // for stripe

                // showing the selected rooms in cart section
                jQuery(document)
                    .ready(function($){
                        show_cart_in_payment_page();
                    });


                // STRIPE PAYMENT CONFIGURATION
                jQuery(document)
                    .ready(function($){

                        // settings call for stripe
                        <?php if ($stripe_active_status == 1){ ?>
                        var handler = StripeCheckout.configure({
                            key     : '<?php echo $stripe_public_key;?>', // public key for stripe account
    //                        image   : 'https://stripe.com/img/documentation/checkout/marketplace.png',
                            locale  : 'auto',
                            currency: '<?php echo $stripe_currency;?>',
                            token   : function(token){
                                // Send the charge through
                                $.post("/charges/create",
                                    { token: token.id, booking_id: <?php echo $booking_id ?> }, function(data) {
                                        if (data["status"] == "ok") {
                                            window.location = "/some-url";
                                        } else {
                                            // Deal with error
                                            alert(data["message"]);
                                        }
                                    });
                                document.getElementById('stripe_token').value = token.id;
                                jQuery('#stripe-submit')
                                         .click();

                            }
                            // token   : function(token){
                            //     // You can access the token ID with `token.id`.
                            //     // Get the token ID to your server-side code for use.
                            //
                            //     document.getElementById('stripe_token').value = token.id;
                            //     jQuery('#stripe-submit')
                            //         .click();
                            //
                            // }
                        });
                        <?php } ?>

                        // Open Checkout with further options:
                        document.getElementById('button_stripe')
                            .addEventListener('click',
                                function(e){
                                    handler.open({
                                        name   : 'Reservation Charge',
                                        zipCode: true,
                                        amount : stripe_chargeable_amount
                                    });
                                    e.preventDefault();
                                });

                        // Close Checkout on page navigation:
                        window.addEventListener('popstate',
                            function(){
                                handler.close();
                            });

                        // submit the stripe form for completing payment by ajax
                        var options = {
                            beforeSubmit: validate,
                            success     : response_form_submitted,
                            resetForm   : true
                        };

                        // binding the form for ajax submission
                        jQuery('#stripe_form')
                            .submit(function(){
                                jQuery(this)
                                    .ajaxSubmit(options);

                                // prevents normal form submission
                                return false;
                            });
                    });

                function validate(){
                    return true;
                }

                function response_form_submitted(response){
                    show_payment_message();
                }


                // PAYPAL CONFIGURATION AND RENDER
                jQuery(document)
                    .ready(function($){
                    <?php if ($paypal_active_status == 1) { ?>
                        paypal.Button.render({
                                env        : '<?php echo $paypal_mode;?>', // production | sandbox
                                style      : {
                                    label  : 'paypal',
                                    size   : 'responsive',    // small | medium | large | responsive
                                    shape  : 'rect',     // pill | rect
                                    color  : 'blue',     // gold | blue | silver | black
                                    tagline: false
                                },
                                client     : {
                                    sandbox   : '<?php echo $paypal_sandbox_client_id;?>',
                                    production: '<?php echo $paypal_production_client_id;?>'
                                },
                                // Display a "Pay Now" button rather than a "Continue" button
                                commit     : true,
                                // Pass the payment details for your transaction
                                payment    : function(data,
                                                      actions){
                                    return actions.payment.create({
                                        transactions: [
                                            {
                                                amount: {
                                                    total   : total_amount,
                                                    currency: '<?php echo $paypal_currency;?>'
                                                }
                                            }
                                        ]
                                    });
                                },
                                // Event callback after paypal successfull payment
                                onAuthorize: function(data,
                                                      actions){
                                    return actions.payment.execute()
                                        .then(function(response){
                                            // database saving ajax call here
                                            show_payment_message();
                                            alert('payment successfully made!');
                                            // submit the paypal payment form for db saving
                                            jQuery('#paypal-submit')
                                                .click();
                                        });
                                },
                                // Pass a function to be called when the customer cancels the payment
                                onCancel   : function(data){
                                    console.log('The payment was cancelled!');
                                    console.log(data);
                                }


                            },
                            '#button_paypal');
                        <?php } ?>
                    });

                function cash_payment(){
                    // configuration for ajax form submission
                    var options = {
                        beforeSubmit: waiting_response,
                        success     : show_payment_message,
                        resetForm   : true
                    };

                    // binding the form for ajax submission
                    jQuery('.cash-payment')
                        .submit(function(){
                            jQuery(this)
                                .ajaxSubmit(options);

                            // prevents normal form submission
                            return false;
                        });
                }
                function waiting_response(){
                    //jQuery('.chb-booking-payment-box').block({ message: '<p>Just a moment...</p>' });
                }

                function show_payment_message(){
                    //jQuery('.chb-booking-payment-box').unblock();
                    jQuery("#payment_completion_message")
                        .attr("style",
                            "display:block;");
                    jQuery("#payment_processors")
                        .attr("style",
                            "display:none;");

                    step_complete("step4");
                }

                function load_payment(method){
                    if (method == 'cash'){
                        jQuery("#button_cash")
                            .attr("style",
                                "display:block;margin-top:40px;");
                        jQuery("#button_paypal")
                            .attr("style",
                                "display:none;");
                        jQuery("#button_stripe")
                            .attr("style",
                                "display:none;");
                        document.getElementById("notice_payment_method").innerHTML = "<?php echo $txt->txt("If you choose to pay on arrival, the reservation will be placed in pending status"); ?>";
                    }

                    if (method == 'paypal'){
                        jQuery("#button_paypal")
                            .attr("style",
                                "display:block;margin-top:40px;");
                        jQuery("#button_cash")
                            .attr("style",
                                "display:none;");
                        jQuery("#button_stripe")
                            .attr("style",
                                "display:none;");
                        document.getElementById("notice_payment_method").innerHTML = "<?php echo $txt->txt("Paying with PayPal will automatically approve your reservation"); ?>";
                    }

                    if (method == 'stripe'){
                        jQuery("#button_stripe")
                            .attr("style",
                                "display:block;margin-top:40px;");
                        jQuery("#button_cash")
                            .attr("style",
                                "display:none;");
                        jQuery("#button_paypal")
                            .attr("style",
                                "display:none;");
                        document.getElementById("notice_payment_method").innerHTML = "<?php echo $txt->txt("Paying with a credit card will automatically approve your reservation"); ?>";
                    }
                }


                function show_cart_in_payment_page(){
                    // blank the previous data
                    jQuery("#cart-rooms")
                        .html("");

                    // counting the array length
                    var len = selected_rooms.length;

                    // total amount of room pricing
                    var total_price = 0;

                    // total amount of service pricing
                    var total_price_service = calculate_total_service_price();

                    // counting the array length
                    var len = selected_rooms.length;

                    // Selected rooms array elements looping and appending the room items in cart section
                    for (var i = 0; i<len; i++){
                        total_price += selected_rooms[i][3];
                        for (var key in selected_rooms[i]){
                            var check_in = '<?php _e("Check-In") ?>';
                            var check_out = '<?php _e("Check-out") ?>';
                            var quantity = '<?php _e("Quantity") ?>';
                            var price = '<?php _e("Price") ?>';
                            var cart_single_item_html =
                                '<div class="chb-booking-sidebar-cart-single">'+
                                '<p class="room-type">'+selected_rooms[i][1]+'</p>'+
                                '<p class="check-in"><small class="left">Check-In</small><span>'+selected_rooms[i][6]+'</span></p>'+
                                '<p class="check-out"><small class="left">Check-out</small><span>'+selected_rooms[i][7]+'</span></p>'+
                                '<p class="quantity"><small class="left">Quantity</small><span>'+selected_rooms[i][2]+'</span></p>'+
                                '<p class="price"><small class="left">Price</small><span>'+price_with_currency(selected_rooms[i][3])+'</span></p>'+
                                '</div>';
                        }
                        jQuery("#cart-rooms")
                            .append(cart_single_item_html);

                    }
                    // Selected service array element looping and adding to cart section
                    var len = selected_services.length;
                    for (var i = 0; i<len; i++){
                        var sub_total_service = 0;
                        var service_name = selected_services[i][5];
                        var service_price = selected_services[i][4];

                        var cart_service_single_item_html =
                            '<li><span class="name">'+service_name+'</span>';

                        if (selected_services[i][1] == '1'){
                            sub_total_service += parseInt(selected_services[i][4]);
                        }
                        if (selected_services[i][1] == '2'){
                            sub_total_service += (parseInt(selected_services[i][4])*parseInt(selected_services[i][2]));
                            cart_service_single_item_html += '<span class="per-amount">'+selected_services[i][2]+' x '+price_with_currency(service_price)+'/Night</span>';
                        }
                        if (selected_services[i][1] == '3'){
                            sub_total_service += parseInt(selected_services[i][4])*parseInt(selected_services[i][3]);
                            cart_service_single_item_html += '<span class="per-amount">'+selected_services[i][3]+' x '+price_with_currency(service_price)+'/Night</span>';
                        }


                        cart_service_single_item_html += '<span class="total-sigle float-right">'+price_with_currency(sub_total_service)+'</span></li>';

                        jQuery("#cart-services")
                            .append(cart_service_single_item_html);
                    }

                    // adding service price with room price

                    total_price += total_price_service;
                    var vat_total_price = (selected_rooms[0][8]*total_price)/100;
                    total_amount = total_price+vat_total_price;
                    stripe_chargeable_amount = total_amount*100;

                    jQuery("#total_amount_stripe")
                        .val(total_amount);
                    jQuery("#total_amount_paypal")
                        .val(total_amount);
                    jQuery("#total_price")
                        .text(price_with_currency(Math.round(total_price+vat_total_price)));
                }
            </script> <?php
        }

    }
}
