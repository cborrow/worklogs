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
            <form action="#" method="post">
            <p>
                <label>Work Order</label>
                <input type="text" name="workorder" placeholder="1234" />
            </p>
            <p>
                <label>Customer</label>
                <input type="text" name="customer" placeholder="Joe Schmo" />
            </p>
            <p>
                <label>Phone #</label>
                <input type="text" name="phone" placeholder="(757) 555-0123" />
            </p>
            <p>
                <label>Password</label>
                <input type="text" name="password" placeholder="Password123" />
            </p>
            <p>
                <label>Device Serial</label>
                <input type="text" name="serial" placeholder="ABC0123456789" />
            </p>
            <p>
                <label>Has Carrying Case</label>
                <input type="checkbox" name="has_case" />
            </p>
            <p>
                <label>Has Power Adapter</label>
                <input type="checkbox" name="has_power" />
            </p>
            <p>
                <label>Notes</label>
                <textarea name="notes" placeholder="Job notes"></textarea>
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
