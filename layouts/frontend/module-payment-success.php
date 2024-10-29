<?php

    use \Inc\api\DataApi;

    defined('ABSPATH') or die('Access not allowed!');

    $method = sanitize_text_field($_POST['method']);
    echo $method;
?>
<?php _e("Thanks! Your payment is successfully completed.",
         \Inc\Base\BaseController::$text_domain) ?>