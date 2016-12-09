<?php
$db = new SQLite3('Worklogs.db');

$sql1 = @"CREATE TABLE status (";
$sql1 .= "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,";
$sql1 .= "name VARCHAR(50) NOT NULL)";

$sql2 = "CREATE TABLE stores (";
$sql2 .= "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,";
$sql2 .= "created INT NOT NULL,";
$sql2 .= "name VARCHAR(50) NOT NULL)";

$sql3 = "CREATE TABLE users (";
$sql3 .= "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,";
$sql3 .= "created INT NOT NULL,";
$sql3 .= "last_login INT NOT NULL,";
$sql3 .= "username VARCHAR(30) NOT NULL,";
$sql3 .= "password VARCHAR(100) NOT NULL,";
$sql3 .= "email VARCHAR(125) NOT NULL)";

$sql4 = "CREATE TABLE jobs (";
$sql4 .= "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,";
$sql4 .= "created INT NOT NULL,";
$sql4 .= "modified INT NOT NULL,";
$sql4 .= "store_id INT NOT NULL,";
$sql4 .= "user_id INT NOT NULL,";
$sql4 .= "status_id INT NOT NULL,";
$sql4 .= "workorder VARCHAR(20) NOT NULL,";
$sql4 .= "serial VARCHAR(50) NOT NULL,";
$sql4 .= "customer VARCHAR(50) NOT NULL,";
$sql4 .= "notes TEXT NOT NULL)";

$sql5 = "INSERT INTO users (created, last_login, username, password, email) VALUES ('UNIX_TIMESTAMP()', 'UNIX_TIMESTAMP()', 'admin', 'SHA1(toor)', 'support@npcpro.com');";

echo "Starting creation of tables...<br />";
echo "Creating table status...<br />";
$db->query($sql1);

echo "Creating table stores...<br />";
$db->query($sql2);

echp "Creating table users...<br />";
$db->query($sql3);

echo "Creating table jobs...<br />";
$db->query($sql4);

echo "Creating inital user and rows...<br />";
$db->query($sql5);
?>
