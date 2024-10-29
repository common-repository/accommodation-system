<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ReceptionAdd')){
        class ReceptionAdd extends Reception{

            function __construct(){
                parent::__construct();
            }

            public static function reception_add_modal(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                ?>

                <form method="post" action="<?php echo admin_url(); ?>admin-post.php" class="booking-add">
                    <input type="hidden" name="action" value="has">
                    <input type="hidden" name="task" value="create_booking">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">

                    <div class="row">
                        <div class="col-md-6">

                            <!-- GUEST PERSONAL DETAIL INFORMATION -->
                            <fieldset>
                                <legend><?php echo $txt->txt("Booking detail") ?></legend>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Booking status") ?></label>
                                    <select class="form-control" name="status">
                                        <option value="1"><?php echo $txt->txt("Pending") ?></option>
                                        <option value="2"><?php echo $txt->txt("Approved") ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Guest name") ?></label>
                                    <input type="text" class="form-control" name="name" value="" id="name">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Address") ?></label>
                                    <input type="text" class="form-control" name="address" value="">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Email") ?></label>
                                    <input type="text" class="form-control" name="email" value="">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Phone") ?></label>
                                    <input type="text" class="form-control" name="phone" value="">
                                </div>
                                <div class="form-group">
                                    <label><?php echo $txt->txt("Total guests") ?></label>
                                    <input type="text" class="form-control" name="total_guest" value="">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">

                            <!-- ROOM ALLOCATION INFORMATION -->
                            <fieldset>
                                <legend><?php echo $txt->txt("Room allocation") ?></legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo $txt->txt("Checkin date") ?></label>
                                            <input type="text" class="form-control datepicker" name="checkin_timestamp"
                                                   id="checkin_timestamp"
                                                   readonly style="cursor:pointer;" value="<?php echo date('d M, Y'); ?>"
                                                   onClick="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo $txt->txt("Checkout date") ?></label>
                                            <input type="text" class="form-control datepicker" name="checkout_timestamp"
                                                   id="checkout_timestamp"
                                                   readonly style="cursor:pointer;"
                                                   value="<?php echo date('d M, Y',
                                                                          strtotime(' +1 day')); ?>" onClick="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">

                                        <button type="button" class="btn btn-success btn-sm"
                                                onclick="load_available_room_list()"
                                                style="margin:20px 0px;width:100%">
                                            <?php echo $txt->txt("Search") ?></button>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo $txt->txt("Available rooms") ?></label>
                                            <span id="available_room_list">
								
							</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success btn-sm" onclick="add_room()"
                                                    style="margin:20px 0px;width:100%">
                                                <?php echo $txt->txt("+ Add room") ?></button>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>

                            <table class="table table-striped" id="rooms">
                                <thead>
                                <tr>
                                    <th><?php echo $txt->txt("Room") ?></th>
                                    <th><?php echo $txt->txt("Date") ?></th>
                                    <th><?php echo $txt->txt("Price") ?></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <hr>
                            <fieldset>
                                <legend><?php echo $txt->txt("Hotel Service") ?></legend>
                            </fieldset>

                            <table style="width:100%;">
                                <?php
                                    $services = $method->has_get_services();
                                    foreach ($services as $row):
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" style="margin:5px;"
                                                       name="service_<?php echo $row['service_id']; ?>"
                                                       value="yes">
                                            </td>
                                            <td>
                                                <?php echo $row['name']; ?>
                                            </td>
                                            <td>
                                                <?php if ($row['type'] == '2'): ?>
                                                    <select class="form-control"
                                                            name="guest_number_<?php echo $row['service_id']; ?>">
                                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i ." " . $txt->txt('guest')?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                <?php endif; ?>
                                                <?php if ($row['type'] == '3'): ?>
                                                    <select class="form-control"
                                                            name="night_number_<?php echo $row['service_id']; ?>">
                                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i . " " . $txt->txt('night')?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                <?php endif; ?>
                                            </td>
                                            <td style="width:20%; text-align:right;">
                                                <?php
                                                    echo $method->has_currency($row['price']);
                                                    if ($row['type'] == '2'){
                                                        echo '/'. $txt->txt('guest');
                                                    }
                                                    if ($row['type'] == '3'){
                                                        echo '/' . $txt->txt('night');
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset>
                                <div class="form-group">
                                    <div style="float:right;">
                                        <button type="submit"
                                                class="btn btn-primary btn-sm"><?php echo $txt->txt("Create booking") ?></button>
                                        <button type="button" class="btn btn-default btn-sm"
                                                data-dismiss="modal"><?php echo $txt->txt("Close") ?></button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                </form>


                <script type="text/javascript">
                    // Ajax form plugin calls at each modal loading,
                    jQuery(document)
                    .ready(function(){

                        // Configuration for ajax form submission
                        var options = {
                            beforeSubmit: validate,
                            success     : response_booking_add,
                            resetForm   : true
                        };

                        // Binding the form for ajax submission
                        jQuery('.booking-add')
                        .submit(function(){
                            jQuery(this)
                            .ajaxSubmit(options);

                            // prevents normal form submission
                            return false;
                        });


                        // Make the datepicker input fields
                        jQuery("#checkout_timestamp")
                        .datepicker(
                                {
                                    minDate   : new Date(),
                                    dateFormat: 'dd M yy'
                                });

                        jQuery("#checkin_timestamp")
                        .datepicker(
                                {
                                    minDate   : new Date(),
                                    dateFormat: 'dd M yy',
                                    onSelect  : function(){
                                        var date2 = jQuery('#checkin_timestamp')
                                        .datepicker('getDate');
                                        date2.setDate(date2.getDate()+1);
                                        jQuery('#checkout_timestamp')
                                        .datepicker('option',
                                                    'minDate',
                                                    date2);
                                    }
                                });

                        // Load the available room list within timestamp range
                        clear();

                    });

                    function load_available_room_list(){
                        var checkin_timestamp = jQuery("#checkin_timestamp")
                        .val();
                        var checkout_timestamp = jQuery("#checkout_timestamp")
                        .val();
                        has_ajax_call('reception-add-room-list',
                                      'false',
                                      'false',
                                      'available_room_list',
                                      checkin_timestamp,
                                      checkout_timestamp);
                    }

                    function clear(){
                        jQuery("#room_id")
                        .empty();
                    }

                    function validate(){

                        if (jQuery('#name')
                        .val() == ''){
                            notify_warning('<?php echo $txt->txt("Name must be filled up!") ?>');
                            jQuery('#name')
                            .focus();
                            return false;
                        }
                        if (jQuery('#rooms tbody tr')[0]){
                            return true;
                        }
                        else{
                            notify_warning('<?php echo $txt->txt("There is no room allocated for this reservation. Please add a room.") ?>');
                            jQuery('#available-rooms')
                            .focus();
                            return false;
                        }
                        return true;
                    }

                    function response_booking_add(){
                        jQuery('#modal')
                        .modal('hide');
                        has_ajax_call('reception',
                                      'false',
                                      'false',
                                      'main-ajax-response');
                        notify('<?php echo $txt->txt("Reservation added successfully") ?>');
                    }

                    function add_room(){

                        var room_id = jQuery("#room_id")
                        .val();
                        if (jQuery("#room_id option")[0]){
                            var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
                            jQuery.post(
                                    ajaxurl,
                                    {
                                        'action'       : 'has_task',
                                        'task_name'    : 'reception-add-room',
                                        'room_id'      : room_id,
                                        'checkin_date' : jQuery("#checkin_timestamp")
                                        .val(),
                                        'checkout_date': jQuery("#checkout_timestamp")
                                        .val()
                                    },
                                    function(response){
                                        jQuery('#rooms tbody')
                                        .append(response);
                                        jQuery(".btn_delete_room")
                                        .click(function(event){
                                            jQuery(this)
                                            .parent()
                                            .parent()
                                            .remove();
                                        });
                                    }
                            );
                        }
                        else{
                            notify_warning('<?php echo $txt->txt("There are no selected rooms") ?>');
                            jQuery('#room_id')
                            .focus();
                            return false;
                        }
                    }

                </script> <?php

            }

        }
    }