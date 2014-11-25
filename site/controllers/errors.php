<?php
class Errors extends Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index() {

	}

	public function Error404() {
		$data = array();
		$data['errorcode'] = 404;
		$data['errorstr'] = 'The page you requested could not be found. If you believe this to be a mistake please contact your system admin';
		
		View::render('error.default', $data);
	}

	public function Error403() {
		$data = array();
		$data['errorcode'] = 403;
		$data['errorstr'] = 'You do not have the required permissions to access the page your requested.';
		
		View::render('error.default', $data);
	}
}
?>