<!doctype html>
<html>
<head>
    <title>Work Logs</title>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset('style.css'); ?>" />
</head>
<body>
    <div class="container">
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
            <div class="text_block"><span class="title purple">Closed Jobs</span><a href="<?php echo uri('/jobs/view'); ?>"><img src="<?php echo asset('images/appbar.sort.png'); ?>" /></a></div>
            <div>
                <a href="<?php echo uri('/jobs/add'); ?>" class="button">Add a new job</a>
            </div>
            <form class="searchbox" action="<?php echo uri('/jobs/search'); ?>" method="post">
            <p>
                <input type="text" name="q" placeholder="Search Jobs" />
            </p>
            </form>
            <div class="jobs">
            <?php foreach($jobs as $job): ?>
                <div class="job <?php echo strtolower($job->status); ?>">
                    <h5 class="purple"><?php echo $job->client; ?> - Work Order # <?php echo $job->workorder; ?></h5>
                    <p><?php echo ellipse_string($job->notes, 150); ?></p>
                    <ul class="job_actions">
                        <li><a href="<?php echo uri('/jobs/print/' . $job->id); ?>"><img src="<?php echo asset('images/appbar.printer.text.png'); ?>" /></a></li>
                        <li><a href="<?php echo uri('/jobs/edit/' . $job->id); ?>"><img src="<?php echo asset('images/appbar.edit.png'); ?>" /></a></li>
                        <li><a href="<?php echo uri('/jobs/delete/' . $job->id); ?>"><img src="<?php echo asset('images/appbar.delete.png'); ?>" /></a></li>
                        <?php if(strtolower($job->status) == "open"): ?>
                        <li><a href="<?php echo uri('/jobs/complete/' . $job->id); ?>"><img src="<?php echo asset('images/appbar.checkmark.png'); ?>" /></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>