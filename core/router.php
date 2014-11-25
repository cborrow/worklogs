<?php
class Router {
	protected static $routes;

	public static function addRoute($request, $routedRequest) {
		self::$routes[] = array('request' => $request, 'route' => $routedRequest);
	}

	public static function processRequest($request) {
		foreach((array)self::$routes as $route) {
			if($route['request'] == $request)
				return $route['route'];
		}
		return $request;
	}
}
?>