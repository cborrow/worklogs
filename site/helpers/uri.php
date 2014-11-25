<?php
if(!function_exists('uri')) {
	function uri($request) {
		$full = Config::get("site.uri.full") . Config::get("site.uri.index_page");

		if(is_array($request) && count($request) == 3) {
			$uri = $request['controller'] . "/" . $request['action'];
			$uri = $uri . "/" . implode("/", $request['args']);
			$uri = Config::path_combine($full, $uri);
			return $uri;
		}
		else {
			$uri = Config::path_combine($full, $request);
			return $uri;
		}
	}
}

if(!function_exists('baseUri')) {
	function baseUri($request) {
		$full = Config::get("site.uri.full");

		if(is_array($request) && count($request) == 3) {
			$uri = $request['controller'] . "/" . $request['action'];
			$uri = $uri . "/" . implode("/", $request['args']);
			$uri = Config::path_combine($full, $uri);
			return $uri;
		}
		else {
			$uri = Config::path_combine($full, $request);
			return $uri;
		}
	}
}

if(!function_exists('href')) {
	function href($url, $text) {
		echo "<a href=\"{$url}\">{$text}</a>";
	}
}

if(!function_exists('asset')) {
	function asset($assetName) {
		$assetPath = Config::get("application.paths.assets");
		$assetPath = Config::path_combine($assetPath, $assetName);
		return baseUri($assetPath);
	}
}
?>