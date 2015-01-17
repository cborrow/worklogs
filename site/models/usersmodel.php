<?php
class UsersModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		if(!is_array($data))
			throw new Exception("Invalid argument given.");

		$data['created'] = time();
		$data['last_login'] = time();
		$data['user_level'] = 1;

		$this->db->insert('users', $data);
	}

	public function edit($id, $data) {
		if(!is_array($data))
			throw new Exception("Invalid argument given.");

		$this->db->where('id', $id)->update('users', $data);
	}

	public function delete($id) {
		$this->db->where('id', $id)->delete('users');
	}

	public function getAllUsers() {
		$user = User::getCurrentUser();

		/*if($user == null)
			return null;
		if($user->user_level != 10)
			return null;*/

		$this->db->orderBy('id')->select('users');
		return $this->db->fetchAll();
	}

	public function getUserById($id) {
		if($id == null || !is_numeric($id))
			throw new Exception("Invalid argument given.");

		$this->db->where('id', $id)->limit(1)->select('users');
		return $this->db->fetch();
	}

	public function getUserByUsername($username) {
		if($username == null)
			throw new Exception("Null argument given.");

		$this->db->where('username', $username)->limit(1)->select('users');
		return $this->db->fetch();
	}

	public function getUserByName($displayName) {
		if($displayName == null)
			throw new Exception("Null argument given.");

		$this->db->where('display_name', $displayName)->limit(1)->select('users');
		return $this->db->fetch();
	}
}
?>
