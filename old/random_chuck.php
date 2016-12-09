<?php
    function get_chuck_quote() {
        $text = file_get_contents("http://api.icndb.com/jokes/random");
        $data = json_decode($text);
        
        if(is_object($data) && property_exists($data, 'value')) {
            echo $data->value->joke;
        }
    }
?>