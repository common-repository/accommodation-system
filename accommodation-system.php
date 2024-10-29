<?php
/**
 * @package  AccommodationSystem
 */
/*
Plugin Name: Accommodation System
Version: 1.0.1
Plugin URI:
Description: This WordPress plugin will allow you to create a reservation <b>management</b> system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.
Author: PHP Crafts
Author URI:
*/


/**
 *
 * Cannot access this file directly |
 *
 */
defined('ABSPATH') or die('Access not allowed!');

/**
 *
 * functions: plugin_menu() from main file ->  accommodation-system.php returns the plugin main menu and submenu
 *
 *            try-catch verify each plugin file and returns the missing_files() function
 *
 *            missing_files() - returns the missing files notice
 *
 */

function has_plugin_menu()
{
    /**
     *
     * variables: $icon -> instantiate Controller class to use the icons URL;
     *
     *            $icons -> array to store the name and the icon for menu and submenu;
     *
     * functions: add_menu_page() add main menu to the plugin
     *
     *            add_submenu_page() add submenu pages to the plugin
     *
     */
    $icon = new Controller;
    $icons = array();
    $icons['main']      = $icon->plugin_url . 'assets/css/backend/icons/has_logo.png';
    $icons['Reception'] = '<div><img src="' . $icon->plugin_url . 'assets/css/backend/icons/submenu-reception.png' . '" alt=""> | Reception</div>';
    $icons['Rooms']     = '<div><img src="' . $icon->plugin_url . 'assets/css/backend/icons/submenu-rooms.png' . '" alt=""> | Rooms</div>';
    $icons['Schedule']  = '<div><img src="' . $icon->plugin_url . 'assets/css/backend/icons/submenu-schedule.png' . '" alt=""> | Schedule</div>';
    $icons['Options']   = '<div><img src="' . $icon->plugin_url . 'assets/css/backend/icons/submenu-options.png' . '" alt=""> | Options</div>';
    $icons['Wallet']    = '<div><img src="' . $icon->plugin_url . 'assets/css/backend/icons/submenu-wallet.png' . '" alt=""> | Wallet</div>';
    $icons['Settings']  = '<div><img src="' . $icon->plugin_url . 'assets/css/backend/icons/submenu-settings.png' . '" alt=""> | Settings</div>';
    $icons['Translate'] = '<div><img src="' . $icon->plugin_url . 'assets/css/backend/icons/submenu-translate.png' . '" alt=""> | Translate</div>';

    add_menu_page('Has', 'Accommodation System', 'manage_options', 'hotel_reception', array('Reception', 'main'), $icons['main'], 100);
    /**
     *
     *   Classic WP submenu is disabled and replaced with Ajax header menu
     *
     *      add_submenu_page('hotel_reception', 'Reception', $icons['Reception'], 'manage_options', 'hotel_reception', array('Reception','reception_layout'));
            add_submenu_page('hotel_reception', 'Rooms',     $icons['Rooms'],     'manage_options', 'hotel_rooms',     array('Rooms','rooms_layout'));
            add_submenu_page('hotel_reception', 'Schedule',  $icons['Schedule'],  'manage_options', 'hotel_schedule',  array ('Schedule', 'schedule_layout'));
            add_submenu_page('hotel_reception', 'Options',   $icons['Options'],   'manage_options', 'hotel_options',   array ('Options', 'options_layout'));
            add_submenu_page('hotel_reception', 'Wallet',    $icons['Wallet'],    'manage_options', 'hotel_wallet',    array ('Wallet', 'wallet_layout'));
            add_submenu_page('hotel_reception', 'Settings',  $icons['Settings'],  'manage_options', 'hotel_settings',  array ('Settings', 'settings_layout'));
            add_submenu_page('hotel_reception', 'Translate', $icons['Translate'], 'manage_options', 'hotel_translate', array ('Translate', 'translate_layout'));
    */
}


/**
 *
 * WP hook - hide all admin notifications;
 *
 * function: hide_admin_notices() from same file
 *
 */
function has_hide_admin_notices()
{
    remove_all_actions('admin_notices');
}
add_action( 'admin_head', 'has_hide_admin_notices', 1 );


/**
 *
 * WP hook - trigger function;
 *
 * function: plugin_menu() from same file
 *
 */
add_action('admin_menu', 'has_plugin_menu');

/**
 *
 * called when the plug-in is activated;
 *
 * function: plugin_activate() from class 'Tables' ->  includes/models/tables.php
 *
 * parameters: $class
 *
 *             $function
 *
 */
register_activation_hook(__FILE__,
    array('Tables', 'plugin_activate'));

/**
 *
 * called when the plug-in is deactivated;
 *
 * function: plugin_reset() from class 'Tables' ->  includes/models/tables.php
 *
 * parameters: $class
 *
 *             $function
 *
 */
register_deactivation_hook(__FILE__,
    array('Tables', 'plugin_deactivate'));

/**
 *
 * called when the plug-in is uninstalled;
 *
 * function: plugin_uninstall() from class 'Tables' ->  includes/models/tables.php
 *
 * parameters: $class
 *
 *             $function
 *
 */
register_uninstall_hook(__FILE__,
    array('Tables', 'plugin_uninstall'));

/**
 *
 * try-catch block -> include all files from plugin to check for missing files;
 *
 * function: missing_files() from main file -> accommodation-system.php
 *
 */
try {
    include_once 'includes/controller/controller.php';
    include_once 'includes/_reg.php';
    include_once 'includes/controller/style-script.php';
    include_once 'includes/libraries/stripe/init.php';
    include_once 'includes/models/tables.php';
    include_once 'includes/models/ajax-calls.php';
    include_once 'layouts/backend/settings/settings.php';
    include_once 'layouts/backend/rooms/rooms.php';
    include_once 'layouts/backend/reservations/reservations.php';
    include_once 'layouts/backend/reception/reception.php';
    include_once 'layouts/backend/schedule/schedule.php';
    include_once 'layouts/backend/options/options.php';
    include_once 'layouts/backend/wallet/wallet.php';
    include_once 'layouts/backend/translate/translate.php';
    include_once 'includes/translations/ro.php';
    include_once 'includes/translations/en.php';
} catch (Exception $ex) {
    add_action('admin_notices', 'has_missing_files');
}

/**
 *
 * variables: $notice (array)
 *
 * function: missing_files() return wp notice
 *
 */
function has_missing_files()
{
    $notice = array();

    array_push($notice, '<div class="update-nag">');
    array_push($notice, '  <p>WARNING </p>');
    array_push($notice, '</div>');

    return implode('',
        $notice);
}

/**
 *
 * instantiate 'Reg' class -> includes/_reg.php
 *
 * function: initiate() from final class 'Reg' ->  includes/_reg.php
 *
 */
$register = new Reg();
$register->initiate();
