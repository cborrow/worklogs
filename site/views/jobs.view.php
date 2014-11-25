<!doctype html>
<html>
<head>
	<title>Work Logs</title>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset('main.css'); ?>" />
</head>
<body>
	<div class="container">
		<?php View::render('global.menu'); ?>
		<div class="content">
			<h4>View job '<?php echo "{$job->client} ({$job->workorder})"; ?>'</h4>
			<p>Created by : <?php echo usernamefromid($job->user_id); ?></p>
			<p>Client name : <?php echo $job->client; ?></p>
			<p>Work order : <?php echo $job->workorder; ?></p>
			<p>Job Created : <?php echo date("j M, Y h:i:s a", $job->created); ?></p>
			<p>Job Modified : <?php echo ($job->modified > 0) ? date("j M, Y h:i:s a", $job->modified) : "Never"; ?></p>
			<p>&nbsp;</p>
			<p><?php echo nl2br($job->notes); ?></p>
		</div>
	</div>
</body>
</html>
