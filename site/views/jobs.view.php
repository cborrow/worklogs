<!doctype html>
<html>
<head>
    <title>Work Logs > Viewing Job <?php echo $job->workorder; ?></title>
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
            <div class="text_block"><span class="title purple">Viewing job <?php echo $job->workorder; ?></span></div>
            <p><a href="<?php echo uri('/jobs/view'); ?>">Back to all jobs</a> | <a href="<?php echo uri('/jobs/edit/' . $job->id); ?>">Edit</a> | <a href="<?php echo uri('/jobs/delete/' . $job->id); ?>">Delete</a></p>
            <p>&nbsp;</p>
            <p><span class="blue">Client name</span> : <?php echo $job->client; ?></p>
            <p><span class="blue">Workorder</span> # : <?php echo $job->workorder; ?></p>
            <p><span class="blue">Created on</span> : <?php echo date("j M, Y", $job->created); ?></p>
            <p><span class="blue">Last Modified</span> : <?php echo date("j M, Y", $job->created); ?></p>
            <p><span class="blue">Device Serial</span> : <?php echo $job->serial; ?></p>
            <p>&nbsp;</p>
            <p><span class="blue">Notes</span> :</p>
            <p><?php echo nl2br($job->notes); ?></p>
        </div>
    </div>
</body>
</html>