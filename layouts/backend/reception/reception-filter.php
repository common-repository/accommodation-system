<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

if (!class_exists('ReceptionFilter')){
class ReceptionFilter extends Reception{

function __construct(){
    parent::__construct();
}

public static function reception_filter_layout(){
$controller = new Controller();
include $controller->plugin_path . 'includes/models/methods-api.php';
$method = new Methods();
include $controller->plugin_path . 'includes/translations/translations.php';
$txt = new Translation;

?>
<div class="row">
    <div class="main-body-section">
        <h3 class="panel-title"><img src="<?php echo $controller->plugin_url . 'assets/css/backend/icons/reception/calendar-24.png'; ?>"> <?php echo $txt->txt("Reservations") ?></h3>
        <div class="col-md-6">

            <!--
            <button id="filter" type="button" class="has-button-default">
                <i class="fa fa-sliders"></i> <?php echo $txt->txt("filter") ?>
            </button>
            -->

            <button type="button" class="has-button-default"
                    onclick="has_ajax_call('reception-add', 'true', 'false', 'modal_body')">
                <i class="fa fa-plus"></i>
                <?php echo $txt->txt("create booking") ?>
            </button>
        </div>
    </div>
    <hr style="margin: 10px;">
    <!-- Filter toggling button -->

</div>

<!-- FILTERING OPTIONS -->
<div id="filter_options"
     style="clear: both; background-color: rgb(249, 249, 249); padding: 15px; margin: 20px 0px; display: none;">

    <div class="row" style="margin-bottom:10px;">
        <div class="col-md-4">
            <?php echo $txt->txt("Filter") ?>
        </div>

        <div class="col-md-8">
            <input type="radio" name="status" class="icheck" id="status-active" value="2" checked="">
            <label for="status-active"
                   class="status_selector"><?php echo $txt->txt("By name") ?></label>

            <input type="radio" name="status" class="icheck" id="status-reservation" value="1">
            <label for="status-reservation"
                   class="status_selector"><?php echo $txt->txt("By date") ?></label>
        </div>
    </div>
    <div class="row" style="margin-bottom:10px;" id="daterange">
        <div class="col-md-4">
            <?php echo $txt->txt("Date range") ?>
        </div>

        <div class="col-md-8">
            <div id="reportrange1"
                 style="background: #fff; cursor: pointer; padding: 7px 15px; border: 1px solid #ccc;">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <b class="caret"></b>
            </div>
            <input type="hidden" id="filter_timestamp_from">
            <input type="hidden" id="filter_timestamp_to">
        </div>
    </div>
    <div class="row" style="margin-bottom:10px;" id="guestdetail">
        <div class="col-md-4">
            <?php echo $txt->txt("Guest name or phone") ?>
        </div>

        <div class="col-md-8">
            <input type="text" class="form-control" placeholder="Name or phone number" id="guest" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <button type="submit" class="has-button-default" style="width: 100%;"
                    onclick="do_filter('true')"><?php echo $txt->txt("Filter booking") ?></button>
        </div>
    </div>
</div>



<script>


    jQuery(document)
    .ready(function(){

        // Show / hide the filtering options
        jQuery("#filter")
        .click(function(){
            jQuery("#filter_options")
            .slideToggle("fast");
        });

        // Making daterangepicker
        var start = moment();
        var end = moment();

        function cb(start, end)
        {
            jQuery('#reportrange span').html(start.format('D MMM, YYYY')+' - '+end.format('D MMM, YYYY'));
            jQuery('#start_date').val(start.format('D MMM, YYYY'));
            jQuery('#end_date').val(end.format('D MMM, YYYY'));
        }

        // Making date range picker
        jQuery('#reportrange')
        .daterangepicker({
                             startDate: start,
                             endDate  : end,
                             ranges   : {
                                 '<?php echo $txt->txt("Today") ?>': [moment(),
                                                                     moment()],
                                 '<?php echo $txt->txt("Tomorrow") ?>': [moment()
                                                                     .subtract(-1,
                                                                               'days'),
                                                                     moment()
                                                                     .subtract(-1,
                                                                               'days')],
                                 '<?php echo $txt->txt("Next 7 Days") ?>': [moment(),
                                                                     moment()
                                                                     .subtract(-6,
                                                                               'days')],
                                 '<?php echo $txt->txt("This Month") ?>': [moment()
                                                                     .startOf('month'),
                                                                     moment()
                                                                     .endOf('month')],
                                 '<?php echo $txt->txt("Next Month") ?>': [moment()
                                                                     .subtract(-1,
                                                                               'month')
                                                                     .startOf('month'),
                                                                     moment()
                                                                     .subtract(-1,
                                                                               'month')
                                                                     .endOf('month')],
                                 '<?php echo $txt->txt("Next 6 Months") ?>': [moment()
                                                                     .subtract(-1,
                                                                               'month')
                                                                     .startOf('month'),
                                                                     moment()
                                                                     .subtract(-6,
                                                                               'month')
                                                                     .endOf('month')],
                                 '<?php echo $txt->txt("Yesterday") ?>': [moment()
                                                                     .subtract(1,
                                                                               'days'),
                                                                     moment()
                                                                     .subtract(1,
                                                                               'days')],
                                 '<?php echo $txt->txt("Last 7 Days") ?>': [moment()
                                                                     .subtract(6,
                                                                               'days'),
                                                                     moment()],
                                 '<?php echo $txt->txt("Last Month") ?>': [moment()
                                                                     .subtract(1,
                                                                               'month')
                                                                     .startOf('month'),
                                                                     moment()
                                                                     .subtract(1,
                                                                               'month')
                                                                     .endOf('month')],
                                 '<?php echo $txt->txt("Last 6 Months") ?>': [moment()
                                                                     .subtract(6,
                                                                               'month')
                                                                     .startOf('month'),
                                                                     moment()
                                                                     .subtract(1,
                                                                               'month')
                                                                     .endOf('month')]
                             }
                         },
                         cb);

        cb(start,
           end);

        // Customize icheck
        jQuery('.icheck')
        .iCheck({
                    checkboxClass: 'icheckbox_square-orange',
                    radioClass   : 'iradio_square-orange',
                    increaseArea : '20%' // optional
                });
        jQuery('#status-active')
        .on('ifChecked',
            function(event){
                //jQuery("#guestdetail").slideUp(200);
                jQuery("#daterange")
                .slideUp(200);
            });
        jQuery('#status-reservation')
        .on('ifChecked',
            function(event){
                //jQuery("#guestdetail").slideDown(200);
                jQuery("#daterange")
                .slideDown(200);
            });
        jQuery('#status-completed')
        .on('ifChecked',
            function(event){
                //jQuery("#guestdetail").slideDown(200);
                jQuery("#daterange")
                .slideDown(200);
            });

        // By default, active bookings are selected
        // so, daterange won't be shown
        //jQuery("#guestdetail").slideUp(200);
        jQuery("#daterange")
        .slideUp(200);


        // Load the list of active booking, by default
        do_filter();
    });


    // Manual ajax call due to ux for toggling the filter section after completing booking list loading.
    function do_filter(toggle = 'false'){
        var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
        var status = jQuery("input[name='status']:checked")
        .val();
        var filter_timestamp_from = jQuery("#filter_timestamp_from")
        .val();
        var filter_timestamp_to = jQuery("#filter_timestamp_to")
        .val();
        var guest = jQuery("#guest")
        .val();

        jQuery.post(
                ajaxurl,
                {
                    'action'   : 'has_task',
                    'task_name': 'reception-list',
                    'param1'   : status,
                    'param2'   : filter_timestamp_from,
                    'param3'   : filter_timestamp_to,
                    'param4'   : guest
                },
                function(response){
                    jQuery('#booking_list_holder')
                    .html(response);
                    if (toggle == 'true'){
                        jQuery("#filter_options")
                        .slideToggle("fast");
                    }
                }
        );

    }


</script> <?php

}

}
}