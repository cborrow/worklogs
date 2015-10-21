<?php
if(!function_exists('get_status_by_id')) {
    function get_status_by_id($id) {
        $db = new SQLite3('Worklogs.db');
        $result = $db->query("SELECT * FROM status WHERE id='{$id}' LIMIT 1");
        return (object)$result->fetchArray();
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
?>
