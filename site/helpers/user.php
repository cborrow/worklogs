<?php
if(!function_exists('usernamefromid')) {
	function usernamefromid($id) {
		if(!is_numeric($id))
			return "Null";
		
		$db = Database::getInstance();
		$db->where('id', $id)->limit(1)->select('users');
		$row = $db->fetch();
		
		return $row->username;
	}
}
?>
