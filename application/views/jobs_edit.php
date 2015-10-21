<!doctype html>
<html>
<head>
    <title><?=$title; ?> - WorkLogs</title>
    <link rel="stylesheet" type="text/css" media="screen" href="<?=asset('default.css'); ?>" />
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
            <p>
                <label>Work Order</label>
                <input type="text" name="workorder" value="<?=$job->workorder; ?>" />
            </p>
            <p>
                <label>Store</label>
                <select name="store">
                <?php foreach($stores as $s): ?>
                    <?php if($s->id == $job->store_id): ?>
                        <option value="<?=$s->id; ?>" selected><?=$s->name; ?></option>
                    <?php else: ?>
                        <option value="<?=$s->id; ?>"><?=$s->name; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Customer</label>
                <input type="text" name="customer" value="<?=$job->customer; ?>" />
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
</html>
