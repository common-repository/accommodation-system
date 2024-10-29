<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('RoomTypeAdd')){
        class RoomTypeAdd extends Rooms{

            function __construct(){
                parent::__construct();
            }

            public static function room_type_add_modal(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                ?>
                <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="room-type-add">
                    <input type="hidden" name="action" value="has">
                    <input type="hidden" name="task" value="create_room_type">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Name") ?></label>
                                    <input type="text" class="form-control"
                                           placeholder="<?php echo $txt->txt("Room type") ?>" name="name" value=""
                                           id="name" autofocus>
                                    <small class="form-text text-muted"><?php echo $txt->txt("e.g. deluxe") ?></small>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Guest Capacity") ?></label>
                                    <select class="form-control" name="capacity">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect2"><?php echo $txt->txt("Bed(s)") ?></label>
                                    <select class="form-control" name="beds[]" multiple
                                            style="height:100px !important;">

                                        <option value="single"><?php echo $txt->txt("single") ?></option>
                                        <option value="twin"><?php echo $txt->txt("twin") ?></option>
                                        <option value="double"><?php echo $txt->txt("double") ?></option>
                                        <option value="queen"><?php echo $txt->txt("queen") ?></option>
                                        <option value="king"><?php echo $txt->txt("king") ?></option>
                                        <option value="2xtwin"><?php echo $txt->txt("2xtwin") ?></option>
                                        <option value="2xsingle"><?php echo $txt->txt("2xsingle") ?></option>
                                        <option value="couch"><?php echo $txt->txt("couch") ?></option>

                                    </select>
                                    <small class="form-text text-muted"><?php echo $txt->txt("Hold ctrl(on windows) or cmd(on mac) and select multiple") ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect3"><?php echo $txt->txt("Permissions") ?></label>
                                    <select class="form-control" name="permissions[]" multiple
                                            style="height:100px !important;">

                                        <option value="smoking"><?php echo $txt->txt("smoking") ?></option>
                                        <option value="no-smoking"><?php echo $txt->txt("no-smoking") ?></option>
                                        <option value="pets"><?php echo $txt->txt("pets") ?></option>
                                        <option value="no-pets"><?php echo $txt->txt("no-pets") ?></option>

                                    </select>
                                    <small class="form-text text-muted"><?php echo $txt->txt("Hold ctrl(on windows) or cmd(on mac) and select multiple") ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect1"><?php echo $txt->txt("Amenities") ?></label>
                                    <select class="form-control" name="amenities[]" multiple
                                            style="height:100px !important;">
                                        <?php
                                            $amenities = $method->has_get_amenities();
                                            foreach ($amenities as $row):
                                                ?>
                                                <option value="<?php echo $row['amenity_id']; ?>">
                                                    <?php echo $row['name']; ?>
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
                                           value="" id="price">
                                    <small class="form-text text-muted"><?php echo $txt->txt("e.g. $50") ?></small>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6" style="text-align:right;">
                            <fieldset>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Featured image") ?></label>
                                    <br>
                                    <img src="" id="room_image"
                                         style="height:200px; min-width:100px; border:1px solid #ccc; padding: 2px;">
                                </div>
                                <input type="hidden" name="image_url" value="" id="image_url">
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
                                            class="btn btn-primary btn-sm"><?php echo $txt->txt("Create room type") ?></button>
                                    <button type="button" class="btn btn-default btn-sm"
                                            data-dismiss="modal"><?php echo $txt->txt("Close") ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <script type="text/javascript">
                    // ajax form plugin calls at each modal loading,
                    jQuery(document)
                    .ready(function(){

                        // configuration for ajax form submission
                        var options = {
                            beforeSubmit: validate,
                            success     : response_room_type_add,
                            resetForm   : true
                        };

                        // binding the form for ajax submission
                        jQuery('.room-type-add')
                        .submit(function(){
                            jQuery(this)
                            .ajaxSubmit(options);

                            // prevents normal form submission
                            return false;
                        });
                    });

                    function validate(){
                        if (jQuery('#name')
                        .val() == ''){
                            notify_warning('<?php echo $txt->txt("Name must be filled up!") ?>');
                            jQuery('#name')
                            .focus();
                            return false;
                        }
                        if (jQuery('#price')
                            .val() == ''){
                            notify_warning('<?php echo $txt->txt("You need to add a basic price!") ?>');
                            jQuery('#price')
                                .focus();
                            return false;
                        }
                        return true;
                    }

                    function response_room_type_add(){
                        jQuery('#modal')
                        .modal('hide');
                        has_ajax_call('room-type',
                                      'false',
                                      'false',
                                      'tab1');
                        notify('<?php echo $txt->txt("Room type added successfully") ?>');
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