<?php session_start(); ?>
<?php
require_once "core/config.php";
require_once "siteconfig.php";
require_once "site/helpers/uri.php";
?>
<!doctype html>
<html>
<head>
	<title>WorkLogs - Login</title>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset('main.css'); ?>" />
</head>
<body>
	<div class="login">
		<h4>WorkLogs Login</h4>
		<p>This site requires that you login before you can be given access. If you do not have a login, you may contact your system admin to request one.</p>
		<?php if(isset($_GET['error'])): ?>
			<?php
				$error = $_GET['error'];

				if($error == 1): ?>
			<p class="cancel">The username and / or password you used was incorrect, please try again or contact your system admin.</p>
			<?php endif; ?>
		<?php endif; ?>
		<form action="<?php echo uri('users/processLogin'); ?>" method="post">
		<p>
			<label>Username</label>
			<input type="text" name="username" placeholder="Your username" />
		</p>
		<p>
			<label>Password</label>
			<input type="password" name="password" placeholder="Your password" />
		</p>
		<p class="buttons">
			<input class="button" type="submit" name="submit" value="Login" />
		</p>
		</form>
	</div>
</body>
</html>
