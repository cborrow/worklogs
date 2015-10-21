<!doctype html>
<html>
<head>
    <title>WorkLogs Install</title>
    <link rel="stylesheet" type="text/css" media="screen" href="assets/default.css" />
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>Install WorkLogs</h1>
            <p>This page will begin the install of the WorkLogs website.</p>
            <p>Please fill out the information below and click 'Install' to begin.</p>
            <form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
            <h2 class="subdue">Setup inital user</h2>
            <p>
                <label>Username</label>
                <input type="text" name="username" />
            </p>
            <p>
                <label>Password</label>
                <input type="password" name="password" />
            </p>
            <p>
                <label>Email</label>
                <input type="text" name="email" />
            </p>
            <p class="login_button">
                <input type="submit" name="submit" value="Install" />
            </p>
            </form>
        </div>
    </div>
</body>
</html>
<?php
if(isset($_POST['submit']) && $_POST['submit'] = 'Install') {
    $db = new SQLite3('Worklogs.db');

    $sql1 = @"CREATE TABLE status (";
    $sql1 .= "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,";
    $sql1 .= "name VARCHAR(50) NOT NULL)";

    $sql2 = "CREATE TABLE stores (";
    $sql2 .= "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,";
    $sql2 .= "created INT NOT NULL,";
    $sql2 .= "name VARCHAR(50) NOT NULL)";

    $sql3 = "CREATE TABLE users (";
    $sql3 .= "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,";
    $sql3 .= "created INT NOT NULL,";
    $sql3 .= "last_login INT NOT NULL,";
    $sql3 .= "username VARCHAR(30) NOT NULL,";
    $sql3 .= "password VARCHAR(100) NOT NULL,";
    $sql3 .= "email VARCHAR(125) NOT NULL)";

    $sql4 = "CREATE TABLE jobs (";
    $sql4 .= "id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,";
    $sql4 .= "created INT NOT NULL,";
    $sql4 .= "modified INT NOT NULL,";
    $sql4 .= "store_id INT NOT NULL,";
    $sql4 .= "user_id INT NOT NULL,";
    $sql4 .= "status_id INT NOT NULL,";
    $sql4 .= "workorder VARCHAR(20) NOT NULL,";
    $sql4 .= "serial VARCHAR(50) NOT NULL,";
    $sql4 .= "customer VARCHAR(50) NOT NULL,";
    $sql4 .= "notes TEXT NOT NULL)";

    //$sql5 = "INSERT INTO users (created, last_login, username, password, email) VALUES ('UNIX_TIMESTAMP()', 'UNIX_TIMESTAMP()', 'admin', 'SHA1(S3cur1ty)', 'support@npcpro.com');";
    //$sql6 = "INSERT INTO status (name) VALUES ('Closed')";
    //$sql7 = "INSERT INTO status (name) VALUES ('In Progress')";
    //$sql8 = "INSERT INTO stores (created, name) VALUES ('UNIX_TIMESTAMP()', 'Default')";

    echo "Running install tasks...<br />";

    $db->query($sql1);

    if($db->LastError == 0)
        echo "Created status table<br />";
    else
        die("Error creating table 'status'");

    $db->query($sql2);

    if($db->LastError == 0)
        echo "Created stores table<br />";
    else
        die("Error creating table 'stores'");

    $db->query($sql3);

    if($db->LastError == 0)
        echo "Created users table<br />";
    else
        die("Error creating table 'users'");

    $db->query($sql4);

    if($db->LastError == 0)
        echo "Created jobs table<br />";
    else
        die("Error creating table 'jobs'");

    echo "Database has and tables have been sucesfully created...<br />";
    echo "Starting creation of inital data...<br />";

    $user = $_POST['username'];
    $pass = $_POST['password'];
    $mail = $_POST['email'];
    $hp = sha1($pass);

    $ud = array();
    $ud['created'] = time();
    $ud['last_login'] = time();
    $ud['username'] = $user;
    $ud['password'] = $hp;
    $ud['email'] = $mail;
    $db->insert('users', $ud);

    if($db->LastError == 0)
        echo "Created new user '{$user}'<br />";

    $db->insert('status', array('name' => 'Closed'));
    $db->insert('status', array('name' => 'In Progress'));
    $db->insert('stores', array('created' => time(), 'name' => 'Default'));

    echo "Finished, all tasks completed sucesfully<br />";
}
?>
