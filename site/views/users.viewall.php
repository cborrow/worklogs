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
			<!--<form action="<?php echo uri('jobs/search'); ?>" method="post">
			<p>
				<input type="text" name="query" placeholder="Type a query and press search....to..search. Duh!" />
				<input class="button" type="submit" name="submit" value="Search" />
			</p>
			</form>-->
			<p>
				<a class="button accept" href="<?php echo uri('/users/add'); ?>">Add User</a>
			</p>
			<table cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td class="checkbox">User Level</td>
						<td class="workorder">Username</td>
						<td class="client">Display Name</td>
						<td class="notes">Email Address</td>
						<td class="workorder">Commands</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($users as $u): ?>
					<tr>
						<td class="checkbox"><?php echo $u->user_level; ?></td>
						<td class="workorder"><?php echo $u->username; ?></td>
						<td class="client"><?php echo $u->display_name; ?></td>
						<td class="notes"><?php echo $u->email; ?></td>
						<td class="client"><a href="<?php echo uri('/users/edit/' . $u->id); ?>">Edit</a> | <a href="<?php echo uri('/users/delete/' . $u->id); ?>">Delete</a>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
