<!doctype html>
<html>
<head>
    <title><?=$title; ?> - WorkLogs</title>
    <link rel="stylesheet" type="text/css" media="screen" href="http://localhost/worklogs3/assets/print.css" />
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>Job #<?=$job->workorder; ?> for <?=$job->customer; ?></h1>
            <ul>
                <li>Created : <span class="right"><?=date("j M, Y h:i:s A", $job->created); ?></span></li>
                <li>Modified : <span class="right"><?=($job->modified == 0) ? 'Never' : date("j M, Y h:i:s A", $job->modified); ?></span></li>
                <li>Workorder : <span class="right"><?=$job->workorder; ?></span></li>
                <li>Customer : <span class="right"><?=$job->customer; ?></span></li>
                <li>Status : <span class="right"><?=get_status_by_id($job->status_id)->name; ?></span></li>
            </ul>
            <h4>Job Notes</h4>
            <p><?=nl2br($job->notes); ?></p>
        </div>
    </div>
</body>
</html>
