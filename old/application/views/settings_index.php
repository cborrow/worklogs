<!doctype html>
<html>
<head>
    <title><?=$title; ?> - WorkLogs</title>
    <link rel="stylesheet" type="text/css" media="screen" href="<?=asset('default.css'); ?>" />
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
            <form action="<?=site_url('/settings/save'); ?>" method="post">
            <p>
                <label>Statuses</label><br />
                <input type="text" name="status" placeholder="Status name" />
                <input type="submit" name="addstatus" value="Add Status" />
            </p>
            <ul class="block-list">
                <?php foreach(get_status_list() as $status): ?>
                <li><?=(strlen($status->name) > 55) ? substr($status->name, 0, 52) . "..." : $status->name; ?>
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
            <p>
                <label>Set Status Color</label><br />
                <select id="status_name" class="small_input" name="status_name">
                    <option selected>Please select a status</option>
                    <?php foreach(get_status_list() as $status): ?>
                        <option value="<?=$status->id; ?>"><?=$status->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <input class="small_text" id="status_color" type="text" name="status_color" />
            </p>
            <p>
                <br /><label>Job Listing Sort Order</label><br />
                <ul class="block-list">
                    <?php foreach(get_ordered_status_list() as $status): ?>
                        <li><?=substr($status->name, 0, 40); ?> <span class="right">
                        <?php if($status->priority > 0): ?>
                            <a href="<?=site_url('/settings/raisepriority/' . $status->id); ?>">Move Up</a>
                        <?php endif; ?>
                        <?php if($status->priority < count(get_status_list()) - 1): ?>
                            <a href="<?=site_url('/settings/lowerpriority/' . $status->id); ?>">Move Down</a>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </p>
            <p class="small_buttons">
                <input type="submit" name="submit" value="Save" />
            </p>
        </form>
        </div>
    </div>
</body>
<script src="<?=asset('default.js'); ?>"></script>
</html>
