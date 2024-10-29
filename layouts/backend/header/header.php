<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('HASTemplateHeader')){
        class HASTemplateHeader extends Controller{

            function __construct(){
                parent::__construct();
            }

            function template_header(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/translations/translations.php';
                include $controller->plugin_path . 'layouts/backend/header/modal.php';
                $txt = new Translation;
                $icons = array();
                $icons['main']      =   $controller->plugin_url . 'assets/css/backend/icons/has-g-24.png';
                $icons['Reception'] =   '<img src="' . $controller->plugin_url . 'assets/css/backend/icons/submenu-reception.png' . '">';
                $icons['Rooms']     =   '<img src="' . $controller->plugin_url . 'assets/css/backend/icons/submenu-rooms.png' . '">';
                $icons['Schedule']  =   '<img src="' . $controller->plugin_url . 'assets/css/backend/icons/submenu-schedule.png' . '">';
                $icons['Options']   =   '<img src="' . $controller->plugin_url . 'assets/css/backend/icons/submenu-options.png' . '">';
                $icons['Wallet']    =   '<img src="' . $controller->plugin_url . 'assets/css/backend/icons/submenu-wallet.png' . '">';
                $icons['Settings']  =   '<img src="' . $controller->plugin_url . 'assets/css/backend/icons/submenu-settings.png' . '">';
                $icons['Translate'] =   '<img src="' . $controller->plugin_url . 'assets/css/backend/icons/submenu-translate.png' . '">';
                $icons['Sync']      =   '<img src="' . $controller->plugin_url . 'assets/css/backend/icons/submenu-sync.png' . '">';


                ?>

                <div class="main-header">
                    <div class="main-header-title">

                    </div>
                    <div id="preloader" class="preloader">
                        <span class="preloader-helper"></span>
                        <img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/preloader.svg'; ?>">
                    </div>
                    <div class="main-header-menu">
                        <div class="main-menu">
                            <div>
                                <a href="#tab1"
                                   onclick="has_ajax_call('reception', 'false', 'false', 'main-ajax-response')">
                                    <div class="main-header-menu-title"><?php echo $icons['Reception'] . " " . $txt->txt('Reception') ?></div>
                                </a>
                            </div>
                            <div>
                                <a href="#tab2" onclick="has_ajax_call('rooms', 'false', 'false', 'main-ajax-response')">
                                    <div class="main-header-menu-title"><?php echo $icons['Rooms'] . " " . $txt->txt('Rooms') ?></div>
                                </a>
                            </div>
                            <div>
                                <a href="#tab3" onclick="has_ajax_call('schedule', 'false', 'false', 'main-ajax-response')">
                                    <div class="main-header-menu-title"><?php echo $icons['Schedule'] . " " . $txt->txt('Schedule') ?></div>
                                </a>
                            </div>
                            <div>
                                <a href="#tab4" onclick="has_ajax_call('options', 'false', 'false', 'main-ajax-response')">
                                    <div class="main-header-menu-title"><?php echo $icons['Options'] . " " . $txt->txt('Options') ?></div>
                                </a>
                            </div>
                            <div>
                                <a href="#tab5" onclick="has_ajax_call('wallet', 'false', 'false', 'main-ajax-response')">
                                    <div class="main-header-menu-title"><?php echo $icons['Wallet'] . " " . $txt->txt('Wallet') ?></div>
                                </a>
                            </div>
                            <div>
                                <a href="#tab6" onclick="has_ajax_call('settings', 'false', 'false', 'main-ajax-response')">
                                    <div class="main-header-menu-title"><?php echo $icons['Settings'] . " " . $txt->txt('Settings') ?></div>
                                </a>
                            </div>
                            <div>
                                <a href="#tab7"
                                   onclick="has_ajax_call('translate', 'false', 'false', 'main-ajax-response')">
                                    <div class="main-header-menu-title"><?php echo $icons['Translate'] . " " . $txt->txt('Translate') ?></div>
                                </a>
                            </div>
                            <div>
                                <a href="#tab8" onclick="has_ajax_call('sync', 'false', 'false', 'main-ajax-response')">
                                    <div class="main-header-menu-title"><?php echo $icons['Sync'] . " " . $txt->txt('Sync') ?></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
            }

        }
    }