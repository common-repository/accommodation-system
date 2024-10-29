<?php
/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/
    if (!class_exists('BookingForm')){
        class BookingForm extends Controller{

            /**
             *
             *  Constructor called when BookingForm class instance is created.
             *
             */
            function __construct(){
                parent::__construct();
            }

            /**
             *
             * Booking form layout - main layout
             *
             *   function: load date-search layout
             *
             */
            public static function booking_form(){
                /**
                 *
                 * Instantiate Controller class for plugin path variables
                 *
                 * Instantiate Methods class to call methods
                 *
                 * HTML layout with the main container
                 *
                 */
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <div class="chb-booking-wrapper ci-responsive-shortcode">
                    <div class="chb-booking-steps-wrap">
                        <div class="has-container">
                            <div class="has-row">
                                <div class="has-col-lg-3 step">
                                    <div class="chb-booking-single-step active" id="step1">
                                        <div class="number">1</div>
                                        <p class="text"><?php echo $txt->txt("Select date"); ?></p>
                                    </div>
                                </div>
                                <div class="has-col-lg-3 step">
                                    <div class="chb-booking-single-step" id="step2">
                                        <div class="number">2</div>
                                        <p class="text"><?php echo $txt->txt("Select room") ?></p>
                                    </div>
                                </div>
                                <div class="has-col-lg-3 step">
                                    <div class="chb-booking-single-step" id="step3">
                                        <div class="number">3</div>
                                        <p class="text"><?php echo $txt->txt("Guest details") ?></p>
                                    </div>
                                </div>
                                <div class="has-col-lg-3 step">
                                    <div class="chb-booking-single-step" id="step4">
                                        <div class="number">4</div>
                                        <p class="text"><?php echo $txt->txt("Payment & confirmation") ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="chb-booking-form">
                        <?php
                            /**
                             *
                             * Instantiate DateSearch class
                             *
                             * call date_search method
                             *
                             */
                            require_once 'date-search.php';
                            $date_search = new DateSearch();
                            $date_search->date_search();
                        ?>
                    </div>
                </div>
                <script>


                    /**
                     *
                     * manage the form step completion - JS
                     *
                     */
                    function step_complete(step_number){
                        if (step_number == "step1"){
                            jQuery("#step1")
                            .attr("class",
                                  "chb-booking-single-step done");
                            jQuery("#step2")
                            .attr("class",
                                  "chb-booking-single-step active");
                        }
                        if (step_number == "step2"){
                            jQuery("#step2")
                            .attr("class",
                                  "chb-booking-single-step done");
                            jQuery("#step3")
                            .attr("class",
                                  "chb-booking-single-step active");
                        }
                        if (step_number == "step3"){
                            jQuery("#step3")
                            .attr("class",
                                  "chb-booking-single-step done");
                            jQuery("#step4")
                            .attr("class",
                                  "chb-booking-single-step active");
                        }
                        if (step_number == "step4"){
                            jQuery("#step4")
                            .attr("class",
                                  "chb-booking-single-step done");
                        }
                    }


                    /**
                     *
                     * room selection from list - JS
                     *
                     */
                    var selected_rooms = new Array();

                    function select_room_type(room_type_id,
                                              room_name,
                                              price,
                                              checkin_timestamp,
                                              checkout_timestamp,
                                              checkin_date,
                                              checkout_date,
                                              vat_value,
                                              vat_price){
                        /**
                         *
                         * show the sidebar cart - JS
                         *
                         */
                        jQuery("#sidebar_cart")
                        .css("display",
                             "block");

                        var room_quantity = jQuery("#room_quantity_"+room_type_id)
                        .val();
                        var total_price = room_quantity*price;
                        var vat_price = (vat_value*total_price/100)+total_price;


                        /**
                         *
                         * generating new selected room array element. validate if it is not already existing - JS
                         *
                         */
                        var selected_room =  [room_type_id,
                                              room_name,
                                              room_quantity,
                                              total_price,
                                              checkin_timestamp,
                                              checkout_timestamp,
                                              checkin_date,
                                              checkout_date,
                                              vat_value,
                                              vat_price];


                        /**
                         *
                         * validate, if the selected room type is already in the room cart list - JS
                         *
                         */
                        var len = selected_rooms.length;
                        for (var i = 0; i<len; i++){
                            for (var key in selected_rooms[i]){
                                if (room_type_id == selected_rooms[i][0]){
                                    return;
                                }
                            }
                        }

                        /**
                         *
                         * scroll to top of booking form - JS
                         *
                         */
                        jQuery('html, body')
                        .animate({
                                     scrollTop: jQuery("#sidebar_cart")
                                     .offset().top-50
                                 },
                                 1000);

                        /**
                         *
                         * append to selected rooms array - JS
                         *
                         */
                        selected_rooms.push(selected_room);

                        /**
                         *
                         * adding the cart room items from generated array - JS
                         *
                         */
                        show_cart_room_items();
                    }

                    /**
                     *
                     * showing the selected rooms in cart section - JS
                     *
                     */
                    function show_cart_room_items(){

                        /**
                         *
                         * blank the previous data - JS
                         *
                         */
                        jQuery(".chb-booking-sidebar-cart-wrap")
                        .html("");

                        /**
                         *
                         * counting the array length - JS
                         *
                         */
                        var len = selected_rooms.length;

                        /**
                         *
                         * looping the array elements and appending the room items in cart section - JS
                         *
                         */
                        var hidden_fields = '';
                        for (var i = 0; i<len; i++){
                            for (var key in selected_rooms[i]){
                                var cart_single_item_html =
                                            '<div class="chb-booking-sidebar-cart-single">'+
                                            '<span class="close fa fa-close" onclick="delete_room('+i+')"></span>'+
                                            '<p class="room-type">'+selected_rooms[i][1]+'</p>'+
                                            '<p class="check-in"><span class="left"><?php echo $txt->txt("Check-in") ?></span>    <span>'+selected_rooms[i][6]+'</span></p>'+
                                            '<p class="check-out"><span class="left"><?php echo $txt->txt("Check-out") ?></span>    <span>'+selected_rooms[i][7]+'</span></p>'+
                                            '<p class="quantity"><span class="left"><?php echo $txt->txt("Quantity") ?></span>    <span>'+selected_rooms[i][2]+'</span></p>'+
                                            '<p class="price"><span class="left"><?php echo $txt->txt("Price") ?></span>    <span>'+price_with_currency(selected_rooms[i][3])+'</span></p>'+
                                            '</div>';

                                hidden_fields = '<input type="hidden" name="chb_room_type" value="'+selected_rooms[i][1]+'" />' +
                                                '<input type="hidden" name="chb_check_in" value="'+selected_rooms[i][6]+'" />' +
                                                '<input type="hidden" name="chb_check_out" value="'+selected_rooms[i][7]+'" />' +
                                                '<input type="hidden" name="chb_quantity" value="'+selected_rooms[i][2]+'" />' +
                                                '<input type="hidden" name="chb_room_type_id" value="'+selected_rooms[i][0]+'" />' +
                                                '<input type="hidden" name="chb_price" value="'+selected_rooms[i][3]+'" />';
                            }
                            jQuery(".chb-booking-sidebar-cart-wrap")
                            .append(cart_single_item_html);

                            jQuery("form.cart").append(hidden_fields);
                        }   
                    }

                    function delete_room(i){
                        selected_rooms.splice(i,
                                              1);
                        show_cart_room_items();
                    }

                    function price_with_currency(price){
                        var price_with_currency = "";
                        var currency_location = "<?php echo $method->has_get_settings('currency_location');?>";
                        var currency_symbol = "<?php echo $method->has_get_currency_symbol();?>";
                        if (currency_location == "right"){
                            price_with_currency = price+' '+currency_symbol;
                        }
                        else if (currency_location == 'left'){
                            price_with_currency = currency_symbol+price;
                        }
                        return price_with_currency;
                    }

                </script>  <?php

            }

        }
    }
