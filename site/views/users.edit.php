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
			<h4>Editing user <?php echo $user->display_name; ?></h4>
			<p>Please ensure that all fields are properly filled out.</p>
			<form action="<?php echo uri('users/edit_process/' . $user->id); ?>" method="post">
			<?php if(isset($error) && $error != null): ?>
			<p class="button cancel">
				<?php if($error == "nomatch"): ?>
				The passwords you entered did not match, please try again.
				<?php endif; ?>
			</p>
			<?php endif; ?>
			<p>
				<label>Username</label>
				<input type="text" name="username" value="<?php echo $user->username; ?>" />
			</p>
			<p>
				<label>Password</label>
				<input type="password" name="password" placeholder="Please enter a strong password. (Leave blank to not change.)" />
			</p>
			<p>
				<label>Confirm Password</label>
				<input type="password" name="cpassword" placeholder="Confirm what should be a strong password." />
			</p>
			<p>
				<label>Display Name</label>
				<input type="text" name="display_name" value="<?php echo $user->display_name; ?>" />
			</p>
			<p>
				<label>Email Address</label>
				<input type="text" name="email" value="<?php echo $user->email; ?>" />
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
