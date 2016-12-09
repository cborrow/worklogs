<!doctype html>
<html>
<head>
    <title><?=$title; ?> - WorkLogs</title>
    <link rel="stylesheet" type="text/css" media="screen" href="http://mail.nationalpcpro.com/worklogs/assets/default.css" />
</head>
<body>
    <div class="container">
        <div class="nav-bar">
            <ul class="nav-list">
                <li><a href="<?=site_url('/dashboard/index'); ?>">Dashboard</a></li>
                <li><a href="<?=site_url('/jobs/index'); ?>">Jobs</a></li>
                <li><a href="<?=site_url('/jobs/add'); ?>">Add Job</a></li>
                <li><form action="<?=site_url('/jobs/search'); ?>" method="post"><input type="text" name="query" placeholder="Search jobs" /></form></li>
                <li class="right"><a href="<?=site_url('/auth/logout'); ?>">Logout</a></li>
                <li class="right"><a href="<?=site_url('/settings'); ?>">Settings</a></li>
                <li class="right"><a href="<?=site_url('/jobs/changestore'); ?>"><?=get_current_store()->name; ?></a></li>
            </ul>
        </div>
        <div class="header">
        </div>
        <div class="content">
            <h1><?=$title; ?></h1>
            <form action="<?=site_url('/jobs/edit/' . $job->id); ?>" method="post">
			<!--<form id="job-form" action="#" method="post">-->
            <h3 class="subdue_red">Last Modified at <?=($job->modified > 0) ? date("j M, Y h:i a", $job->modified) . " by " . $job->modified_by : require 'random_chuck.php'; ?></h3>
			<p>
				<span class="subdue_red" id="errors"></span>
			</p>
            <p>
                <label>Work Order</label>
                <input type="text" name="workorder" value="<?=$job->workorder; ?>" />
            </p>
            <!--<p>
                <label>Store</label>
                <!--<select name="store">
                <?php foreach($stores as $s): ?>
                    <?php if($s->id == $job->store_id): ?>
                        <option value="<?=$s->id; ?>" selected><?=$s->name; ?></option>
                    <?php else: ?>
                        <option value="<?=$s->id; ?>"><?=$s->name; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
                </select>
            </p>-->
			<input type="hidden" name="store" value="2" />
            <p>
                <label>Customer</label>
                <input type="text" name="customer" value="<?=$job->customer; ?>" />
            </p>
            <p>
                <label>Phone #</label>
                <input type="text" name="phone" value="<?=$job->phone; ?>" />
            </p>
            <p>
                <label>Password</label>
                <input type="text" name="password" placeholder="Password123" value="<?=$job->password; ?>" />
            </p>
            <p>
                <label>Status</label>
                <select name="status">
                    <?php foreach($status as $s): ?>
                        <?php if($s->id == $job->status_id): ?>
                            <option value="<?=$s->id; ?>" selected><?=$s->name; ?></option>
                        <?php else: ?>
                            <option value="<?=$s->id; ?>"><?=$s->name; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Device Serial</label>
                <input type="text" name="serial" value="<?=$job->serial; ?>" />
            </p>
            <p>
                <label>Has Carrying Case</label>
                <input type="checkbox" name="has_case" <?=($job->has_case == 1) ? 'checked' : ''; ?> />
            </p>
            <p>
                <label>Has Power Adapter</label>
                <input type="checkbox" name="has_power" <?=($job->has_power == 1) ? 'checked' : ''; ?> />
            </p>
            <p>
                <label>Notes</label>
                <textarea name="notes"><?=$job->notes; ?></textarea>
            </p>
            <p class="buttons">
                <input class="accept" type="submit" name="submit" value="Save" />
                <input type="submit" name="cancel" value="Cancel" />
            </p>
            </form>
        </div>
    </div>
</body>
<!--<script type="text/javascript" src="http://worklogs.nationalpcpro.com/assets/forms.js"></script>-->
</html>
