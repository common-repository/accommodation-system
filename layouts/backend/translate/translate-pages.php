<?php

/*
Accommodation System - AS - AS


Description: This WordPress plugin will allow you to create a reservation management system directly into your WordPress website. Let your customers to book rooms, houses or any other rental space that you own.


*/

    if (!class_exists('TranslateReception')){
        class TranslateReception extends Translate{

            function __construct(){
                parent::__construct();
            }

            public static function translate_reception_layout(){
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
                                <h3 class="panel-title"><?php _e($txt->txt('Manage translations')) ?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">

                                </div>
                                <hr style="clear: both;">
                                <!-- Room type listing -->
                                <div id="room-list">

                                    <?php
                                        $i = 0;
                                        $txt_list = $txt->txt_list();
                                        foreach ($txt_list as $values){
                                            $i++;
                                            ?>
                                            <form method="post" action="<?php echo admin_url(); ?>admin-post.php"
                                                  class="translate<?php echo $i; ?>">
                                                <input type="hidden" name="action" value="has">
                                                <input type="hidden" name="task" value="save_translate">
                                                <input type="hidden" name="nonce"
                                                       value="<?php echo wp_create_nonce('has-hotel-booking'); ?>">
                                                <div class="form-group col-md-2" id="category_<?php print_r($values['page']) ?>">
                                                    <input type="" disabled="disabled" class="form-control"
                                                           name="page<?php echo $i; ?>"
                                                           value="<?php print_r($values['page']) ?>">
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <input type="" disabled="disabled" class="form-control"
                                                           name="default_translation<?php echo $i; ?>"
                                                           value="<?php print_r($values['default']) ?>">
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <input type="field" class="form-control"
                                                           name="custom_translation<?php echo $i; ?>"
                                                           accept="" value="<?php print_r(stripslashes($values['description'])) ?>"
                                                           onblur="save_translation(<?php echo $i; ?>)">
                                                </div>
                                                <input type="hidden" name="index" value="<?php echo $i; ?>">
                                            </form>
                                        <?php } ?>

                                    <div class="form-group">
                                        <small class="form-text text-muted"><?php echo $txt->txt("Translations will be automatically saved after typing...") ?></small>
                                    </div>
                                    <input type="hidden" name="string_nr" value="<?php count($txt_list) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script>


                    function save_translation(param){
                        var timeoutId;

                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(function(){
                                                   var options = {
                                                       beforeSubmit: validate,
                                                       success     : response_translation_saved,
                                                       resetForm   : false
                                                   };
                                                   var index = param;
                                                   jQuery('.translate'+param)
                                                   .ajaxSubmit(options);

                                                   // Runs 1/2 second (500 ms) after the last change
                                                   // response_translation_saved();
                                               },
                                               500);

                    }


                    function validate(){
                        if (jQuery('#hotel_name')
                        .val() == ''){
                            notify_warning('Hotel name must be filled up!');
                            jQuery('#name')
                            .focus();
                            return false;
                        }
                        return true;
                    }

                    function response_translation_saved(){

                        has_ajax_call();

                        notify('translations updated');
                    }
                </script>
                <?php

            }

        }
    }