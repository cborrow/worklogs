<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 'Off');
define("APP_BASE", dirname("./"));
define("CORE_BASE", APP_BASE . "/core/");
define("SITE_BASE", APP_BASE . "/site/");

require_once CORE_BASE . "request.php";
require_once CORE_BASE . "dispatcher.php";
require_once CORE_BASE . "router.php";
require_once CORE_BASE . "config.php";
require_once CORE_BASE . "user.php";
require_once CORE_BASE . "controller.php";
require_once CORE_BASE . "authcontroller.php";
require_once CORE_BASE . "view.php";
require_once CORE_BASE . "database.php";
require_once CORE_BASE . "model.php";

include "siteconfig.php";

User::init();

function __autoLoad($name) {
	$fName = strtolower($name) . ".php";
	$lPath = Config::path_combine(Config::get("application.paths.libraries"), $fName);
	$mPath = Config::path_combine(Config::get("application.paths.models"), $fName);

	if(file_exists($lPath))
		include $lPath;
	else if(file_exists($mPath))
		include $mPath;
}

$request = Request::generateRequest($_SERVER['REQUEST_URI']);
$request = Router::processRequest($request);
Dispatcher::run($request);
?>