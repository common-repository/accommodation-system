<?php
/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/
if (!class_exists('GuestDetail')){
class GuestDetail extends Controller{

/**
 *
 *  Constructor called when GuestDetail class instance is created.
 *
 */
function __construct(){
    parent::__construct();
}

/**
 *
 * Guest details layout
 *
 *   function: create booking
 *
 */
public static function guest_detail(){
/**
 *
 * Instantiate Controller class for plugin path variables
 *
 * Instantiate Methods class to call methods
 *
 * HTML layout
 *
 */
$controller = new Controller();
include $controller->plugin_path . 'includes/models/methods-api.php';
$method = new Methods();
$vat = $method->has_get_settings('vat_percentage');
include $controller->plugin_path . 'includes/translations/translations.php';
$txt = new Translation;
?>
<div class="chb-booking-wrapper ci-responsive-shortcode">
    <div class="chb-booking-form-main">
        <div class="chb-booking-title">
            <h3><?php echo $txt->txt("Enter your details") ?></h3>
        </div>

        <!-- GUEST DETAIL INFORMATION FORM -->
        <div class="chb-booking-form">
            <div class="has-container">
                <div class="has-row">
                    <div class="has-col-lg-12">
                        <form method="post" action="<?php echo admin_url(); ?>admin-post.php" id="guest_form">
                            <input type="hidden" name="action" value="has">
                            <input type="hidden" name="task" value="create_booking_publicly">
                            <input type="hidden" name="nonce"
                                   value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                            <div class="has-form-row">
                                <div class="has-form-group has-col-md-6">
                                    <input type="text" class="has-form-control" id="name"
                                           placeholder="<?php echo $txt->txt('Your name') . '*'; ?>" name="name">
                                </div>
                                <div class="has-form-group has-col-md-6">
                                    <input type="text" class="has-form-control" id="phone"
                                           placeholder="<?php echo $txt->txt('Phone') . '*'; ?>" name="phone">
                                </div>
                            </div>
                            <div class="has-form-row">
                                <div class="has-form-group has-col-md-6">
                                    <input type="email" class="has-form-control" id="email"
                                           placeholder="<?php echo $txt->txt('Email') . '*'; ?>" name="email">
                                </div>
                                <div class="has-form-group has-col-md-6">
                                    <select name="total_guest" id="guest">
                                        <option value="0"><?php echo $txt->txt("Total guests") . '*' ?></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>
                            </div>
                            <div class="has-form-row">
                                <div class="has-form-group has-col-md-6">
                                                <textarea class="has-form-control" id="address"
                                                          placeholder="<?php echo $txt->txt("Address") ?>"
                                                          name="address"></textarea>
                                </div>
                                <div class="has-form-group has-col-md-6">
                                                <textarea class="has-form-control" id="message"
                                                          placeholder="<?php echo $txt->txt("Message") ?>"
                                                          name="message"></textarea>
                                </div>
                            </div>


                            <h4 class="has-mt-5 mb-4 text-center"><?php echo $txt->txt("Booking Summary") ?></h4>
                            <div class="chb-booking-cart-summary">

                                <div class="chb-booking-cart-lg">
                                    <div class="chb-booking-cart-summary-title">
                                        <div class="has-container">
                                            <div class="has-row">
                                                <div class="has-col-lg-2">
                                                    <p class="title-info"><?php echo $txt->txt("Room type") ?></p>
                                                </div>
                                                <div class="has-col-lg-2">
                                                    <p class="title-info"><?php echo $txt->txt("Room quantity") ?></p>
                                                </div>
                                                <div class="has-col-lg-2">
                                                    <p class="title-info"><?php echo $txt->txt("Check-in") ?></p>
                                                </div>
                                                <div class="has-col-lg-2">
                                                    <p class="title-info"><?php echo $txt->txt("Check-out") ?></p>
                                                </div>
                                                <div class="has-col-lg-2">
                                                    <p class="title-info text-right"><?php echo $txt->txt("Price") ?></p>
                                                </div>
                                                <div class="has-col-lg-2">
                                                    <p class="title-info"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="cart-rooms">

                                    </div>
                                </div>

                                <div class="chb-booking-cart-summary-total">
                                    <div class="has-container">
                                        <div class="has-row">
                                            <div class="col-lg-3 offset-lg-8">
                                                <p class="total-price text-right">
                                                    <span><?php echo $txt->txt("Total") ?>   -   </span>
                                                    <span id="sub_total"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php $services = $method->has_get_services();
                                if(count($services)>0) {
                             ?>
                                  <!-- Additional services starts here -->
                                  <div class="has-row">
                                      <div class="has-col-lg-12">
                                          <h4 class="has-mt-5 mb-4 text-center"><?php echo $txt->txt("Additional Services") ?></h4>
                                          <div class="additional-serices">

                                              <?php
                                              foreach ($services as $row):
                                                  ?>
                                                  <div class="has-form-group">
                                                      <div class="custom-control custom-checkbox">
                                                          <div class="d-inline-block">
                                                              <input type="checkbox" class="custom-control-input"
                                                                     id="additional_services_<?php echo $row['service_id']; ?>">

                                                              <input type="hidden"
                                                                     id="service_type_<?php echo $row['service_id']; ?>"
                                                                     value="<?php echo $row['type']; ?>">
                                                              <input type="hidden"
                                                                     id="service_price_<?php echo $row['service_id']; ?>"
                                                                     value="<?php echo $row['price']; ?>">

                                                              <label class="custom-control-label"
                                                                     for="additional_services_<?php echo $row['service_id']; ?>">
                                                                  <span class="service-name"><?php echo $row['name']; ?></span>
                                                              </label>
                                                          </div>

                                                          <div class="d-inline-block selector">
                                                              <?php if ($row['type'] == '2'): ?>
                                                                  <select class="has-form-control"
                                                                          id="guest_number_<?php echo $row['service_id']; ?>"
                                                                          onchange="multiply_guest(<?php echo $row['service_id']; ?>, '<?php echo $row['name']; ?>')"
                                                                          disabled="disabled">
                                                                      <?php for ($i = 1; $i <= 10; $i++): ?>
                                                                          <option value="<?php echo $i; ?>"><?php echo $i . ' '; ?><?php echo $txt->txt("guest") ?></option>
                                                                      <?php endfor; ?>
                                                                  </select>
                                                              <?php endif; ?>
                                                              <?php if ($row['type'] == '3'): ?>
                                                                  <select class="has-form-control"
                                                                          id="night_number_<?php echo $row['service_id']; ?>"
                                                                          onchange="multiply_night(<?php echo $row['service_id']; ?>, '<?php echo $row['name']; ?>')"
                                                                          disabled="disabled">
                                                                      <?php for ($i = 1; $i <= 10; $i++): ?>
                                                                          <option value="<?php echo $i; ?>"><?php echo $i . ' '; ?><?php echo $txt->txt("night") ?></option>
                                                                      <?php endfor; ?>
                                                                  </select>
                                                              <?php endif; ?>
                                                          </div>
                                                          <div class="d-inline-block">
                                                              <?php if ($row['type'] == '1'): ?>
                                                                  +
                                                                  <b><?php echo $method->has_currency($row['price']); ?></b>
                                                              <?php endif; ?>
                                                              <?php if ($row['type'] == '2'): ?>
                                                                  x (
                                                                  <b><?php echo $method->has_currency($row['price']); ?></b> / <?php echo $txt->txt("guest") ?>)
                                                              <?php endif; ?>
                                                              <?php if ($row['type'] == '3'): ?>
                                                                  x (
                                                                  <b><?php echo $method->has_currency($row['price']); ?></b> / <?php echo $txt->txt("night") ?>)
                                                              <?php endif; ?>

                                                          </div>

                                                          <div class="float-right"
                                                               id="service_individual_view_<?php echo $row['service_id']; ?>"></div>

                                                          <input type="hidden"
                                                                 id="service_individual_total_<?php echo $row['service_id']; ?>"
                                                                 value="">

                                                      </div>
                                                  </div>
                                              <?php
                                              endforeach;
                                              ?>


                                          </div>
                                      </div>
                                  </div>
                                  <?php
                              }
                            if ($vat > 0){
                            ?>
                            <div class="has-row">
                                <div class="has-booking-cart-summary-vat">
                                    <p class="vat"><small
                                            class="left"><?php echo $txt->txt("V.A.T") ?></small><span><?php echo '  +' . $vat . '%'; ?></span>
                                    </p>
                                </div>
                            </div>
                            <?php } ?>
                            <div id="cart-services">
                            </div>
                            <!-- Additional services ends here -->

                            <div class="has-row-final-price">
                                <div class="total-price">
                                    <p><?php echo $txt->txt("Total") . " " ?><span id="total_price"></span><?php echo " " . "|" . " " . "You will be redirected to a payment page."?></p>
                                </div>
                            </div>
                            <div class="has-row-confirm-button">
                                <button class="has-button" type="submit"
                                        id="button_confirm_booking"><?php echo $txt->txt("Confirm your booking"); ?>
                                    <span class="total-price" id="total_price"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">

</style>

<script>
    /**
     *
     * initialize the selected service array - JS
     *
     */
    var selected_services = new Array();
    jQuery(document)
    .ready(function(){

        /**
         *
         * initialize the cart with combination of room details and service details - JS
         *
         */
        show_cart_in_guest_detail_page();

        /**
         *
         * create the service cart along with room cart - JS
         *
         */
        create_service_cart();

        /**
         *
         * configuration for ajax form submission - JS
         *
         */
        var options = {
            beforeSubmit: validate,
            success     : response_form_submitted,
            resetForm   : true
        };

        /**
         *
         * binding the form for ajax submission - JS
         *
         */
        jQuery('#guest_form')
        .submit(function(){
            jQuery(this)
            .ajaxSubmit(options);

            /**
             *
             * prevents normal form submission - JS
             *
             */
            return false;
        });


        /**
         *
         * scroll to top of booking form - JS
         *
         */
        /*jQuery('html, body').animate({
                            scrollTop: jQuery(".chb-booking-steps-wrap").offset().top - 50
                        }, 1000);*/
    });

    function validate(){
        var validation = true;
        if (jQuery('#phone')
        .val() == ''){
            jQuery('#phone')
            .attr("class",
                  "has-form-control is-invalid");
            jQuery('#phone')
            .focus();
            validation = false;
        }
        if (jQuery('#phone')
        .val() != ''){
            jQuery('#phone')
            .attr("class",
                  "has-form-control");
        }
        if (!validateEmail(jQuery('#email')
                           .val())){
            jQuery('#email')
            .attr("class",
                  "has-form-control is-invalid");
            jQuery('#email')
            .focus();
            validation = false;
        }
        if (validateEmail(jQuery('#email')
                          .val())){
            jQuery('#email')
            .attr("class",
                  "has-form-control");
        }
        if (jQuery('#name')
        .val() == ''){
            jQuery('#name')
            .attr("class",
                  "has-form-control is-invalid");
            jQuery('#name')
            .focus();
            validation = false;
        }
        if (jQuery('#name')
        .val() != ''){
            jQuery('#name')
            .attr("class",
                  "has-form-control");
        }


        if (jQuery('#guest')
            .val() == '0'){
            jQuery('#guest')
                .attr("class",
                    "has-form-control is-invalid");
            jQuery('#guest')
                .focus();
            validation = false;
        }
        if (jQuery('#guest')
            .val() != '0'){
            jQuery('#guest')
                .attr("class",
                    "has-form-control");
        }


        if (validation == true){

            /**
             *
             * Disable the button & cursor before starting ajax call - JS
             *
             */
            jQuery("#button_confirm_booking")
            .attr("disabled",
                  "disabled");
            jQuery("#button_confirm_booking")
            .css("cursor",
                 "wait");
            //jQuery('#chb-booking-form').block({ message: '<p>Just a moment...</p>' });
        }

        return validation;
    }

    function validateEmail($email){
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return ($email.length>0 && emailReg.test($email));
    }

    function response_form_submitted(response){
        var booking_id = response;

        /**
         *
         * calling the ajax function for loading confirmation & payment page - JS
         *
         */
        var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
        jQuery.post(
                ajaxurl,
                {
                    'action'    : 'has_shortcode_ajax',
                    'task_name' : 'confirmation-payment',
                    'booking_id': booking_id
                },
                function(response){
                    jQuery('#chb-booking-form')
                    .html(response);

                    /**
                     *
                     * completes the step2 - JS
                     *
                     */
                    step_complete("step3");

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
    }

    /**
     *
     * showing the selected rooms in cart section - JS
     *
     */
    function show_cart_in_guest_detail_page(){
        /**
         *
         * blank the previous data - JS
         *
         */
        jQuery("#cart-rooms")
        .html("");

        /**
         *
         * counting the array length - JS
         *
         */
        var len = selected_rooms.length;

        /**
         *
         * total amount of room pricing - JS
         *
         */
        var total_price = 0;

        /**
         *
         * Selected room array elements looping and appending the room items in cart section - JS
         *
         */
        for (var i = 0; i<len; i++){
            total_price += selected_rooms[i][3];
            for (var key in selected_rooms[i]){

                var cart_single_item_html =
                            '<div class="chb-booking-cart-summary-room">'+
                            '<div class="has-container">'+
                            '<div class="has-row">'+
                            '<div class="has-col-lg-2">'+
                            '<p class="room-type">'+selected_rooms[i][1]+'</p>'+
                            '</div>'+
                            '<div class="has-col-lg-2">'+
                            '<p class="room-quantity">'+selected_rooms[i][2]+'</p>'+
                            '</div>'+
                            '<div class="has-col-lg-2">'+
                            '<p class="check-in">'+selected_rooms[i][6]+'</p>'+
                            '</div>'+
                            '<div class="has-col-lg-2">'+
                            '<p class="check-out">'+selected_rooms[i][7]+'</p>'+
                            '</div>'+
                            '<div class="has-col-lg-2">'+
                            '<p class="price text-right">'+price_with_currency(selected_rooms[i][3])+'</p>'+
                            '</div>'+
                            '<div class="has-col-lg-2">'+
                            '<p class="close" onclick="delete_room_in_guest_page('+i+')"><i class="fa fa-close"></i></p>'+
                            '</div>'+

                            '<input type="hidden" name="room_types[]" value="'+selected_rooms[i][0]+'" />'+
                            '<input type="hidden" name="room_quantities[]" value="'+selected_rooms[i][2]+'" />'+
                            '<input type="hidden" name="checkin_timestamps[]" value="'+selected_rooms[i][4]+'" />'+
                            '<input type="hidden" name="checkout_timestamps[]" value="'+selected_rooms[i][5]+'" />'+
                            '<input type="hidden" name="prices[]" value="'+selected_rooms[i][3]+'" />'+
                            '</div>'+
                            '</div>'+
                            '</div>';
            }
            jQuery("#cart-rooms")
            .append(cart_single_item_html);

        }


        jQuery("#sub_total")
        .text(price_with_currency(total_price));

        /**
         *
         * calculate the services pricing - JS
         *
         */

        var sub_total_service = calculate_total_service_price();
        total_price = total_price+sub_total_service;
        var vat_total_price = (selected_rooms[0][8]*total_price)/100;
        jQuery("#total_price")
        .text(price_with_currency(Math.round(total_price+vat_total_price)));

    }

    function delete_room_in_guest_page(i){
        selected_rooms.splice(i,
                              1);
        show_cart_in_guest_detail_page();
    }

    /**
     *
     * managing additional services - JS
     *
     */
    jQuery(document)
    .ready(function(){

        <?php
        $services = $method->has_get_services();
        foreach($services as $row):
        ?>
        jQuery("#additional_services_<?php echo $row['service_id'];?>")
        .change(function(){

            /**
             *
             * operation when the checkbox is checked - JS
             *
             */
            if (jQuery(this)
            .is(":checked")){
                //var returnVal = confirm("Are you sure?");
                //jQuery(this).attr("checked", returnVal);

                var service_type = jQuery("#service_type_<?php echo $row['service_id'];?>")
                .val();
                var service_price = jQuery("#service_price_<?php echo $row['service_id'];?>")
                .val();

                if (service_type == '1'){
                    jQuery("#service_individual_view_<?php echo $row['service_id'];?>")
                    .html(price_with_currency(service_price));
                    jQuery("#service_individual_total_<?php echo $row['service_id'];?>")
                    .html(service_price);

                    /**
                     *
                     * call the booking service json forming function - JS
                     *
                     */
                    select_service(<?php echo $row['service_id'];?>, "append",
                                                                     "<?php echo $row['name'];?>");
                }
                if (service_type == '2'){
                    /**
                     *
                     * enable the guest number selector first - JS
                     *
                     */
                    jQuery("#guest_number_<?php echo $row['service_id'];?>")
                    .prop('disabled',
                          false);

                    var guest_number = jQuery("#guest_number_<?php echo $row['service_id'];?>")
                    .val();
                    var service_individual_price = guest_number*service_price;
                    jQuery("#service_individual_view_<?php echo $row['service_id'];?>")
                    .html(price_with_currency(service_individual_price));
                    jQuery("#service_individual_total_<?php echo $row['service_id'];?>")
                    .html(service_individual_price);

                    /**
                     *
                     * call the booking service json forming function - JS
                     *
                     */
                    select_service(<?php echo $row['service_id'];?>, "append",
                                                                     "<?php echo $row['name'];?>");
                }
                if (service_type == '3'){
                    /**
                     *
                     * enable the night selector first - JS
                     *
                     */
                    jQuery("#night_number_<?php echo $row['service_id'];?>")
                    .prop('disabled',
                          false);

                    var night_number = jQuery("#night_number_<?php echo $row['service_id'];?>")
                    .val();
                    var service_individual_price = night_number*service_price;
                    jQuery("#service_individual_view_<?php echo $row['service_id'];?>")
                    .html(price_with_currency(service_individual_price));
                    jQuery("#service_individual_total_<?php echo $row['service_id'];?>")
                    .html(service_individual_price);

                    /**
                     *
                     * call the booking service json forming function - JS
                     *
                     */
                    select_service(<?php echo $row['service_id'];?>, "append",
                                                                     "<?php echo $row['name'];?>");
                }

            }

            /**
             *
             * operation when the checkbox is unchecked - JS
             *
             */
            if (!jQuery(this)
            .is(":checked")){
                /**
                 *
                 * disable the guest & night number selector - JS
                 *
                 */
                jQuery("#guest_number_<?php echo $row['service_id'];?>")
                .prop('disabled',
                      'disabled');
                jQuery("#night_number_<?php echo $row['service_id'];?>")
                .prop('disabled',
                      'disabled');

                /**
                 *
                 * remove the html view and hidden input views - JS
                 *
                 */
                jQuery("#service_individual_view_<?php echo $row['service_id'];?>")
                .html("");
                jQuery("#service_individual_total_<?php echo $row['service_id'];?>")
                .html("");
                // call the booking service json forming function
                select_service(<?php echo $row['service_id'];?>, 'remove');
            }
            //jQuery('#textbox1').val(jQuery(this).is(':checked'));
        });
        <?php
        endforeach;
        ?>

    });

    /**
     *
     * multiply guest number with service price - JS
     *
     */
    function multiply_guest(service_id,
                            name){
        var service_price = jQuery("#service_price_"+service_id)
        .val();
        var guest_number = jQuery("#guest_number_"+service_id)
        .val();
        var service_individual_price = guest_number*service_price;
        jQuery("#service_individual_view_"+service_id)
        .html(price_with_currency(service_individual_price));
        jQuery("#service_individual_total_"+service_id)
        .html(service_individual_price);

        /**
         *
         * call the booking service json forming function - JS
         *
         */
        select_service(service_id,
                       'multiply',
                       name);
    }

    /**
     *
     * multiply night number with service price - JS
     *
     */
    function multiply_night(service_id,
                            name){
        var service_price = jQuery("#service_price_"+service_id)
        .val();
        var night_number = jQuery("#night_number_"+service_id)
        .val();
        var service_individual_price = night_number*service_price;
        jQuery("#service_individual_view_"+service_id)
        .html(price_with_currency(service_individual_price));
        jQuery("#service_individual_total_"+service_id)
        .html(service_individual_price);

        /**
         *
         * call the booking service json forming function - JS
         *
         */
        select_service(service_id,
                       'multiply',
                       name);
    }

    /**
     *
     * manipulate the selected services array - JS
     *
     */
    function select_service(service_id,
                            task = 'append',
                            name = ''){

        var type = jQuery("#service_type_"+service_id)
        .val();
        var price = jQuery("#service_price_"+service_id)
        .val();

        if (type == '1'){
            guest_number = 0;
            night_number = 0;
        }
        else if (type == '2'){
            night_number = 0;
            guest_number = jQuery("#guest_number_"+service_id)
            .val();
        }
        else if (type == '3'){
            guest_number = 0;
            night_number = jQuery("#night_number_"+service_id)
            .val();
        }
        var selected_service = new Array(service_id,
                                         type,
                                         guest_number,
                                         night_number,
                                         price,
                                         name);

        /**
         *
         * append to selected rooms array - JS
         *
         */
        if (task == 'append'){
            selected_services.push(selected_service);
        }
        else if (task == 'remove'){
            var len = selected_services.length;
            for (var i = 0; i<len; i++){
                for (var key in selected_services[i]){
                    if (service_id == selected_services[i][0]){
                        selected_services.splice(i,
                                                 1);
                        break;
                    }
                }
            }
        }
        else if (task == 'multiply'){
            /**
             *
             * delete first the old one and append again - JS
             *
             */
            var len = selected_services.length;
            for (var i = 0; i<len; i++){
                for (var key in selected_services[i]){
                    if (service_id == selected_services[i][0]){
                        selected_services.splice(i,
                                                 1);
                        break;
                    }
                }
            }

            selected_services.push(selected_service);
        }


        /**
         *
         * show the update of subtotal_rooms & subtotal_services - JS
         *
         */
        show_cart_in_guest_detail_page();

        /**
         *
         * update cart with hidden values - JS
         *
         */
        create_service_cart();
    }

    function create_service_cart(){
        jQuery("#cart-services")
        .html("");

        /**
         *
         * Selected service array element looping and adding to hidden elements - JS
         *
         */
        var len = selected_services.length;
        for (var i = 0; i<len; i++){
            var cart_service_single_item_html =
                        '<input type="hidden" name="service_ids[]" value="'+selected_services[i][0]+'" />'+
                        '<input type="hidden" name="types[]" value="'+selected_services[i][1]+'" />'+
                        '<input type="hidden" name="guest_numbers[]" value="'+selected_services[i][2]+'" />'+
                        '<input type="hidden" name="night_numbers[]" value="'+selected_services[i][3]+'" />'+
                        '<input type="hidden" name="service_prices[]" value="'+selected_services[i][4]+'" />';

            jQuery("#cart-services")
            .append(cart_service_single_item_html);
        }
    }

    function calculate_total_service_price(){
        var sub_total_service = 0;
        var len = selected_services.length;
        for (var i = 0; i<len; i++){
            if (selected_services[i][1] == '1'){
                sub_total_service += parseInt(selected_services[i][4]);
            }
            if (selected_services[i][1] == '2'){
                sub_total_service += parseInt(selected_services[i][4])*parseInt(selected_services[i][2]);
            }
            if (selected_services[i][1] == '3'){
                sub_total_service += parseInt(selected_services[i][4])*parseInt(selected_services[i][3]);
            }

        }
        return sub_total_service;
    }
</script> <?php
}
}
}
