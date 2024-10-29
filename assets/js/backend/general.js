/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function notify(message){
    jQuery.toaster({
                       title   : 'Notification ',
                       message : message,
                       priority: 'info',
                       settings: {
                           'timeout': 5000,
                           'toaster': {css: {'top': '20px'}}
                       }
                   });
}

function notify_warning(message){
    jQuery.toaster({
                       title   : 'Notification ',
                       message : message,
                       priority: 'danger',
                       settings: {
                           'timeout': 5000,
                           'toaster': {css: {'top': '20px'}}
                       }
                   });
}

// Method for performing ajax calls
function make_ajax_call(nonce,
                        ajax_url,
                        view_to_load,
                        in_div,
                        param1,
                        param2,
                        param3,
                        param4){
    var ajaxurl = ajax_url;
    jQuery('#'+in_div)
    .block({
               message   : null,
               overlayCSS: {backgroundColor: '#f3f4f5'}
           });
    jQuery.post(
            ajaxurl,
            {
                'action'      : 'tidplus',
                'page'        : view_to_load,
                'response_div': in_div,
                'task'        : 'load_response',
                'nonce'       : nonce,
                'param1'      : param1,
                'param2'      : param2,
                'param3'      : param3,
                'param4'      : param4
            },
            function(response){
                setTimeout(function(){
                               jQuery('#'+in_div)
                               .unblock();
                               if (param2 == 'append'){
                                   jQuery('#'+in_div)
                                   .append(response);
                               }
                               else{
                                   jQuery('#'+in_div)
                                   .html(response);
                               }
                           },
                           500);
            }
    );
}


jQuery(document)
.on({
        //    ajaxStart: function() { jQuery("#preloader").css("display","block");    },
        //     ajaxStop: function() { jQuery("#preloader").css("display","none"); }
    });