<?php
class Config {
	public static $items;

	public static function get($itemName) {
		if(array_key_exists($itemName, self::$items))
			return self::$items[$itemName];
		return null;
	}

	public static function set($itemName, $value) {
		self::$items[$itemName] = $value;
	}

	public static function path_combine($path1, $path2) {
		$path = $path1;

		if(substr($path, -1) != "/")
			$path = $path . "/";
		if(substr($path2, 0, 1) == "/")
			$path = $path . substr($path2, 1);
		else
			$path = $path . $path2;

		return $path;
	}
}
?>