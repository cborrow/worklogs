<?php
if(!function_exists('get_store_by_id')) {
    function get_store_by_id($id) {
        $db = new SQLite3('Worklogs.db');
        $result = $db->query("SELECT * FROM stores WHERE id='{$id}' LIMIT 1");
		
		if($result != null)
			return (object)$result->fetchArray();
		return (object)['id' => 0, 'name' => 'All Stores'];
    }
}
if(!function_exists('get_store_list')) {
    function get_store_list() {
        $db = new SQLite3('Worklogs.db');
        $result = $db->query("SELECT * FROM stores ORDER BY id DESC");
        $rows = array();

        while($row = $result->fetchArray()) {
            $rows[] = (object)$row;
        }
        return $rows;
    }
}
if(!function_exists('get_current_store')) {
    function get_current_store() {
        if(isset($_SESSION['active_store_id'])) {
            $id = $_SESSION['active_store_id'];

            if($id > 0)
                return get_store_by_id($id);
            return (object)array('id' => 0, 'name' => 'All Stores');
        }
        return get_store_by_id(1);
    }
}
if(!function_exists('set_current_store')) {
    function set_current_store($id) {
        if(!is_numeric($id))
            return;

        $db = new SQLite3('Worklogs.db');
        $result = $db->query("SELECT * FROM stores WHERE id='{$id}'");

        if($result != false)
            $_SESSION['active_store_id'] = $id;
    }
}
if(!function_exists('store_add')) {
    function store_add($name) {
        $db = new SQLite3('Worklogs.db');
        $name = $db->escapeString($name);
        $time = time();
        $db->query("INSERT INTO stores (created, name) VALUES ('{$time}', '{$name}')");
    }
}
if(!function_exists('delete_store')) {
    function delete_store($id) {
        $db = new SQLite3('Worklogs.db');
        $db->query("DELETE FROM stores WHERE id='{$id}'");
    }
}
?>
