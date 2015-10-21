<?php
if(!function_exists('asset')) {
    function asset($name) {
        $base = config_item('base_url');
        $base .= "assets/" . $name;

        return $base;
    }
}
?>