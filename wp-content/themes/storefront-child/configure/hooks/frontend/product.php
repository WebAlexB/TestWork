<?php

function add_custom_js_to_footer() {
	echo '<script type="text/javascript">
        jQuery(document).ready(function($) {
            if ($("body").hasClass("product-added")) {
                window.location.href = "' . home_url() . '";
            }
        });
    </script>';
}

add_action('wp_footer', 'add_custom_js_to_footer');
