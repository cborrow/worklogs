<?php
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    require_once "application/libraries/SQLiteDatabase.php";
    require_once "application/config/config.php";

    $db = new SQLiteDatabase('Worklogs.db');
    $db->query("SELECT color FROM status WHERE id='{$id}'");
    $row = $db->fetch();
    
    if($row != null)
        echo $row->color;
    else
        echo "#FFFFFF";
}
else
    echo "#FFFFFF";
?>
