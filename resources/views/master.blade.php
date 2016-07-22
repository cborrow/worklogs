<!doctype html>
<html>
<head>
    <title>Notes</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" media="screen" href="<?=asset('/css/main.css'); ?>" />
    <script src="https://use.fontawesome.com/c584962945.js"></script>
    <script   src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
    <script src="<?=asset('/js/main.js'); ?>"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"
</head>
<body>
    <div class="container col-100">
        <div class="container col-100" id="topbar">
            <span class="title">Worklogs</span>
            <span class="right"><span class="blue-subdue">Hello Cory</span> <a href="#">My Profile</a> | <a href="#">Logout</a></span>
        </div>
        <div class="container col-10" id="sidepanel">
            <ul class="vnav">
                <li>BASIC</li>
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="/">Jobs</a> <span class="count">2</span></li>
                <li><a href="#">Documents</a></li>
                <li>ADMINISTRATION</li>
                <li><a href="/users">Users</a></li>
                <li><a href="/settings">Settings</a></li>
            </ul>
        </div>
        <div class="container col-90">
            <div class="container col-95 pad-25p no-bottom-pad">
                @yield('header')
            </div>
            @yield('content')
        </div>
    </div>
    <div class="popup-overlay">
        <div class="popup-content-small">
            <a class="popup-close" href="javascript:hideOverlay();"><i class="fa fa-times-circle-o fa-2" aria-hidden="true"></i></a>
            <div class="popup-editable-content">
                <h1>Hello, world.</h1>
                <p>Testing</p>
                <a href="javascript:hideOverlay();">Test 2</a>
            </div>
        </div>
    </div>
</body>
</html>
