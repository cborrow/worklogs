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
            <div class="text_block"><span class="title purple">Editing job <?php echo $job->workorder; ?></span></div>
            <form action="<?php echo uri('/jobs/edit_process/' . $job->id); ?>" method="post">
            <p>
                <label>Status</label>
                <select name="status">
                    <option<?php echo ($job->status == "Open") ? ' selected="selected"' : ''; ?>>Open</option>
                    <option<?php echo ($job->status == "Closed") ? ' selected="selected"' : ''; ?>>Closed</option>
                </select>
            </p>
            <p>
                <label>Client Name</label>
                <input type="text" name="client" placeholder="John Doe" value="<?php echo $job->client; ?>" />
            </p>
            <p>
                <label>Work Order</label>
                <input type="text" name="workorder" placeholder="1234" value="<?php echo $job->workorder; ?>" />
            </p>
            <p>
                <label>Device Serial</label>
                <input type="text" name="serial" placeholder="0123456789ABCDEF" value="<?php echo $job->serial; ?>" />
            </p>
            <p>
                <label>Notes</label>
                <textarea name="notes" placeholder="Work notes"><?php echo $job->notes; ?></textarea>
            </p>
            <p class="buttons">
                <input class="button purpleback" type="submit" name="submit" value="Save" />
                <input class="button" type="submit" name="cancel" value="Cancel" />
            </p>
            </form>
        </div>
    </div>
</body>
</html>