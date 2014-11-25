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
			<h6>There are currently <?php echo count($jobs); ?> jobs in the database.</h6>
			<h6><?php echo $openJobsCount; ?> jobs are currently open.</h6>
			<h6><?php echo $recentlyAddedCount; ?> jobs have been added in the past 10 days.</h6>
			<h6><?php echo $recentlyModifiedCount; ?> jobs have been modified in the past 10 days.</h6>
			<ul class="list-small">
				<b>10 Latest jobs</b>
				<?php $count = (count($jobs) < 10) ? count($jobs) : 10; ?>
				<?php for($i = 0; $i < $count; $i++): ?>
				<?php $job = $jobs[$i]; ?>
				<li><?php echo "{$job->client} ({$job->workorder})"; ?> | <a href="<?php echo uri('/jobs/edit/' . $job->id); ?>">Edit</a></li>
				<?php endfor; ?>
			</ul>
			<ul class="list-small">
				<b>Recently modified jobs</b>
				<?php foreach($recentlyModified as $rm): ?>
				<li><?php echo "{$rm->client} ({$rm->workorder}) at " . date("j M, Y h:i:s a", $rm->modified); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</body>
</html>
