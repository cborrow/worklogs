<?php
require_once "../old/application/libraries/SQLiteDatabase.php";

$db = new SQLiteDatabase('../old/Worklogs.db');
$newDb = new SQLiteDatabase('../database/database.sqlite');

$result = $db->query('SELECT * FROM jobs ORDER BY id ASC');
echo "Starting conversion...<br />";

while($row = $result->fetchArray()) {
	$row = (object)$row;
	$data = [
		'status_id' => $row->status_id,
		'phone' => $row->phone,
		'customer' => $row->customer,
		'device' => $row->serial,
		'notes' => $row->notes,
		'workorder' => $row->workorder,
		'password' => $row->password,
		'has_carrying_case' => $row->has_carrying_case,
		'has_power_adapter' => $row->has_power_adapter,
		'created_at' => date("Y-m-d H:I:S", $row->created),
		'updated_at' => date("Y-m-d H:I:S", $row->modified)
	];
	
	$newDb->insert('jobs', $data);
}

echo "Finished";
?>