<?php
class AuthController extends Controller {
	public $RequiresAdmin;

	public function __construct() {
		parent::__construct();

		$this->RequiresAdmin = array();
		$user = User::getCurrentUser();

		if($user == null) {
			$this->redirect('/login.php');
		}
	}
}
?>