<?php session_start(); ?>
<?php
require_once "./core/database.php";
require_once "./core/config.php";
require_once "./siteconfig.php";
require_once "./site/helpers/uri.php";
require_once "./core/model.php";
require_once "./site/models/usersmodel.php";
?>
<!doctype html>
<html>
<head>
    <title>Work Logs > Login</title>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset('style.css'); ?>" />
    <style type="text/css">
        .container form {
            margin-left: 50px;
            margin-top: 200px;
        }
        .userselect {
            background: #fff;
            color: #333;
            border: #999 solid 1px;
            padding: 10px 15px !important;
        }
        select:hover {
            border: #7EB4EA solid 1px;
        }
        .userselect option {
            color: #555;
            padding: 0px 20px;
        }
        form input[type=password] {
            width: 480px;
            padding: 10px 20px;
        }
        form input[type=submit] {
            background: #28AFDF;
            color: #fff;
            font-weight: bold;
            margin-right: 160px;
            padding: 10px 20px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="processLogin.php" method="post">
        <h5>WorkLogs Login</h5>
        <p>This site requires a valid login, if you do not posses one you may contact your system administrator to request one.</p>
        <p>
            <?php
            $db = Database::getInstance();
            $db->orderBy('username', 'asc')->select('users');
            $users = $db->fetchAll();
            ?>
            <select name="username" class="userselect">
                <option selected="selected">Please select your account</option>
                <?php foreach($users as $user): ?>
                <option><?php echo $user->display_name; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <input type="password" name="password" placeholder="Enter your password" />
        </p>
        <p class="buttons">
            <input type="submit" name="submit" value="Login" />
        </p>
        </form>
    </div>
</body>
</html>