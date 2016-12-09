<?php

require_once "C:/inetpub/ftproot/worklogs/application/libraries/SQLiteDatabase.php";

$db = new SQLiteDatabase('Worklogs.db');

var_dump($db->where('store_id', 2)->range('jobs', 30, 5));
?>
