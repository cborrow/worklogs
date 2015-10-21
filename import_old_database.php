<?php
require_once "SQLiteDatabase.php";
require_once "Database.php";

$sqlite = new SQLiteDatabase('Worklogs.db');
$olddb = new Database('localhost', 'root', 'S3cur1ty', 'worklogs');

echo "Starting import of data from old MySQL database to new SQLite database...<br />";
echo "Fetching data from old db...<br />";

$olddb->query("SELECT * FROM jobs ORDER BY id ASC");
$rows = $olddb->fetchAll();
$newrows = array();
$rowCount = 0;

echo "Importing data to new db...<br />";

foreach($rows as $row) {
    $newrow = array();
    $newrow['workorder'] = $row->workorder;
    $newrow['customer'] = $row->client;
    $newrow['created'] = $row->created;
    $newrow['modified'] = $row->modified;
    $newrow['status_id'] = ($row->status == 'Closed') ? 1 : 2;
    $newrow['user_id'] = 1;
    $newrow['store_id'] = 1;
    $newrow['serial'] = $row->serial;
    $newrow['notes'] = $row->notes;

    $sqlite->insert('jobs', $newrow);

    if($sqlite->LastErrorCode != 0) {
        echo "Error importing record {$row->id}<br />";
        echo "Message : {$sqlite->LastErrorString}<br /><br />";
    }
    else
        $rowCount++;
}

echo "Succesfully imported {$rowCount} of ". count($rows) . " rows<br />";
echo "If any errors were reported, the data for those rows may need to be manually imported.";
?>