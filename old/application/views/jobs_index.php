<!doctype html>
<html>
<head>
    <title><?=$title; ?> - WorkLogs</title>
    <link rel="stylesheet" type="text/css" media="screen" href="<?=asset('default.css'); ?>" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
            <ul class="right-content block-list-small">
                <li><h4>Status Legend</h4></li>
                <?php foreach(get_ordered_status_list() as $status): ?>
                    <li style="border-left: <?=$status->color; ?> solid 8px;">
                        <?=$status->name; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!--<h3><?php
            include 'random_chuck.php';
            echo get_chuck_quote();
            ?></h3>-->
            <table class="small" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <td class="table_workorder">Workorder</td>
                        <td class="table_customer">Customer</td>
                        <td class="table_store">Store</td>
                        <td class="table_status">Status</td>
                        <td class="table_date">Created</td>
                        <td class="table_commands"></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($jobs as $job): ?>
                    <?php $sc = get_status_color($job->status_id); ?>
                    <tr>
                        <td class="table_workorder" style="border-left: <?=$sc; ?> solid 8px;"><?=$job->workorder; ?></td>
                        <td class="table_customer"><a href="<?=site_url('/jobs/edit/' . $job->id); ?>" title="<?=$job->phone; ?>"><?=$job->customer; ?></a>
                        <?=($job->has_power) ? '<i class="fa fa-bolt"></i>' : ''; ?>
                        <?=($job->has_case) ? '<i class="fa fa-briefcase"></i>' : ''; ?></td>
                        <td class="table_store"><?=get_store_by_id($job->store_id)->name; ?></td>
                        <td class="table_status" title="<?=$job->notes; ?>" job_id="<?=$job->id; ?>"><?=get_status_by_id($job->status_id)->name; ?></td>
                        <td class="table_date"><?=date("j M, Y", $job->created); ?></td>
                        <td class="table_commands"><a href="<?=site_url('jobs/printjob/' . $job->id); ?>">Print</a> | <a href="<?=site_url('/jobs/edit/' . $job->id); ?>">Edit</a>
                            | <a href="<?=site_url('/jobs/delete/' . $job->id); ?>">Delete</a>
                            <?php if($job->status_id != 1): ?>| <a href="<?=site_url('/jobs/close/' . $job->id); ?>">Close</a></td><?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="page-nav">
                <p>
                    <?php if($curPage > 1): ?>
                    <a href="<?=site_url('/jobs/page/' . ($curPage - 1)); ?>">Previous</a>
                    <?php endif; ?>
                    Page <?=$curPage; ?> of <?=$totalPages; ?>
                    <?php if($curPage < $totalPages): ?>
                    <a href="<?=site_url('/jobs/page/' . ($curPage + 1)); ?>">Next</a>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</body>
<script src="<?=asset('autoreload.js'); ?>"></script>
<script src="<?=asset('default.js'); ?>"></script>
</html>
