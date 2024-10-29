<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

if (!class_exists('RoomType')) {
    class RoomType extends Rooms
    {

        function __construct()
        {
            parent::__construct();
        }

        public static function room_type_layout()
        {
            $controller = new Controller();
            include $controller->plugin_path . 'includes/models/methods-api.php';
            $method = new Methods();
            include $controller->plugin_path . 'includes/translations/translations.php';
            $txt = new Translation;
            ?>

            <div class="row" style="margin-top:30px;">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="main-body-section">
                            <h3 class="panel-title"><?php echo $txt->txt("Manage Room Type") ?></h3>
                        </div>
                        <div class="panel-body">

                            <button type="button" class="has-button-default"
                                    onclick="has_ajax_call('room-type-add', 'true', 'false', 'modal_body')	"
                                    style="float: right; margin-bottom:15px;">
                                <?php echo $txt->txt("+ Add new room type") ?>
                            </button>
                            <hr style="clear: both;">
                            <!-- Room type listing -->
                            <div class="container-items">
                                <?php
                                global $wpdb;
                                $room_type = $wpdb->prefix . 'hotel_has_room_type';
                                $query_result = $wpdb->get_results("SELECT * FROM `$room_type`",
                                    ARRAY_A);
                                foreach ($query_result as $row) {
                                    ?>
                                    <div class="container-item">
                                        <div class="container-item-name"><?php echo $row['name']; ?></div>
                                        <div class="container-item-type"><?php echo $txt->txt("Capacity") . ' ' . $row['capacity'];; ?></div>
                                        <div class="container-item-type"><?php echo $method->has_currency($row['price']); ?></div>
                                        <!--
                                            <div class="container-item-image">
                                                <img src="<?php echo $row['image_url']; ?>">
                                            </div>
                                    -->
                                        <span>
                                                <button type="button" class="has-button-default"
                                                        onclick="has_ajax_call('room-type-edit', 'true', 'false', 'modal_body', <?php echo $row['room_type_id']; ?>)">
                                                        <?php echo $txt->txt("edit") ?>
                                                </button>
                                                <button type="button" class="has-button-default"
                                                        onclick="has_ajax_call('room-type-delete', 'true', 'false', 'modal_body', <?php echo $row['room_type_id']; ?>)">
                                                        <?php echo $txt->txt("delete") ?>
                                                </button>
                                            </span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}