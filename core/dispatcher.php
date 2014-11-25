<?php
class Dispatcher {
	public static function run($request) { 
		$controllersPath = Config::get('application.paths.controllers');
		$viewsPath = Config::get('application.paths.views');

		if(!is_array($request) || count($request) < 1)
			throw new Exception("Invalid argument given. Expected request array.");

		$cPath = Config::path_combine($controllersPath, $request['controller'] . ".php");

		if(!file_exists($cPath))
			throw new Exception("Controller {$request['controller']} not found.");

		include $cPath;
		$instance = new $request['controller']();
		$action = $request['action'];
		$args = $request['args'];

		try {
			if($instance instanceof AuthController) {
				if(in_array($action, $instance->RequiresAdmin)) {
					$user = User::getCurrentUser();

					if($user->group != 10) {
						call_user_func(array(new Errors(), "Error403"));
						return;
					}
				}
			}

			call_user_func_array(array($instance, $action), $args);
		}
		catch(Exception $ex) {
			echo "Error occured while attempting to call {$request['controller']}::{$action}. {$ex->getMessage()}";
		}
	}
}
?>