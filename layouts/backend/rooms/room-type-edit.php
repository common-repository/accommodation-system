<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('RoomTypeEdit')){
        class RoomTypeEdit extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function room_type_edit_modal(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $room_type_id = sanitize_text_field($_POST['param1']);
                global $wpdb;
                $room_type = $wpdb->prefix . 'hotel_has_room_type';
                $query_result = $wpdb->get_results("SELECT * FROM `$room_type` WHERE `room_type_id` = $room_type_id",
                                                   ARRAY_A);
                foreach ($query_result as $row):
                    ?>
                    <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="room-type-edit">
                        <input type="hidden" name="action" value="has">
                        <input type="hidden" name="task" value="edit_room_type">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                        <input type="hidden" name="room_type_id" value="<?php echo $room_type_id; ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label><?php echo $txt->txt("Name") ?></label>
                                        <input type="text" class="form-control"
                                               placeholder="<?php echo $txt->txt("Room type") ?>" name="name"
                                               value="<?php echo $row['name']; ?>">
                                        <small class="form-text text-muted"><?php echo $txt->txt("e.g. deluxe") ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $txt->txt("Guest Capacity") ?></label>
                                        <select class="form-control" name="capacity">
                                            <option value="1" <?php if ($row['capacity'] == 1){
                                                echo 'selected';
                                            } ?>>1
                                            </option>
                                            <option value="2" <?php if ($row['capacity'] == 2){
                                                echo 'selected';
                                            } ?>>2
                                            </option>
                                            <option value="3" <?php if ($row['capacity'] == 3){
                                                echo 'selected';
                                            } ?>>3
                                            </option>
                                            <option value="4" <?php if ($row['capacity'] == 4){
                                                echo 'selected';
                                            } ?>>4
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleSelect1"><?php echo $txt->txt("Bed(s)") ?></label>
                                        <select class="form-control" name="beds[]" multiple
                                                style="height:100px !important;">
                                            <?php
                                            $beds = ['single', 'twin', 'double', 'queen', 'king', '2xtwin', '2xsingle', 'couch'];
                                            foreach ($beds as $row2):
                                                $room_beds_json = $row['bed_type'];
                                                $room_beds_array = json_decode($room_beds_json);
                                                ?>
                                                <option <?php if (in_array($row2, $room_beds_array)){
                                                    echo 'selected';
                                                } ?>
                                                        value="<?php echo $row2; ?>">
                                                    <?php echo $txt->txt($row2); ?>
                                                </option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                        <small class="form-text text-muted"><?php echo $txt->txt("Hold ctrl(on windows) or cmd(on mac) and select multiple") ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleSelect1"><?php echo $txt->txt("Permissions") ?></label>
                                        <select class="form-control" name="permissions[]" multiple
                                                style="height:100px !important;">
                                            <?php
                                            $permissions = ['smoking', 'no-smoking', 'pets', 'no-pets'];
                                            foreach ($permissions as $row2):
                                                $room_permissions_json = $row['permissions'];
                                                $room_permissions_array = json_decode($room_permissions_json);
                                                ?>
                                                <option <?php if (in_array($row2, $room_permissions_array)){
                                                    echo 'selected';
                                                } ?>
                                                        value="<?php echo $row2; ?>">
                                                    <?php echo $txt->txt($row2); ?>
                                                </option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                        <small class="form-text text-muted"><?php echo $txt->txt("Hold ctrl(on windows) or cmd(on mac) and select multiple") ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleSelect1"><?php echo $txt->txt("Amenities") ?></label>
                                        <select class="form-control" name="amenities[]" multiple
                                                style="height:100px !important;">
                                            <?php
                                                $amenities = $method->has_get_amenities();
                                                foreach ($amenities as $row2):
                                                    $room_amenities_json = $row['amenities'];
                                                    $room_amenities_array = json_decode($room_amenities_json);
                                                    ?>
                                                    <option <?php if (in_array($row2['amenity_id'],
                                                                               $room_amenities_array)){
                                                        echo 'selected';
                                                    } ?>
                                                            value="<?php echo $row2['amenity_id']; ?>">
                                                        <?php echo $row2['name']; ?>
                                                    </option>
                                                <?php
                                                endforeach;
                                            ?>
                                        </select>
                                        <small class="form-text text-muted"><?php echo $txt->txt("Hold ctrl(on windows) or cmd(on mac) and select multiple") ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label><?php _e("Price",
                                                        self::$text_domain) ?></label>
                                        <input type="text" class="form-control"
                                               placeholder="<?php echo $txt->txt("Basic price") ?>" name="price"
                                               value="<?php echo $row['price']; ?>">
                                        <small class="form-text text-muted"><?php echo $txt->txt("e.g. $50") ?></small>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6" style="text-align:right;">
                                <fieldset>
                                    <div class="form-group">
                                        <label><?php echo $txt->txt("Featured image") ?></label>
                                        <br>
                                        <img src="<?php echo $row['image_url']; ?>" id="room_image"
                                             style="height:200px; min-width:100px; border:1px solid #ccc; padding: 2px;">
                                    </div>
                                    <input type="hidden" name="image_url" value="<?php echo $row['image_url']; ?>"
                                           id="image_url">
                                    <button class="btn btn-default btn-xs" onclick="open_media_uploader()"
                                            type="button"><?php echo $txt->txt("Select image") ?></button>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div style="float:right;">
                                        <button type="submit"
                                                class="btn btn-primary btn-sm"><?php echo $txt->txt("Update") ?></button>
                                        <button type="button" class="btn btn-default btn-sm"
                                                data-dismiss="modal"><?php echo $txt->txt("Close") ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php
                endforeach;
                ?>

                <script type="text/javascript">
                    // ajax form plugin calls at each modal loading,
                    jQuery(document)
                    .ready(function(){

                        // configuration for ajax form submission
                        var options = {
                            beforeSubmit: validate,
                            success     : response_room_type_edit,
                            resetForm   : true
                        };

                        // binding the form for ajax submission
                        jQuery('.room-type-edit')
                        .submit(function(){
                            jQuery(this)
                            .ajaxSubmit(options);

                            // prevents normal form submission
                            return false;
                        });
                    });

                    function validate(){
                        return true;
                    }

                    function response_room_type_edit(){
                        jQuery('#modal')
                        .modal('hide');
                        has_ajax_call('room-type',
                                      'false',
                                      'false',
                                      'tab1');
                        notify('<?php echo $txt->txt("Room type updated successfully") ?>');
                    }

                    // WP MEDIA UPLOADER FOR IMAGE UPLOADING
                    var media_uploader = null;

                    function open_media_uploader(){
                        media_uploader = wp.media({
                                                      frame   : "post",
                                                      state   : "insert",
                                                      multiple: false
                                                  });

                        media_uploader.on("insert",
                                          function(){
                                              var json = media_uploader.state()
                                                                       .get("selection")
                                                                       .first()
                                                                       .toJSON();

                                              var image_url = json.url;
                                              var image_caption = json.caption;
                                              var image_title = json.title;

                                              jQuery("#image_url")
                                              .val(image_url);
                                              jQuery("#room_image")
                                              .attr("src",
                                                    image_url);
                                          });

                        media_uploader.open();
                    }

                </script> <?php

            }

        }
    }
