<!doctype html>
<html>
<head>
    <title>Work Logs > Add New Job</title>
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
            <div class="text_block"><span class="title purple">Adding a new job</span></div>
            <form action="<?php echo uri('/jobs/add_process'); ?>" method="post">
            <p>
                <label>Client Name</label>
                <input type="text" name="client" placeholder="John Doe" />
            </p>
            <p>
                <label>Work Order</label>
                <input type="text" name="workorder" placeholder="1234" />
            </p>
            <p>
                <label>Device Serial</label>
                <input type="text" name="serial" placeholder="0123456789ABCDEF" />
            </p>
            <p>
                <label>Notes</label>
                <textarea name="notes" placeholder="Work notes"></textarea>
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