<?php
if(!function_exists('get_user_by_id')) {
    function get_user_by_id($id) {
        $db = new SQLite3('Worklogs.db');
        $result = $db->query("SELECT * FROM users WHERE id='{$id}' LIMIT 1");

        return (object)$result->fetchArray();
    }
}

if(!function_exists('get_active_user')) {
    function get_active_user() {
        if(isset($_SESSION['user_logged_in']) && isset($_SESSION['active_user_id'])) {
            $id = $_SESSION['active_user_id'];
            return get_user_by_id($id);
        }
        return null;
    }
}

if(!function_exists('user_login_check')) {
    function user_login_check() {
        $user = get_active_user();

        if($user == null && is_object($user))
            redirect('/auth/logout');
    }
}
?>
