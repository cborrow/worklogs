<!doctype html>
<html>
<head>
    <title><?=$title; ?> - WorkLogs</title>
    <link rel="stylesheet" type="text/css" media="screen" href="http://localhost/worklogs3/assets/default.css" />
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
            <form action="<?=site_url('/settings/save'); ?>" method="post">
            <p>
                <label>Statuses</label><br />
                <input type="text" name="status" placeholder="Status name" />
                <input type="submit" name="addstatus" value="Add Status" />
            </p>
            <ul class="block-list">
                <?php foreach(get_status_list() as $status): ?>
                <li><?=$status->name; ?>
                    <?php if($status->id >= 3): ?>
                        <span class="right"><a href="<?=site_url('/settings/deletestatus/' . $status->id); ?>">Delete</a></span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <br />
            <p>
                <label>Stores</label><br />
                <input type="text" name="store" placeholder="Store name" />
                <input type="submit" name="addstore" value="Add Store" />
            </p>
            <ul class="block-list">
                <?php foreach(get_store_list() as $store): ?>
                <li><?=$store->name; ?>
                    <?php if(count(get_store_list()) > 1): ?>
                        <span class="right"><a href="<?=site_url('/settings/deletestore/' . $store->id); ?>">Delete</a></span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </form>
        </div>
    </div>
</body>
</html>
