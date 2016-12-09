<!doctype html>
<html>
<head>
    <title><?=$title; ?> - WorkLogs</title>
    <link rel="stylesheet" type="text/css" media="screen" href="http://mail.nationalpcpro.com/worklogs/assets/default.css" />
</head>
<body>
    <div class="container">
        <div class="content">
            <form class="login" action="<?=site_url('/auth/login'); ?>" method="post">
            <h2><?=$title; ?></h2>
            <p>This site requires a valid login. Please login with a previously used account or your LDAP login.</p>
            <p>
                <label>Username</label>
                <input type="text" name="username" />
            </p>
            <p>
                <label>Password</label>
                <input type="password" name="password" />
            </p>
            <p>
                <input class="login_button" type="submit" name="submit" value="Login" />
            </p>
            </form>
        </div>
    </div>
</body>
</html>
