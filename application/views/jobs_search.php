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
            <table cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <td class="table_workorder">Workorder</td>
                        <td class="table_customer">Customer</td>
                        <td class="table_status">Store</td>
                        <td class="table_status">Status</td>
                        <td class="table_date">Created</td>
                        <td class="table_commands"></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($jobs as $job): ?>
                    <tr class="<?=($job->status_id == 1) ? 'table_closed' : 'table_open'; ?>">
                        <td class="table_workorder"><?=$job->workorder; ?></td>
                        <td class="table_customer"><?=$job->customer; ?></td>
                        <td class="table_status"><?=get_store_by_id($job->store_id)->name; ?></td>
                        <td class="table_status"><?=get_status_by_id($job->status_id)->name; ?></td>
                        <td class="table_date"><?=date("j M, Y", $job->created); ?></td>
                        <td class="table_commands"><a href="<?=site_url('jobs/printjob/' . $job->id); ?>">Print</a> | <a href="<?=site_url('/jobs/edit/' . $job->id); ?>">Edit</a>
                            | <a href="<?=site_url('/jobs/delete/' . $job->id); ?>">Delete</a>
                            <?php if($job->status_id != 1): ?>| <a href="<?=site_url('/jobs/close/' . $job->id); ?>">Close</a></td><?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
