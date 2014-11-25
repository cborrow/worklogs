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
			<h4>Are you sute you wish to delete the job '<?php echo "{$job->client} ({$job->workorder})"; ?></h4>
			<form action="<?php echo uri('/jobs/delete_process/' . $job->id); ?>" method="post">
			<p class="buttons">
				<input class="button cancel" type="submit" name="submit" value="Delete" />
				<input class="button" type="submit" name="cancel" value="Cancel" />
			</p>
			</form>
		</div>
	</div>
</body>
</html>
