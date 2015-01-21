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
            <div>
                <a href="<?php echo uri('/users/add'); ?>" class="button">Add a new user</a>
            </div>
            <form class="searchbox" action="<?php echo uri('/jobs/search'); ?>" method="post">
            <p>
                <input type="text" name="q" placeholder="Search Users" />
            </p>
            </form>
            <div class="jobs">
            <?php foreach($users as $user): ?>
                <div class="job <?php echo strtolower($job->status); ?>">
                    <h5 class="pink"><?php echo $user->display_name; ?></h5>
                    <p>
                    	Username : <?php echo $user->username; ?><br />
                    	Email : <?php echo $user->email; ?><br />
                    	Level : <?php echo $user->user_level; ?>
                    	<?php if ($user->user_level == 10):?>
                    		<a href="<?php echo uri('/users/demote/' . $user->id); ?>">Demote User</a>
                    	<?php endif; ?>
                    </p>
                    <ul class="job_actions">
                        <li><a href="<?php echo uri('/users/edit/' . $user->id); ?>"><img src="<?php echo asset('images/appbar.edit.png'); ?>" /></a></li>
                        <li><a href="<?php echo uri('/users/delete/' . $user->id); ?>"><img src="<?php echo asset('images/appbar.delete.png'); ?>" /></a></li>
                        <li><a href="<?php echo uri('/users/reset/' . $user->id); ?>"><img src="<?php echo asset('images/appbar.checkmark.png'); ?>" /></a></li>
                    </ul>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>