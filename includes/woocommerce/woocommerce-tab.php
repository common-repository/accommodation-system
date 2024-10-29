<?php

if(!class_exists('WooCommerceTab')){

    class WooCommerceTab {

        function __construct(){
            /**
             * Add tab.
             */
            add_action('woocommerce_product_write_panel_tabs', array(&$this, 'add'));

            /**
             * Add content to tab.
             */
            add_action('woocommerce_product_data_panels', array(&$this, 'display'));

            /**
             * Save tab data.
             */
            add_action('woocommerce_process_product_meta', array(&$this, 'set'));

        }



        /**
         * Add accommodation system in product tabs list.
         *
         * return HTML tab button
         */
        function add(){
            global $TIDPLUS;

            echo '<li class="has_tab"><a href="#has_tab_data"><span>'.'Accommodation System'.'</span></a></li>';
        }


        /**
         * Display tab content.
         *
         * return HTML form
         */
        function display(){
            global $post;
            global $TIDPLUS;

            $has_woocommerce_options = array('enable' => get_post_meta($post->ID, 'has_woocommerce_enable', true),
                                             'position' => get_post_meta($post->ID, 'has_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'has_woocommerce_position', true));

            ?>
            <div id="has_tab_data" class="panel woocommerce_options_panel">
                <div class="options_group">
                    <p class="form-field">
                        <?php
                        woocommerce_wp_select(array('id' => 'has_woocommerce_enable',
                                                    'options' => $this->enable(),
                                                    'label' => 'Enable',
                                                    'description' => 'Use Accommodation System for this product'));

                        woocommerce_wp_select(array('id' => 'has_woocommerce_position',
                                                    'options' => array('summary' => 'Summary',
                                                                       'tabs' => 'Tabs',
                                                                       'summary-tabs' => 'Summary & Tabs'),
                                                    'label' => 'Position',
                                                    'description' => 'Choose where the content will be displayed inside your product',
                                                    'value' => $has_woocommerce_options['position']));


                        ?>
                    </p>
                </div>
            </div>
            <?php
        }


        /**
         * Enable accommodation system.
         *
         * return YES or NO options (1/0 database)
         */
        function enable(){
            global $DOPBSP;

            $enable = array();

                $enable[0] = 'NO';
                $enable[1] = 'YES';


            return $enable;
        }

        /**
         * Save options.
         *
         * return true/false
         */
        function set($post_id){

            $has_woocommerce_enable = sanitize_text_field($_POST['has_woocommerce_enable']);
            $has_woocommerce_position = sanitize_text_field($_POST['has_woocommerce_position']);


            update_post_meta($post_id, 'has_woocommerce_enable', esc_attr($has_woocommerce_enable));

            if (!empty($has_woocommerce_position))
                update_post_meta($post_id, 'has_woocommerce_position', esc_attr($has_woocommerce_position));

        }
    }

}