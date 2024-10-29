jQuery(window)
.on('load resize',
    function(){
        var wrap = jQuery('.ci-responsive-shortcode');
        var wrap_width = wrap.width();
        if (wrap_width<=930 && wrap_width>820){
            wrap.addClass('responsive-lg')
                .removeClass('responsive-md responsive-sm responsive-xs');
        }
        else if (wrap_width<=820 && wrap_width>690){
            wrap.addClass('responsive-md')
                .removeClass('responsive-lg responsive-sm responsive-xs');
        }
        else if (wrap_width<=690 && wrap_width>510){
            wrap.addClass('responsive-sm')
                .removeClass('responsive-lg responsive-md responsive-xs');
        }
        else if (wrap_width<=510){
            wrap.addClass('responsive-xs')
                .removeClass('responsive-lg responsive-md responsive-sm');
        }
    });



