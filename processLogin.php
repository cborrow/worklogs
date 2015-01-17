<?php
session_start();

require_once "./core/config.php";
require_once "./siteconfig.php";
require_once "./site/helpers/uri.php";
require_once "./core/database.php";
require_once "./core/user.php";

if(isset($_POST['submit'])) {
    $name = $_POST['username'];
    $pass = $_POST['password'];
    $db = Database::getInstance();

    $db->where('display_name', $name)->limit(1)->select('users');
    $userObj = $db->fetch();
    $user = $userObj->username;

    if(md5($pass) == $userObj->password) {
        $_SESSION['active_user'] = $userObj->id;
        $_SESSION['login_update_time'] = time();

        $uri = uri('/jobs/view');
        header("Location: {$uri}");
    }
    else {
        header("Location: login.php?error=1");
    }
}
?>