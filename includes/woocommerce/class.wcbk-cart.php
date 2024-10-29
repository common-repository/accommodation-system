<?php

if ( !class_exists( 'WCBK_Cart' ) ) {

	/**
	 * handle add-to-cart processes for Booking products
     *
     * @author Nam Loc Vo <namloc254@gmail.com>
	 */
	class WCBK_Cart
	{

		/** @var WCBK_Cart */
        private static $_instance;

        /**
         * Singleton implementation
         *
         * @return WCBK_Cart
         */
        public static function get_instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }
		
		public function __construct() {
			add_filter( 'woocommerce_add_cart_item_data', array( $this, 'woocommerce_add_cart_item_data' ), 10, 2 );
			add_filter( 'woocommerce_get_cart_item_from_session', array( $this, 'woocommerce_get_cart_item_from_session' ), 99, 3 );
			add_filter( 'woocommerce_add_cart_item', array( $this, 'woocommerce_add_cart_item' ), 10, 2 );
			add_filter( 'woocommerce_get_item_data', array( $this, 'woocommerce_get_item_data' ), 10, 2 );
			add_filter( 'woocommerce_get_item_data', array( $this, 'woocommerce_get_item_data' ), 10, 2 );
			// add_action( 'woocommerce_before_calculate_totals', array( $this, 'woocommerce_recalculate_totals' ), 99999 );
		}

		public function woocommerce_add_cart_item_data($cart_item_data, $product_id) {
			$has_woocommerce_options = array('enable' => get_post_meta($product_id, 'has_woocommerce_enable', true),
                                             'position' => get_post_meta($product_id, 'has_woocommerce_position', true));

			// Check if this is booking product
			if ($has_woocommerce_options['enable'] != ''
                && $has_woocommerce_options['enable'] != 0
                && ($has_woocommerce_options['position'] == 'tabs'
                    || $has_woocommerce_options['position'] == 'summary-tabs')) {

				if( !isset( $cart_item_data[ 'chb_booking_data' ] ) ) {
	                // get the request from cart_item_data; if it's not set, get it by $_REQUEST
	                $request      = !empty( $cart_item_data[ 'chb_booking_request' ] ) ? $cart_item_data[ 'chb_booking_request' ] : false;
	                $booking_data = self::get_booking_data_from_request( $request );

	                if ( !isset( $booking_data[ '_added-to-cart-timestamp' ] ) ) {
	                    /**
	                     * add the timestamp to allow adding to cart more booking products with the same configuration
	                     *
	                     * @since 1.0.10
	                     */
	                    $booking_data[ '_added-to-cart-timestamp' ] = time();
	                }

	                $cart_item_data[ 'chb_booking_data' ] = $booking_data;
	            }

            }

            return $cart_item_data;
		}

		/**
         * get booking data from Request Form
         *
         * @param array $request
         * @return array
         */
        public static function get_booking_data_from_request( $request = array() ) {
            $request     = empty( $request ) ? $_REQUEST : $request;

            $booking_data = [];
            $booking_data['chb_room_type'] = isset($request['chb_room_type']) ? $request['chb_room_type'] : '';
		    $booking_data['chb_check_in'] = isset($request['chb_check_in']) ? $request['chb_check_in'] : '';
		    $booking_data['chb_check_out'] = isset($request['chb_check_out']) ? $request['chb_check_out'] : '';
		    $booking_data['chb_quantity'] = isset($request['chb_quantity']) ? $request['chb_quantity'] : '';
            $booking_data['chb_room_type_id'] = isset($request['chb_room_type_id']) ? $request['chb_room_type_id'] : '';
		    $booking_data['chb_price'] = isset($request['chb_price']) ? $request['chb_price'] : '';

            return $booking_data;
        }

        /**
         * Set correct price for Booking
         *
         * @param $session_data
         * @param $cart_item
         * @param $cart_item_key
         * @return array
         */
        public function woocommerce_get_cart_item_from_session( $session_data, $cart_item, $cart_item_key ) {
            $product_id = isset( $cart_item[ 'product_id' ] ) ? $cart_item[ 'product_id' ] : 0;

            $has_woocommerce_options = array('enable' => get_post_meta($product_id, 'has_woocommerce_enable', true),
                                             'position' => get_post_meta($product_id, 'has_woocommerce_position', true));

            if ($has_woocommerce_options['enable'] != ''
                && $has_woocommerce_options['enable'] != 0
                && ($has_woocommerce_options['position'] == 'tabs'
                    || $has_woocommerce_options['position'] == 'summary-tabs')) {
                /** @var WC_Product_Booking $product */
                $product      = $session_data[ 'data' ];
                $booking_data = $session_data[ 'chb_booking_data' ];

                $price = isset($booking_data['chb_price']) ? $booking_data['chb_price'] : 0;
                $product->set_price( $price );
                $session_data[ 'data' ] = $product;
            }

            return $session_data;
        }

        /**
         * Set correct price for Booking on add-to-cart item
         *
         * @param $cart_item_data
         * @param $cart_item_key
         * @return mixed
         */
        public function woocommerce_add_cart_item( $cart_item_data, $cart_item_key ) {
            $product_id = isset( $cart_item_data[ 'product_id' ] ) ? $cart_item_data[ 'product_id' ] : 0;
            $has_woocommerce_options = array('enable' => get_post_meta($product_id, 'has_woocommerce_enable', true),
                                             'position' => get_post_meta($product_id, 'has_woocommerce_position', true));

			// Check if this is booking product
			if ($has_woocommerce_options['enable'] != ''
                && $has_woocommerce_options['enable'] != 0
                && ($has_woocommerce_options['position'] == 'tabs'
                    || $has_woocommerce_options['position'] == 'summary-tabs')) {

                /** @var WC_Product_Booking $product */
                $product      = $cart_item_data[ 'data' ];
                $booking_data = $cart_item_data[ 'chb_booking_data' ];

                $price = isset($booking_data['chb_price']) ? $booking_data['chb_price'] : 0;

                $product->set_price( $price );

                $cart_item_data[ 'data' ] = $product;

            }

            return $cart_item_data;
        }

        /**
         * filter item data
         *
         * @param $item_data
         * @param $cart_item
         * @return array
         */
        public function woocommerce_get_item_data( $item_data, $cart_item ) {
            $product_id = isset( $cart_item[ 'product_id' ] ) ? $cart_item[ 'product_id' ] : 0;
            $has_woocommerce_options = array('enable' => get_post_meta($product_id, 'has_woocommerce_enable', true),
                                             'position' => get_post_meta($product_id, 'has_woocommerce_position', true));

            if ($has_woocommerce_options['enable'] != ''
                && $has_woocommerce_options['enable'] != 0
                && ($has_woocommerce_options['position'] == 'tabs'
                    || $has_woocommerce_options['position'] == 'summary-tabs')) {

                /**  @var WC_Product_Booking $product */
                $product = wc_get_product( $product_id );

                $booking_data = $cart_item[ 'chb_booking_data' ];

                $booking_item_data = array(
                	'chb_room_type'     => array(
                        'key'     => 'Room Type',
                        'value'   => $booking_data['chb_room_type'],
                        'display' => $booking_data['chb_room_type']
                    ),
                    'chb_check_in'     => array(
                        'key'     => 'Check In',
                        'value'   => $booking_data['chb_check_in'],
                        'display' => $booking_data['chb_check_in']
                    ),
                    'chb_check_out'       => array(
                        'key'     => 'Check Out',
                        'value'   => $booking_data['chb_check_out'],
                        'display' => $booking_data['chb_check_out']
                    ),
                    'chb_quantity' => array(
                        'key'     => 'Quantity',
                        'value'   => $booking_data['chb_quantity'],
                        'display' => $booking_data['chb_quantity']
                    )
                );

                $item_data = array_merge( $item_data, $booking_item_data );
            }

            return $item_data;
        }

        public function woocommerce_recalculate_totals($cart_object) {
        	$cart_items = $cart_object->cart_contents;
 
			if ( ! empty( $cart_items ) ) {
				
				foreach ( $cart_items as $cart_item_data ) {
					if( ! isset( $cart_item_data[ 'chb_booking_data' ] ) )
						continue;

					$product = $cart_item_data[ 'data' ];
					$price   = isset($booking_data['chb_price']) ? $booking_data['chb_price'] : 0;

                	$product->set_price( $price );

                	file_put_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'test_'. strtotime(date('Y-m-d')) .'.txt', date("Y-m-d H:i:s") . "\r\n" . print_R($cart_item_data, true) . "\r\n\r\n", FILE_APPEND);
				}
			}
        }
	}

	WCBK_Cart::get_instance();

}