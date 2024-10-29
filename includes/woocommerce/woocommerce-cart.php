<?php

if(!class_exists('HASWooCommerceCart')){

    class HASWooCommerceCart extends Controller {

        function __construct()
        {
            add_action( 'woocommerce_before_calculate_totals', array(&$this, 'add_custom_price'), 10, 1);

            add_action('woocommerce_order_status_changed', array(&$this, 'add_to_order'));

            //woocommerce_checkout_process
        }

        function add_custom_price( $cart_object ) {
            include_once 'woocommerce-product.php';
            $custom_price = '';
            foreach ( $cart_object->cart_contents as $key => $value ) {
                /**
                 * for WooCommerce < 3.0 version
                 *
                 * $value['data']->price = $custom_price;
                 *
                 */

                /**
                 * for WooCommerce > 3.0 version
                 */

                 // $value['data']->set_price($custom_price);

                 //var_dump($value);


            }
        }

        function add_to_order(){
            $controller = new Controller();
            include $controller->plugin_path . 'includes/models/methods-api.php';
            $method = new Methods();
            global $woocommerce;
            $items = $woocommerce->cart->get_cart();
            foreach($items as $content=> $values){
                $booking_details = new stdClass();
                $booking_details->status = 2;
                $booking_details->name = sanitize_text_field($_POST['billing_first_name'].$_POST['billing_last_name']);
                $booking_details->email = sanitize_text_field($_POST['billing_email']);
                $booking_details->phone = sanitize_text_field($_POST['billing_phone']);
                $booking_details->address = sanitize_text_field($_POST['billing_address_1'].' '.$_POST['billing_city'].' '.$_POST['billing_state'].' '.$_POST['billing_country']);

                $data           =       $values['chb_booking_data'];

                $booking_details->room_type = $data ['chb_room_type'];
                $booking_details->room_type_id = $data ['chb_room_type_id'];
                $booking_details->check_in = strtotime($data ['chb_check_in']);
                $booking_details->check_out = strtotime($data ['chb_check_out']);
                $booking_details->quantity = $data ['chb_quantity'];
                $booking_details->price = $data ['chb_price'];
                $booking_details->requester = 'WooCommerce';
                $booking_details->summary = 'none';
                $booking_details->description = 'none';


            }
            $method->has_create_booking_woocommerce($booking_details);

        }

    }

}
