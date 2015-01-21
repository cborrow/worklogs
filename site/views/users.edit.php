<!doctype html>
<html>
<head>
    <title>Work Logs > All Jobs</title>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset('style.css'); ?>" />
</head>
<body>
    <div class="container">
        <div class="userinfo">
            <?php echo User::getCurrentUser()->display_name; ?>
            <a href="<?php echo uri('/users/logout'); ?>">Logout</a>
        </div>
        <div class="sidebar">
            <h3>Work Logs</h3>
            <ul class="nav_blocks">
                <li><a href="<?php echo uri('/jobs/dashboard'); ?>"><img src="<?php echo asset('images/appbar.graph.bar.png'); ?>" title="Dashboard" /></a></li>
                <li><a href="<?php echo uri('/jobs/view'); ?>"><img src="<?php echo asset('images/appbar.list.png'); ?>" title="Jobs" /></a></li>
                <li class="pinkback"><a href="<?php echo uri('/users/view'); ?>"><img src="<?php echo asset('images/appbar.group.png'); ?>" title="Users" /></a></li>
                <li><a href="<?php echo uri('/inventory/view'); ?>"><img src="<?php echo asset('images/appbar.store.png'); ?>" title="Inventory" /></a></li>
                <li><a href="<?php echo uri('/settings'); ?>"><img src="<?php echo asset('images/appbar.cog.png'); ?>" title="Settings" /></a></li>
            </ul>
        </div>
        <div class="content">
            <div class="text_block"><span class="title pink">All Users</span></div>
            <form action="<?php echo uri('/users/edit_process/' . $user->id); ?>" method="post">
            <p>
            	<label>User Level</label>
            	<input type="text" name="user_level" placeholder="User's Acces Level" value="<?php echo $user->user_level; ?>" />
            </p>
            <p>
            	<label>Display Name</label>
            	<input type="text" name="display_name" placeholder="Full Name Here" value="<?php echo $user->display_name; ?>" />
            </p>
            <p>
            	<label>Username</label>
            	<input type="text" name="username" placeholder="Login name" value="<?php echo $user->username; ?>" />
            </p>
            <p>
            	<label>Password</label>
            	<input type="password" name="password" placeholder="Leave blank to not change" />
            </p>
            <p>
            	<label>Email</label>
            	<input type="text" name="email" placeholder="user@yourdomain.com" value="<?php echo $user->email; ?>" />
            </p>
            <p class="buttons">
            	<input class="button pinkback" type="submit" name="submit" value="Save" />
            	<input class="button" type="submit" name="cancel" value="Cancel" />
            </p>
            </form>
        </div>
    </div>
</body>
</html>