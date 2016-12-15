<!doctype html>
<html>
<head>
    <title>Notes</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/trumbowyg.min.css') }}" />
    <script src="https://use.fontawesome.com/c584962945.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style type="text/css">
    .trumbowyg{
        float: left;
        width: 660px;
        margin-top: -1px;
        margin-left: 1px;
    }
    </style>
</head>
<body>
    <div class="container col-100">
        <div class="container col-100" id="topbar">
            <span class="title">Worklogs</span>
            <span class="right">
                <!--<span class="blue-subdue">Hello Cory</span> <a href="#">My Profile</a> | <a href="#">Logout</a>-->
                {{ date('D j, M Y h:i A') }}
            </span>
        </div>
        <div class="container col-15" id="sidepanel">
            <ul class="vnav">
                <!--<li>BASIC</li>-->
                <li><h3 class="title">WorkLogs</h3></li>
                <li id="dashboard"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li id="jobs"><a href="{{ url('/') }}">Jobs</a> <span class="badge count">{{ \App\Job::openJobCount() }}</span></li>
                <li id="settings"><a href="{{ url('/settings') }}">Settings</a></li>
                <li>JOBS BY STATUS</li>
                @foreach(\App\Status::all() as $status)
                @if($status->id > 1)
                <li><a href="{{ url('/jobs/status/' . $status->id) }}">{{ (strlen($status->name) > 20) ? substr($status->name, 0, 20) . "...": $status->name }}</a> <span class="badge count" style="background-color: {{ $status->color }};">{{ \App\Status::openJobCount($status->id) }}</a></li>
                @endif
                @endforeach
                <li><a href="{{ url('/jobs/status/1')}}">Closed</a></li>
                <!--<li>ADMINISTRATION</li>-->
                <!--<li><a href="{{ url('/users') }}">Users</a></li>-->
            </ul>
        </div>
        <div class="container col-85" id="content">
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
<script type="text/javascript" src="{{ asset('js/idle.js') }}"></script>
<script src="{{ asset('/js/trumbowyg.min.js') }}"></script>
<script type="text/javascript">
    $.trumbowyg.svgPath = "{{ asset('/images/icons.svg') }}";
    $("textarea").trumbowyg();
</script>
</html>
