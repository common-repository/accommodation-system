<?php

if(!class_exists('WooCommerceProduct')){

    class WooCommerceProduct{

        function __construct(){
            /**
             * Add ticket in product summary.
             */
            add_filter('woocommerce_single_product_summary', array(&$this, 'summary'), 25);

            /**
             * Add ticket in product tab.
             */
            add_filter('woocommerce_product_tabs', array(&$this, 'tab'));
        }

        function summary(){
            global $post;
            $has_woocommerce_options = array('enable' => get_post_meta($post->ID, 'has_woocommerce_enable', true),
                                             'position' => get_post_meta($post->ID, 'has_woocommerce_position', true));


            if ($has_woocommerce_options['enable'] != ''
                && $has_woocommerce_options['enable'] != 0){
                /**
                 * Remove 'add to cart' button and quantity from product page.
                 */
    //            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

                /**
                 * Add the accommodation system.
                 */
                if ($has_woocommerce_options['position'] == 'summary'){
                    echo do_shortcode('[hotel_accommodation_system]');
                }

                /**
                 * Add only sidebar.
                 */
                if ($has_woocommerce_options['position'] == 'summary-tabs'){
                    echo '';
                }
            }
        }



            /**
             * Add ticket in product tab section.
             *
             * @return $tab object
             */
        function tab(){
            global $post;

            $tab = array();

            $has_woocommerce_options = array('enable' => get_post_meta($post->ID, 'has_woocommerce_enable', true),
                                             'position' => get_post_meta($post->ID, 'has_woocommerce_position', true));

            if ($has_woocommerce_options['enable'] != ''
                && $has_woocommerce_options['enable'] != 0
                && ($has_woocommerce_options['position'] == 'tabs'
                    || $has_woocommerce_options['position'] == 'summary-tabs')){
                /**
                 * Remove 'add to cart' button and quantity from product page.
                 */
         //       remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );


                $tab['accommodation-system'] = array('title' => 'Make a reservation',
                     'priority' => 1,
                     'callback' => array($this, 'tabContent'));
                return $tab;
            }
        }

        /**
         * Add ticket in product tab section.
         *
         * @return [ticket] shortcode
         */
        function tabContent(){
            global $post;

            $has_woocommerce_options = array('enable' => get_post_meta($post->ID, 'has_woocommerce_enable', true),
                                             'position' => get_post_meta($post->ID, 'has_woocommerce_position', true));

            echo do_shortcode('[hotel_accommodation_system]');
            ?>





            <script>
                jQuery('#button_confirm_room').hide();
                jQuery('.quantity').hide();
                jQuery('.cart').appendTo('#sidebar_cart');

            </script>
<?php
        }




    }

}