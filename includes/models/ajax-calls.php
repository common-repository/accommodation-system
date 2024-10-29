<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/
    if (!class_exists('AjaxCalls')){
        class AjaxCalls extends Controller{

            /**
             *
             *  Constructor called when AjaxCalls class instance is created.
             *
             */
            function __construct(){
                parent::__construct();
            }

            protected $page_to_load;

            /**
             *
             *  Method for registering ajax submit hook to the plugin
             *
             *  function: post()
             *
             *            post_frontend()
             *
             */
            public function register(){
                add_action('wp_ajax_has_task',                  array($this, 'post'));
                add_action('wp_ajax_has_shortcode_ajax',        array($this, 'post_frontend'));
                add_action('wp_ajax_nopriv_has_shortcode_ajax', array($this, 'post_frontend'));
            }

            /**
             *
             * Method for sanitizing all the received parameters and assign it to the public variables declared in this class
             *
             * parameter: page_to_load (string)
             *
             */
            public function post(){
                $this->page_to_load = sanitize_text_field($_POST['task_name']);
                switch ($this->page_to_load){
                    /**
                     *
                     * Rooms
                     *
                     * Loading pages for Rooms section
                     *
                     */
                    case 'room':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        Room::room_layout();
                        die();
                    case 'rooms':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        Rooms::rooms_layout();
                        die();
                    case 'room-list':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomList::room_list_layout();
                        die();
                    case 'room-add':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomAdd::room_add_modal();
                        die();
                    case 'room-edit':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomEdit::room_edit_modal();
                        die();
                    case 'room-delete':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomDelete::room_delete_modal();
                        die();
                    case 'room-type':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomType::room_type_layout();
                        die();
                    case 'room-type-add':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomTypeAdd::room_type_add_modal();
                        die();
                    case 'room-type-edit':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomTypeEdit::room_type_edit_modal();
                        die();
                    case 'room-type-delete':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomTypeDelete::room_type_delete_modal();
                        die();
                    case 'room-floor':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomFloor::room_floor_layout();
                        die();
                    case 'room-floor-add':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomFloorAdd::room_floor_add_modal();
                        die();
                    case 'room-floor-edit':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomFloorEdit::room_floor_edit_modal();
                        die();
                    case 'room-floor-delete':
                        require($this->plugin_path . "layouts/backend/rooms/$this->page_to_load.php");
                        RoomFloorDelete::room_floor_delete_modal();
                        die();

                    /**
                     *
                     * Options
                     *
                     * Loading pages for Options section
                     *
                     */

                    case 'options':
                        require($this->plugin_path . "layouts/backend/options/$this->page_to_load.php");
                        Options::options_layout();
                        die();
                    case 'services':
                        require($this->plugin_path . "layouts/backend/options/$this->page_to_load.php");
                        Services::services_layout();
                        die();
                    case 'services-add':
                        require($this->plugin_path . "layouts/backend/options/$this->page_to_load.php");
                        ServicesAdd::services_add_modal();
                        die();
                    case 'services-edit':
                        require($this->plugin_path . "layouts/backend/options/$this->page_to_load.php");
                        ServicesEdit::services_edit();
                        die();
                    case 'services-delete':
                        require($this->plugin_path . "layouts/backend/options/$this->page_to_load.php");
                        ServicesDelete::services_delete_modal();
                        die();
                    case 'amenities':
                        require($this->plugin_path . "layouts/backend/options/$this->page_to_load.php");
                        Amenities::amenities_layout();
                        die();
                    case 'amenities-add':
                        require($this->plugin_path . "layouts/backend/options/$this->page_to_load.php");
                        AmenitiesAdd::amenities_add_modal();
                        die();
                    case 'amenities-edit':
                        require($this->plugin_path . "layouts/backend/options/$this->page_to_load.php");
                        AmenitiesEdit::amenities_edit();
                        die();
                    case 'amenities-delete':
                        require($this->plugin_path . "layouts/backend/options/$this->page_to_load.php");
                        AmenitiesDelete::amenities_delete_modal();
                        die();

                    /**
                     *
                     * Translate
                     *
                     * Loading pages for Translate section
                     *
                     */
                    case 'translate':
                        require($this->plugin_path . "layouts/backend/translate/$this->page_to_load.php");
                        Translate::translate_layout();
                        die();
                    case 'translate-pages':
                        require($this->plugin_path . "layouts/backend/translate/$this->page_to_load.php");
                        TranslateReception::translate_reception_layout();
                        die();
                    case 'translate-rooms':
                        require($this->plugin_path . "layouts/backend/translate/$this->page_to_load.php");
                        TranslateRooms::translate_rooms_layout();
                        die();
                    case 'translate-schedule':
                        require($this->plugin_path . "layouts/backend/translate/$this->page_to_load.php");
                        TranslateSchedule::translate_schedule_layout();
                        die();
                    case 'translate-options':
                        require($this->plugin_path . "layouts/backend/translate/$this->page_to_load.php");
                        TranslateOptions::translate_options_layout();
                        die();
                    case 'translate-wallet':
                        require($this->plugin_path . "layouts/backend/translate/$this->page_to_load.php");
                        TranslateWallet::translate_wallet_layout();
                        die();
                    case 'translate-settings':
                        require($this->plugin_path . "layouts/backend/translate/$this->page_to_load.php");
                        TranslateSettings::translate_settings_layout();
                        die();
                    case 'translate-translations':
                        require($this->plugin_path . "layouts/backend/translate/$this->page_to_load.php");
                        TranslateTranslations::translate_translations_layout();
                        die();
                    case 'translate-sync':
                        require($this->plugin_path . "layouts/backend/translate/$this->page_to_load.php");
                        TranslateSync::translate_sync_layout();
                        die();
                    case 'translate-frontend':
                        require($this->plugin_path . "layouts/backend/translate/$this->page_to_load.php");
                        TranslateFrontend::translate_frontend_layout();
                        die();

                    /**
                     *
                     * Settings
                     *
                     * Loading pages for Settings section
                     *
                     */
                    case 'settings':
                        require($this->plugin_path . "layouts/backend/settings/$this->page_to_load.php");
                        Settings::settings_layout();
                        die();
                    case 'general-settings':
                        require($this->plugin_path . "layouts/backend/settings/$this->page_to_load.php");
                        GeneralSettings::general_settings_layout();
                        die();
                    case 'payment-gateways-settings':
                        require($this->plugin_path . "layouts/backend/settings/$this->page_to_load.php");
                        PaymentGatewaysSettings::payment_gateways_settings_layout();
                        die();
                    case 'style-settings':
                        require($this->plugin_path . "layouts/backend/settings/$this->page_to_load.php");
                        StyleSettings::style_settings_layout();
                        die();

                    /**
                     *
                     * Reception
                     *
                     * Loading pages for Reception section
                     *
                     */

                    case 'reception-summary':
                        require($this->plugin_path . "layouts/backend/reception/$this->page_to_load.php");
                        ReceptionSummary::reception_summary_layout();
                        die();
                    case 'reception-list':
                        require($this->plugin_path . "layouts/backend/reception/$this->page_to_load.php");
                        ReceptionList::reception_list_layout();
                        die();
                    case 'reception-add':
                        require($this->plugin_path . "layouts/backend/reception/$this->page_to_load.php");
                        ReceptionAdd::reception_add_modal();
                        die();
                    case 'reception-add-room-list':
                        require($this->plugin_path . "layouts/backend/reception/$this->page_to_load.php");
                        ReceptionAddRoomList::reception_add_room_list_layout();
                        die();
                    case 'reception-add-room':
                        require($this->plugin_path . "layouts/backend/reception/$this->page_to_load.php");
                        ReceptionAddRoom::reception_add_room_layout();
                        die();
                    case 'reception':
                        require($this->plugin_path . "layouts/backend/reception/$this->page_to_load.php");
                        Reception::reception_layout();
                        die();
                    case 'reception-delete':
                        require($this->plugin_path . "layouts/backend/reception/$this->page_to_load.php");
                        ReceptionDelete::reception_delete_modal();
                        die();
                    case 'room-availability':
                        require($this->plugin_path . "layouts/backend/reception/$this->page_to_load.php");
                        ReceptionRoomAvailability::reception_room_availability_layout();
                        die();
                    case 'reception-payment':
                        require($this->plugin_path . "layouts/backend/reception/$this->page_to_load.php");
                        ReceptionPayment::reception_payment();
                        die();
                    case 'reception-booking-edit':
                        require($this->plugin_path . "layouts/backend/reception/$this->page_to_load.php");
                        ReceptionBookingEdit::reception_booking_edit();
                        die();

                    /**
                     *
                     * Schedule
                     *
                     * Loading pages for Schedule section
                     *
                     */
                    case 'schedule':
                        require($this->plugin_path . "layouts/backend/schedule/$this->page_to_load.php");
                        Schedule::schedule_layout();
                        die();
                    case 'schedule-pricing-manager':
                        require($this->plugin_path . "layouts/backend/schedule/$this->page_to_load.php");
                        SchedulePricingManager::schedule_pricing_manager_layout();
                        die();
                    case 'schedule-add-price':
                        require($this->plugin_path . "layouts/backend/schedule/$this->page_to_load.php");
                        ScheduleAddPrice::schedule_add_price();
                        die();
                    case 'schedule-delete-price':
                        require($this->plugin_path . "layouts/backend/schedule/$this->page_to_load.php");
                        ScheduleDeletePrice::schedule_delete_price();
                        die();

                    /**
                     *
                     * Wallet
                     *
                     * Loading pages for Wallet section
                     *
                     */
                    case 'wallet':
                        require($this->plugin_path . "layouts/backend/wallet/$this->page_to_load.php");
                        Wallet::wallet_layout();
                        die();
                    case 'wallet-stats':
                        require($this->plugin_path . "layouts/backend/wallet/$this->page_to_load.php");
                        WalletStats::wallet_stats_layout();
                        die();

                    /**
                     *
                     * Sync
                     *
                     * Loading pages for Sync section
                     *
                     */
                    case 'sync':
                        require($this->plugin_path . "layouts/backend/sync/$this->page_to_load.php");
                        HASSync::sync_layout();
                        die();
                    case 'sync-platforms':
                        require($this->plugin_path . "layouts/backend/sync/$this->page_to_load.php");
                        SyncPlatforms::sync_platforms_layout();
                        die();
                }

                /**
                 *
                 * Default case
                 *
                 */

                require($this->plugin_path . "templates/admin/$this->page_to_load.php");
                die();
            }

            /**
             *
             * Method for sanitizing all the received parameters and assign it to the public variables declared in this class
             *
             * parameter: page_to_load
             *
             */
            public function post_frontend(){
                $this->page_to_load = sanitize_text_field($_POST['task_name']);
                switch ($this->page_to_load){
                    /**
                     *
                     * Rooms
                     *
                     * Loading pages for Rooms section
                     *
                     */
                    case 'room-list':
                        require($this->plugin_path . "layouts/frontend/$this->page_to_load.php");
                        RoomList::room_list();
                        die();

                    case'guest-detail':
                        require($this->plugin_path . "layouts/frontend/$this->page_to_load.php");
                        GuestDetail::guest_detail();
                        die();

                    case 'confirmation-payment':
                        require($this->plugin_path . "layouts/frontend/$this->page_to_load.php");
                        ConfirmationPayment::confirmation_payment();
                        die();
                }
            }

        }
    }
