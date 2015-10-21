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
                <li class="right"><a href="<?=site_url('/jobs/changestore'); ?>"><?=get_current_store()->name; ?></a></li>
            </ul>
        </div>
        <div class="header">
        </div>
        <div class="content">
            <h1><?=$title; ?></h1>
            <form action="#" method="post">
            <p>
                Are you sure you wish to delete this job? This action cannot be undone.
            </p>
            <p>
                <label>Yes really delete</label>
                <input type="checkbox" name="delete" value="yes" />
            </p>
            <p>
                <input type="submit" name="cancel" value="Cancel" />
                <input class="delete" type="submit" name="submit" value="Delete" />
            </p>
            </form>
        </div>
    </div>
</body>
</html>
