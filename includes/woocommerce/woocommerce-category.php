<?php

if(!class_exists('WooCommerceCatogory')){

    class WooCommerceCatogory{

        function __construct(){
            /**
             * Remove/add buttons.
             */
            add_action('init', array(&$this, 'deleteButtons'));
        }

        /**
         * Delete products buttons in categories pages.
         */
        function deleteButtons(){
            /**
             * Remove all buttons.
             */
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

            /**
             * Reinitialize products buttons.
             */
            add_action('woocommerce_after_shop_loop_item', array(&$this, 'displayButtons'), 11);


        }

        /**
         * Display products buttons in categories pages. Add "View availability" for the ones that contain a calendar.
         *
         * return button HTML
         */
        function displayButtons()
        {
            global $post;
            global $product;

            $has_woocommerce_options = array('enable' => get_post_meta($post->ID, 'has_woocommerce_enable', true),
                                             'position' => get_post_meta($post->ID, 'has_woocommerce_position', true) == '' ? 'summary' : get_post_meta($post->ID, 'has_woocommerce_position', true),
                                             'add_to_cart' => get_post_meta($post->ID, 'has_woocommerce_add_to_cart', true) == '' ? 'false' : get_post_meta($post->ID, 'has_woocommerce_add_to_cart', true));


            if ($has_woocommerce_options['enable'] == ''
                || $has_woocommerce_options['enable'] == 0) {
                /**
                 * Display default buttons.
                 */
                echo apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
                    esc_url($product->add_to_cart_url()),
                    esc_attr($product->get_id()),
                    esc_attr($product->get_sku()),
                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                    esc_attr($product->get_type()),
                    esc_html($product->add_to_cart_text())), $product);
            } else {
                /**
                 * Display "Check availability" buttons for the products that contain the accommodation system.
                 */
                echo apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button product_type_%s">%s</a>',
                    esc_url($product->get_permalink()),
                    esc_attr($product->get_id()),
                    esc_attr($product->get_sku()),
                    esc_attr($product->get_type()),
                    'Check availability'));

            }
        }
    }

}
