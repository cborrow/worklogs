<!doctype html>
<html>
<head>
	<title><?php echo "Work order # {$job->workorder}"; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('print.css'); ?>" />
</head>
<body>
	<h4>Client Name : <?php echo $job->client; ?></h4>
	<h4>Work Order : <?php echo $job->workorder; ?></h4>
	<h4>Notes</h4>
	<p><?php echo nl2br($job->notes); ?></p>
</body>
</html>