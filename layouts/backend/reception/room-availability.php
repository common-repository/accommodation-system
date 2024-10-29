<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('ReceptionRoomAvailability')){
        class ReceptionRoomAvailability extends Reception{

            function __construct(){
                parent::__construct();
            }

            public static function reception_room_availability_layout(){
                $controller = new Controller();
                include $controller->plugin_path . 'includes/models/methods-api.php';
                $method = new Methods();
                include $controller->plugin_path . 'includes/translations/translations.php';
                $txt = new Translation;

                $room_id = sanitize_text_field($_POST['param1']);
                $room_name = $method->has_get_room_name($room_id);
                $room_type_name = $method->has_get_room_type_name($room_id);
                ?>
                <center>
                    <h4 style="margin-bottom:40px;"><?php echo $txt->txt("Booking status of room") ?>
                        - <?php echo $room_name; ?> (<?php echo $room_type_name; ?>)</h4>
                </center>

                <div class="calendar"></div>

                <script>
                    jQuery(document)
                    .ready(function(){
                        var currentYear = new Date().getFullYear();
                        jQuery('.calendar')
                        .calendar({
                                      style               : 'background',
                                      alwaysHalfDay       : true,
                                      enableContextMenu   : true,
                                      enableRangeSelection: true,

                                      clickDay: function(e){
                                          if (e.events.length>0){
                                              for (var i in e.events){
                                                  //alert(e.events[i].location);
                                                  //    			has_ajax_call('reception-summary', 'false', 'false', e.events[i].booking_id);
                                                  jQuery(".info")
                                                  .removeClass("info");
                                                  jQuery("#row_"+e.events[i].booking_id)
                                                  .addClass("info");
                                                  has_ajax_call('reception-summary',
                                                                'false',
                                                                'false',
                                                                'booking_detail_top',
                                                                e.events[i].booking_id);
                                              }
                                              jQuery("body,html")
                                              .animate(
                                                      {
                                                          scrollTop: jQuery("#booking_detail_top")
                                                          .offset().top
                                                      },
                                                      800 //speed
                                              );
                                          }
                                          return false;
                                      },

                                      dataSource: [

                                          <?php
                                          $bookings = $method->has_get_booking_of_room($room_id);
                                          foreach($bookings as $row) : //break;
                                          ?>
                                          {
                                              booking_id: '<?php echo $row["booking_id"];?>',
                                              startDate : new Date("<?php echo date("Y", $row['checkin_timestamp']);?>, <?php echo date("n", $row['checkin_timestamp']);?>, <?php echo date("j", $row['checkin_timestamp']);?>"),
                                              endDate   : new Date("<?php echo date("Y", $row['checkout_timestamp']);?>, <?php echo date("n", $row['checkout_timestamp']);?>, <?php echo date("j", $row['checkout_timestamp']);?>")
                                          },

                                          <?php
                                          endforeach;
                                          ?>
                                      ]

                                  });

                    });
                </script> <?php

            }

        }
    }