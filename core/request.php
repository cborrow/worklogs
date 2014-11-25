<?php
class Request {
	public static function generateRequest($uri) {
		$siteUri = Config::get("site.uri.base");
		$index = Config::get("site.uri.index_page");

		$uri = preg_replace("(" . $siteUri . ")", "", $uri);
		$uri = preg_replace("(" . $index . ")", "", $uri);

		/*if(preg_match("(" . $siteUri . ")", $uri))
			$uri = preg_replace("(" . $siteUri . ")", "", $uri);
		if(preg_match("(" . $index . ")", $uri))
			$uri = preg_replace("(" . $index . ")", "", $uri);*/

		if(substr($uri, 0, 1) == "/")
			$uri = substr($uri, 1);

		$uriParts = explode("/", $uri);

		if(count($uriParts) == 1 && empty($uriParts[0]))
			$uriParts = array();

		$request = array(
			'controller' => Config::get("application.defaults.controller"),
			'action' => Config::get("application.defaults.action"),
			'args' => array());

		if(count($uriParts) > 2) {
			$request['controller'] = $uriParts[0];
			$request['action'] = $uriParts[1];
			$request['args'] = array_slice($uriParts, 2);
		}
		else if(count($uriParts) > 1) {
			$request['controller'] = $uriParts[0];
			$request['action'] = $uriParts[1];
		}
		else if(count($uriParts) > 0) {
			$request['controller'] = $uriParts[0];
		}

		return $request;
	}
}
?>