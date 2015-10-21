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
            <?php if(count($pastDueJobs) > 0): ?>
            <h3 class="subdue">The following jobs have been open for more than 5 days and need attention.</h3>
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td>Customer Name</td>
                        <td>Created</td>
                        <td>Status</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($pastDueJobs as $pdj): ?>
                    <tr>
                        <td><?=$pdj->customer; ?></td>
                        <td><?=date("j M, Y h:i", $pdj->created); ?></td>
                        <td><?=get_status_by_id($pdj->status_id)->name; ?></td>
                        <td class="table_commands"><a href="<?=site_url('jobs/printjob/' . $pdj->id); ?>">Print</a> | <a href="<?=site_url('/jobs/edit/' . $pdj->id); ?>">Edit</a>
                            | <a href="<?=site_url('/jobs/delete/' . $pdj->id); ?>">Delete</a>
                            <?php if($pdj->status_id != 1): ?>| <a href="<?=site_url('/jobs/close/' . $pdj->id); ?>">Close</a></td><?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <h3 class="subdue">Average time to close a job</h3>
            <h2><?=$avg_days; ?><span class="subdue"> days</span> <?=$avg_hours; ?> <span class="subdue"> hours</span> <?=$avg_minutes; ?> <span class="subdue"> minutes and</span> <?=$avg_seconds; ?> <span class="subdue"> seconds</span></h2>
        </div>
    </div>
</body>
</html>
