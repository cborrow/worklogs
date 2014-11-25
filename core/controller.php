<?php
class Controller {
	public function __construct() {

	}

	public function redirect($uri, $isRequest = false) {
		$base = Config::get("site.uri.full");
		$index = Config::get("site.uri.index_page");
		$full = "";

		if($isRequest) {
			$full = Config::path_combine($base, $index);
			$full = Config::path_combine($full, $uri);
		}
		else {
			$full = Config::path_combine($base, $uri);
		}

		if(!headers_sent())
			header("Location: {$full}");
		else
			echo "<script type='text/javascript'>window.location=\"{$full}\"</script>";
	}
}
?>