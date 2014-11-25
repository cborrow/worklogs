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
			<form action="<?php echo uri('jobs/search'); ?>" method="post">
			<p>
				<input type="text" name="query" placeholder="Type a query and press search....to..search. Duh!" />
				<input class="button" type="submit" name="submit" value="Search" />
			</p>
			</form>
			<p>
				<a class="button accept" href="<?php echo uri('/jobs/add'); ?>">Add Job</a>
			</p>
			<table cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<!--<td class="checkbox"><input type="checkbox" name="selected" /></td>-->
						<td class="checkbox">Status</td>
						<td class="workorder">Work Order</td>
						<td class="client">Client Name</td>
						<td class="notes">Notes</td>
						<td class="workorder">Commands</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($jobs as $job): ?>
					<tr>
						<td class="checkbox<?php echo " " . strtolower($job->status); ?>">&nbsp;</td>
						<td class="workorder"><?php echo $job->workorder; ?></td>
						<td class="client"><?php echo $job->client; ?></td>
						<td class="notes"><?php echo ellipse_string($job->notes, 150); ?></td>
						<td class="client"><a href="<?php echo uri('/jobs/view/' . $job->id); ?>">View</a> | <a href="<?php echo uri('/jobs/edit/' . $job->id); ?>">Edit</a> | <a href="<?php echo uri('/jobs/delete/' . $job->id); ?>">Delete</a>
							<?php if($job->status == "Open"): ?>
							| <a href="<?php echo uri('/jobs/complete/' . $job->id); ?>">Mark Complete</a>
							<?php endif; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>