<?php
/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/
    if (!class_exists('DateSearch')){
        class DateSearch extends BookingForm{

            /**
             *
             *  Constructor called when DateSearch class instance is created.
             *
             */
            function __construct(){
                parent::__construct();
            }

            /**
             *
             * Date search layout
             *
             *   function: load check-in / check-out layout
             *
             */
            public static function date_search(){
                /**
                 *
                 * Instantiate Controller class for plugin path variables
                 *
                 * HTML layout
                 *
                 */
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;
                ?>
                <div class="chb-booking-search-form">
                    <div class="chb-booking-search-field">
                        <div class="has-container">

                            <div class="has-row">
                                <div class="has-col-lg-3">
                                    <div class="has-form-group">
                                        <label for=""><?php echo $txt->txt("Check-in") ?></label>
                                        <input type="hidden" class="has-form-control datepicker" id="check-in-date">
                                        <input type="hidden" class="has-form-control datepicker" id="check-in-alt-date">
                                        <div class="search-check-in" id="check-in-trigger">
                                            <!-- <p><span>Feb</span>25</p> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="has-col-lg-3">
                                    <div class="has-form-group">
                                        <label for=""><?php echo $txt->txt("Check-out") ?></label>
                                        <input type="hidden" class="has-form-control datepicker" id="check-out-date">
                                        <input type="hidden" class="has-form-control datepicker" id="check-out-alt-date">
                                        <div class="search-check-out" id="check-out-trigger">
                                            <!-- <p><span>Feb</span>25</p> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="has-col-lg-3">
                                    <div class="has-form-group">
                                        <!--
                                            <label for=""><?php echo $txt->txt("Guests") ?></label>
                                            <input type="hidden" class="has-form-control datepicker" id="chb_guest_number"
                                                   value="1">
                                            <div class="search-guests clearfix">
                                                <p>
                                                    <span class="pull-left minus chb-guest-minus">-</span>
                                                    <span class="d-inline-block chb-guest-output-number">1</span>
                                                    <span class="pull-right plus chb-guest-plus">+</span>
                                                </p>
                                            </div>
                                        -->
                                    </div>
                                </div>
                                <div class="has-col-lg-3">
                                    <div class="has-form-group">
                                        <button type="submit" class="has-button" onclick="load_room_list()"
                                                id="button_date_search">
                                            <span><?php echo $txt->txt("Search Rooms") ?></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chb-booking-room-list-sidebar-cart">
                    <div class="has-row-rooms">
                        <div class="has-col-lg-9 ch-sticky-content" id="room_list_holder">

                        </div>
                        <div class="has-col-lg-3 ch-sticky-sidebar-cart">
                            <div class="theiaStickySidebar">
                                <div class="chb-booking-sidebar-cart text-center" id="sidebar_cart"
                                     style="display:none; width: inherit">
                                    <h4 class="chb-booking-sidebar-cart-title"><?php echo $txt->txt("Selected Room(s)") ?></h4>
                                    <div class="chb-booking-sidebar-cart-wrap">


                                    </div>
                                    <div class="has-row-confirm-button">
                                        <button type="button" class="has-button" onclick="confirm_rooms()"
                                                id="button_confirm_room"><?php echo $txt->txt("Confirm Rooms") ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                    jQuery(document)
                    .ready(function(){

                        /**
                         *
                         * check-in datepicker - JS
                         *
                         */
                        jQuery("#check-in-date")
                        .datepicker({
                                        minDate   : new Date(),
                                        dateFormat: "dd M yy",
                                        altField  : "#check-in-alt-date",
                                        altFormat : "<p><span>M</span>d</p>",
                                        onClose   : function(){
                                            var dateText = jQuery.datepicker.formatDate("<p><span>M</span>d</p>",
                                                                                        jQuery(this)
                                                                                        .datepicker("getDate"));
                                            jQuery('#check-in-trigger')
                                            .html(dateText);

                                            var date2 = jQuery('#check-in-date')
                                            .datepicker('getDate');
                                            date2.setDate(date2.getDate()+1);
                                            jQuery('#check-out-date')
                                            .datepicker('option',
                                                        'minDate',
                                                        date2)
                                            .datepicker("setDate",
                                                        date2);

                                            var dateText2 = jQuery.datepicker.formatDate("<p><span>M</span>d</p>",
                                                                                         date2);
                                            jQuery('#check-out-trigger')
                                            .html(dateText2);

                                            jQuery("#check-out-date")
                                            .datepicker("show");
                                        }
                                    })
                        .datepicker("setDate",
                                    new Date());

                        var one_day_ahead = new Date();
                        one_day_ahead.setDate(one_day_ahead.getDate()+1);

                        /**
                         *
                         * check-out datepicker - JS
                         *
                         */
                        jQuery("#check-out-date")
                        .datepicker({
                                        minDate   : one_day_ahead,
                                        dateFormat: "dd M yy",
                                        altField  : "#check-out-alt-date",
                                        altFormat : "<p><span>M</span>d</p>",
                                        onClose   : function(){
                                            var dateText = jQuery.datepicker.formatDate("<p><span>M</span>d</p>",
                                                                                        jQuery(this)
                                                                                        .datepicker("getDate"));
                                            jQuery('#check-out-trigger')
                                            .html(dateText);
                                        }
                                    })
                        .datepicker("setDate",
                                    one_day_ahead);

                        /**
                         *
                         * default date output - JS
                         *
                         */
                        var checkInFront = jQuery("#check-in-alt-date")
                        .val();
                        var checkOutFront = jQuery("#check-out-alt-date")
                        .val();
                        jQuery('#check-in-trigger')
                        .html(checkInFront);
                        jQuery('#check-out-trigger')
                        .html(checkOutFront);

                        /**
                         *
                         * div click datepicker show - JS
                         *
                         */
                        jQuery('#check-in-trigger')
                        .click(function(){
                            jQuery("#check-in-date")
                            .datepicker("show");
                        });
                        jQuery('#check-out-trigger')
                        .click(function(){
                            jQuery("#check-out-date")
                            .datepicker("show");
                        });

                        /**
                         *
                         * guest number plus - JS
                         *
                         */
                        jQuery(".chb-guest-plus")
                        .click(function(){
                            var value = jQuery(".chb-guest-output-number")
                            .text();

                            if (value<10){
                                value++;
                                jQuery(".chb-guest-output-number")
                                .text(value);
                                jQuery("#chb_guest_number")
                                .val(value);
                            }
                        });
                        /**
                         *
                         * guest number minus - JS
                         *
                         */
                        jQuery(".chb-guest-minus")
                        .click(function(){
                            var value = jQuery(".chb-guest-output-number")
                            .text();

                            if (value>1){
                                value--;
                                jQuery(".chb-guest-output-number")
                                .text(value);
                                jQuery("#chb_guest_number")
                                .val(value);
                            }
                        });

                        /**
                         *
                         * sticky sidebar - JS
                         *
                         */
                        jQuery('.ch-sticky-content, .ch-sticky-sidebar-cart')
                        .theiaStickySidebar({
                                                /**
                                                 * Settings
                                                 *
                                                 * additionalMarginTop: 30 - JS
                                                 *
                                                 * removed
                                                 *
                                                 */
                                            });

                    });

                    /**
                     *
                     * room list searching and loading function - JS
                     *
                     */
                    function load_room_list(){
                        /**
                         *
                         * Disable the button & cursor before starting ajax call - JS
                         *
                         */
                        jQuery("#button_date_search")
                        .attr("disabled",
                              "disabled");
                        jQuery("#button_date_search")
                        .css("cursor",
                             "wait");

                        var checkin_date = jQuery("#check-in-date")
                        .val();
                        var checkout_date = jQuery("#check-out-date")
                        .val();
                        // var guest_number    =    jQuery("#chb_guest_number").val();

                        /**
                         *
                         * calling the ajax function for loading room list by search - JS
                         *
                         */
                        var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
                        jQuery.post(
                                ajaxurl,
                                {
                                    'action'   : 'has_shortcode_ajax',
                                    'task_name': 'room-list',
                                    'param1'   : checkin_date,
                                    'param2'   : checkout_date,
                                    'param3'   : true
                                },
                                function(response){
                                    jQuery('#room_list_holder')
                                    .html(response);

                                    /**
                                     *
                                     * room quantity select - JS
                                     *
                                     */
/*                                    jQuery(".select_room_quantity")
                                    .selectmenu();*/

                                    /**
                                     *
                                     * scroll to top of booking form - JS
                                     *
                                     */
                                    jQuery('html, body')
                                    .animate({
                                                 scrollTop: jQuery(".chb-booking-room-list-sidebar-cart")
                                                 .offset().top-50
                                             },
                                             1000);

                                    /**
                                     *
                                     * completes the step1 - JS
                                     *
                                     */
                                    step_complete("step1");

                                    /**
                                     *
                                     * Enable the button after completing ajax call - JS
                                     *
                                     */
                                    jQuery("#button_date_search")
                                    .removeAttr("disabled");
                                    jQuery("#button_date_search")
                                    .css("cursor",
                                         "pointer");
                                }
                        );

                    }

                    /**
                     *
                     * selected room list confirming function - JS
                     *
                     */
                    function confirm_rooms(){

                        /**
                         *
                         * validate if at least a single room is selected - JS
                         *
                         */
                        var len = selected_rooms.length;
                        if (len == 0){
                            return;
                        }

                        /**
                         *
                         * Disable the button & cursor before starting ajax call - JS
                         *
                         */
                        jQuery("#button_confirm_room")
                        .attr("disabled",
                              "disabled");
                        jQuery("#button_confirm_room")
                        .css("cursor",
                             "wait");
                        //jQuery('#chb-booking-form').block({ message: '<p>Just a moment...</p>' });

                        /**
                         *
                         * calling the ajax function for loading room list by search - JS
                         *
                         */
                        var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
                        jQuery.post(
                                ajaxurl,
                                {
                                    'action'   : 'has_shortcode_ajax',
                                    'task_name': 'guest-detail'
                                },
                                function(response){
                                    jQuery('#chb-booking-form')
                                    .html(response);

                                    /**
                                     *
                                     * completes the step2 - JS
                                     *
                                     */
                                    step_complete("step2");

                                    /**
                                     *
                                     * Enable the button after completing ajax call - JS
                                     *
                                     */
                                    jQuery("#button_confirm_room")
                                    .removeAttr("disabled");
                                    jQuery("#button_confirm_room")
                                    .css("cursor",
                                         "pointer");
                                    //jQuery('#chb-booking-form').unblock();
                                }
                        );

                        /**
                         *
                         * scroll to top of booking form - JS
                         *
                         */
                        jQuery('html, body')
                        .animate({
                                     scrollTop: jQuery(".chb-booking-steps-wrap")
                                     .offset().top-50
                                 },
                                 1000);
                    };
                </script>
                <?php
            }

        }
    }


