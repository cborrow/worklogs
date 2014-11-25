<?php
class User {
	protected static $activeUser;

	public static function init() {
		/*self::$activeUser = (object)array('id' => 1, 'last_login' => 1001819110,
			'username' => 'cory', 'password' => md5('network'), 'group' => 1,
			'email' => 'cborrow03@gmail.com', 'display_name' => 'Cory Borrow');*/
		
		if(isset($_SESSION['active_user'])) {
			$userId = $_SESSION['active_user'];
			$update = $_SESSION['login_update_time'];
			$now = time();

			if(($now - $update) > 600) {
				//Auto logout user.
			}
			else {
				$u = new UsersModel();
				$user = $u->getUserById($userId);
				self::$activeUser = $user;
				return true;
			}
		}
		//$this->redirect("/login.php");
	}

	public static function getCurrentUser() {
		return self::$activeUser;
	}

	public static function loginUser($username, $password) {
		$u = new UsersModel();
		$user = $u->getUserByUsername($username);

		if($user->password == md5($password)) {
			$_SESSION['active_user'] = $user->id;
			$_SESSION['login_update_time'] = time();
			self::$activeUser = $user;
			return true;
		}
		return false;
	}
}
?>