<?php
class Users extends AuthController {
	protected $users;

	public function __construct() {
		parent::__construct();

		$this->users = new UsersModel();

		View::addHelper('uri');
		View::addHelper('user');
	}

	public function index() {

	}

	public function add($error = null) {
		$data = array();
		$data['error'] = $error;

		View::render('users.add', $data);
	}

	public function add_process() {
		if(isset($_POST['submit'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$confirm = $_POST['cpassword'];
			$email = $_POST['email'];
			$display = $_POST['display_name'];

			if($password != $confirm) {
				$this->redirect('/users/add/nomatch');
			}

			$data = array();
			$data['username'] = $username;
			$data['password'] = $password;
			$data['email'] = $email;
			$data['display_name'] = $display;
			$data['user_level'] = intval($_POST['user_level']);

			$this->users->add($data);
		}
		$this->redirect('/users/view', true);
	}

	public function edit($id = null) {
		if(is_null($id) || empty($id) || !is_numeric($id))
			$this->redirect('users/view', true);

		$data = array();
		$data['user'] = $this->users->getUserById($id);
		View::render('users.edit', $data);
	}

	public function edit_process($id = null) {
		if(is_null($id) || empty($id) || !is_numeric($id))
			$this->redirect('users/view', true);

		if(isset($_POST['submit']) && $_POST['submit'] == 'Save') {
			$data = array();
			$data['username'] = $_POST['username'];
			$data['email'] = $_POST['email'];
			$data['display_name'] = $_POST['display_name'];

			if(isset($_POST['password']) && strlen($_POST['password']) >= 5)
				$data['password'] = $_POST['password'];

			$this->users->edit($id, $data);
		}
		$this->redirect('users/view', true);
	}

	public function delete($id = null) {
		if(is_null($id) || empty($id) || !is_numeric($id))
			$this->redirect('users/view', true);

		$data = array();
		$data['user'] = $this->users->getUserById($id);
		View::render('users.delete', $data);
	}

	public function delete_process($id = null) {
		if(is_null($id) || empty($id) || !is_numeric($id))
			$this->redirect('users/view', true);

		if(isset($_POST['submit']) && $_POST['submit'] == "Delete") {
			$this->users->delete($id);
		}
		$this->redirect('users/view', true);
	}

	public function view($id = null) {
		if($id = null || !is_numeric($id)) {
			$data['users'] = $this->users->getAllUsers();
			View::render('users.viewall', $data);
		}
		else {
			$data['user'] = $this->users->getUserById($id);
			View::render('users.view', $data);
		}
	}

	public function login_process() {
		if(isset($_POST['submit'])) {
			$name = $_POST['username'];
			$pass = $_POST['password'];

			var_dump($_POST);

			$userObj = User::getUserFromName($name);
			$user = $userObj->username;

			/*if(User::loginUser($user, $pass)) {
				$this->redirect('/jobs/view', true);
			}
			else {
				$this->redirect('login.php?error=1', false);
			}*/
		}
	}

	public function logout() {
		$_SESSION = array();
		session_destroy();

		$this->redirect('login.php', false);
	}
}
?>
