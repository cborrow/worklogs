<?php
if(!function_exists('get_status_by_id')) {
    function get_status_by_id($id) {
        $db = new SQLite3('Worklogs.db');
        $result = $db->query("SELECT * FROM status WHERE id='{$id}' LIMIT 1");
		
		if($result != null)
			return (object)$result->fetchArray();
		return (object)['id' => 0, 'name' => 'Unknown Status'];
    }
}
if(!function_exists('get_status_list')) {
    function get_status_list() {
        $db = new SQLite3('Worklogs.db');
        $result = $db->query("SELECT * FROM status ORDER BY id DESC");
        $rows = array();

        while($row = $result->fetchArray()) {
            $rows[] = (object)$row;
        }
        return $rows;
    }
}
if(!function_exists('get_status_by_name')) {
    function get_status_by_name($name) {
        $db = new SQLite3('Worklogs.db');
        $name = $db->escapeString($name);
        $result = $db->query("SELECT * FROM status WHERE name='{$name}' LIMIT 1");
        return (object)$result->fetchArray();
    }
}
if(!function_exists('status_add')) {
    function status_add($name) {
        $db = new SQLite3('Worklogs.db');
        $name = $db->escapeString($name);
        $db->query("INSERT INTO status (name) VALUES ('{$name}')");
    }
}
if(!function_exists('delete_status')) {
    function delete_status($id) {
        if($id <= 0 || !is_numeric($id))
            return;
            
        $db = new SQLite3('Worklogs.db');
        $db->query("DELETE FROM status WHERE id='{$id}'");
    }
}
if(!function_exists('get_status_color')) {
    function get_status_color($id) {
        if($id > 0 && is_numeric($id)) {
            $db = new SQLite3('Worklogs.db');
            $result = $db->query("SELECT color FROM status WHERE id='{$id}' LIMIT 1");
            $row = null;
		
			if($result != null)
				$row = $result->fetchArray();
            
            if($row != null && is_array($row) && isset($row['color']))
                return $row['color'];
        }
        return "#1abc9c";
    }
}
if(!function_exists('set_status_color')) {
    function set_status_color($id, $color) {
        $db = new SQLite3('Worklogs.db');
        $db->query("UPDATE status SET color='{$color}' WHERE id ='{$id}'");
    }
}
if(!function_exists('get_ordered_status_list')) {
    function get_ordered_status_list() {
        $db = new SQLite3('Worklogs.db');
        //$result = $db->orderBy('sort_priority', 'ASC')->select('status');
        $result = $db->query("SELECT * FROM status ORDER BY priority ASC");
        $rows = array();
        
        while($row = $result->fetchArray()) {
            $rows[] = (object)$row;
        }
        return $rows;
    }
}
if(!function_exists('get_status_with_priority')) {
    function get_status_with_priority($p) {
        $db = new SQLite3('Worklogs.db');
        //$result = $db->where('sort_priority', $p)->select('status');
        $result = $db->query("SELECT * FROM status WHERE priority='{$p}'");
        
        if($result != null)
            return (object)$result->fetchArray();
        return null;
    }
}
if(!function_exists('set_status_priority')) {
    function set_status_priority($status, $priority) {
        $db = new SQLite3('Worklogs.db');
        //$db->where('id', $status)->update('status', ['sort_priority' => $priority]);
        $db->query("UPDATE status SET priority='{$priority}' WHERE id='{$status}'");
    }
}
if(!function_exists('get_status_priority')) {
    function get_status_priority($status) {
        $db = new SQLite3('Worklogs.db');
        //$result = $db->where('id', $status)->select('status');
        $result = $db->query("SELECT * FROM status WHERE id='{$status}'");
		$row = null;
		
		if($result != null)
			$row = $result->fetchArray();

        if($row != null)
            return $row['priority'];
        return 0;
    }
}
if(!function_exists('get_status_count')) {
    function get_status_count() {
        $db = new SQLite3('Worklogs.db');
        $result = $db->query("SELECT COUNT(id) AS total FROM status");
        $row = null;
		
		if($result != null)
			$row = $result->fetchArray();

        if($row != null)
            return $row['total'];
        return 0;
    }
}
?>
