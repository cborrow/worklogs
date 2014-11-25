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
			<h4>Create new work log</h4>
			<p>Enter your information below, a work order number from an already created work order out of quickbooks.<br />
				The name of the client, then any notes you wish to add. Update the notes while working on the clients<br />
				device.</p>
			<form action="<?php echo uri('jobs/add_process'); ?>" method="post">
			<p>
				<label>Work Order Number</label>
				<input type="text" name="workorder" placeholder="ex. 1234" />
			</p>
			<p>
				<label>Client Name</label>
				<input type="text" name="client" placeholder="ABC Company" />
			</p>
			<p>
				<label>Notes</label>
				<textarea name="notes"></textarea>
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
