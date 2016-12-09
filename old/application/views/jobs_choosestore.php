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
            <h2><span class="subdue">Current Active Store</span> : <?=get_current_store()->name; ?></h2>
            <h3 class="subdue">Please select a store from the list below to set as the active store.</h3>
            <ul>
                <li><a href="<?=site_url('/jobs/changestore/0'); ?>">All Stores</a></li>
                <?php foreach(get_store_list() as $store): ?>
                <li><a href="<?=site_url('/jobs/changestore/' . $store->id); ?>"><?=$store->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
