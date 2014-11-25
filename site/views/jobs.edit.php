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
			<h4>Editing work log '<?php echo "{$job->client} ({$job->workorder})"; ?>'</h4>
			<p>When editing a note, please be detailed. <br />
				This notes are used in the future to help with a similar issue that may occur.</p>
			<form action="<?php echo uri('jobs/edit_process/' . $job->id); ?>" method="post">
			<p>
				<label>Status</label>
				<select name="status">
					<option<?php echo ($job->status == "Open") ? ' selected="selected"' : ''; ?>>Open</option>
					<option<?php echo ($job->status == "Closed") ? ' selected="selected"' : ''; ?>>Closed</option>
				</select>
			</p>
			<p>
				<label>Work Order Number</label>
				<input type="text" name="workorder" value="<?php echo $job->workorder; ?>" />
			</p>
			<p>
				<label>Client Name</label>
				<input type="text" name="client" value="<?php echo $job->client; ?>" />
			</p>
			<p>
				<label>Notes</label>
				<textarea name="notes"><?php echo $job->notes; ?></textarea>
			</p>
			<p class="buttons">
				<input class="button accept" type="submit" name="submit" value="Save" />
				<input class="button" type="submit" name="submit" value="Cancel" />
			</p>
			</form>
		</div>
	</div>
</body>
</html>
