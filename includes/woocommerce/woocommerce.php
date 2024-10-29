<?php

if(!class_exists('HASWooCommerce')){

    class HASWooCommerce extends Controller {

        function __construct()
        {
            self::initFrontEndAJAX();
        }

        public static function register(){
            $controller = new Controller();
            include $controller->plugin_path . 'includes/woocommerce/woocommerce-tab.php';
            include $controller->plugin_path . 'includes/woocommerce/woocommerce-product.php';
            include $controller->plugin_path . 'includes/woocommerce/woocommerce-category.php';
            include $controller->plugin_path . 'includes/woocommerce/woocommerce-cart.php';
            $woocommerce_tab = new WooCommerceTab();
            $woocommerce_product = new WooCommerceProduct();
            $woocommerce_category = new WooCommerceCatogory();
            $woocommerce_cart = new HASWooCommerceCart();

        }

        function initFrontEndAJAX(){
            /*
             * WooCommerce front end AJAX requests.
             */
            add_action('wp_ajax_has_woocommerce_add_to_cart', array(&$this, 'add'));
            add_action('wp_ajax_nopriv_has_woocommerce_add_to_cart', array(&$this, 'add'));
        }

    }

}
