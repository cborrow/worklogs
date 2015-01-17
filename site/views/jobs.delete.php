<!doctype html>
<html>
<head>
    <title>Work Logs > Delete Job <?php echo $job->workorder; ?></title>
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
                <li class="purpleback"><a href="<?php echo uri('/jobs/view'); ?>"><img src="<?php echo asset('images/appbar.list.png'); ?>" title="Jobs" /></a></li>
                <li><a href="<?php echo uri('/users/view'); ?>"><img src="<?php echo asset('images/appbar.group.png'); ?>" title="Users" /></a></li>
                <li><a href="<?php echo uri('/inventory/view'); ?>"><img src="<?php echo asset('images/appbar.store.png'); ?>" title="Inventory" /></a></li>
                <li><a href="<?php echo uri('/settings'); ?>"><img src="<?php echo asset('images/appbar.cog.png'); ?>" title="Settings" /></a></li>
            </ul>
        </div>
        <div class="content">
            <div class="text_block"><span class="title purple">Removing job <?php echo $job->workorder; ?></span></div>
            <form action="<?php echo uri('/jobs/delete_process/' . $job->id); ?>" method="post">
            <p>
                Are you sure you wish to remove the following job.
            </p>
            <p>
                Client : <b><?php echo $job->client; ?></b><br />
                Work Order : <b><?php echo $job->workorder; ?></b><br />
            </p>
            <p>This action is undoable, if you understand click the 'Remove' below to continue.</p>
            <p class="buttons">
                <input class="button purpleback" type="submit" name="submit" value="Remove" />
                <input class="button" type="submit" name="cancel" value="Cancel" />
            </p>
            </form>
        </div>
    </div>
</body>
</html>