<?php
class View {
	protected static $helpers;

	public static function addHelper($helperName) {
		$helpersPath = Config::get("application.paths.helpers");
		$hPath = Config::path_combine($helpersPath, $helperName . ".php");

		if(file_exists($hPath)) {
			self::$helpers[] = $hPath;
		}
	}

	public static function render($view, $args = null) {
		$viewsPath = Config::get("application.paths.views");
		$vPath = Config::path_combine($viewsPath, $view . ".php");

		if(!file_exists($vPath))
			throw new Exception("View [{$view}] not found.");

		ob_start();

		foreach((array)self::$helpers as $helper) {
			include $helper;
		}

		if($args != null)
			extract($args);

		include $vPath;
		$content = ob_flush();
		ob_end_clean();

		return $content;
	}
}
?>