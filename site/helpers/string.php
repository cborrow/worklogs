<?php
if(!function_exists(ellipse_string)) {
	function ellipse_string($string, $length) {
		if(strlen($string) > $length)
			return substr($string, 0, $length) . "...";
		else
			return $string;
	}
}
?>