<?php
class Users_model extends CI_Model {
    public function __construct() {
        parent::__construct();

        $this->load->library('SQLiteDatabase');
        $this->db = new SQLiteDatabase('Worklogs.db');
        $this->db->EnableDebugging = true;
    }

    public function getUserId($user) {
        $this->db->where('username', $user)->limit(1)->select('users');
        return $this->db->fetch()->id;
    }

    public function userExists($user) {
        $this->db->where('username', $user)->limit(1)->select('users');
        $row = $this->db->fetch();

        if($row != false && $row != null)
            return true;
        return false;
    }

    public function credentialsValid($user, $pass) {
        $this->db->where('username', $user)->limit(1)->select('users');
        $row = $this->db->fetch();

        if($row != false && $row != null) {
            if($row->username == $user && $row->password == $pass)
                return true;
        }
        return false;
    }

    public function updateLogin($id) {
        $t = time();
        $this->db->where('id', $id)->update('users', array('last_login' => $t));
    }

    public function add($data) {
        $this->db->insert('users', $data);
        return $this->db->lastInsertId();
    }
}
?>
