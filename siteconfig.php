<?php
require_once "core/config.php";
require_once "core/user.php";

Config::set("application.defaults.controller", "jobs");
Config::set("application.defaults.action", "index");

Config::set("application.paths.base", "C:\\Dev\\wamp\\www\\worklogs\\");
Config::set("application.paths.controllers", "site/controllers/");
Config::set("application.paths.models", "site/models/");
Config::set("application.paths.views", "site/views/");
Config::set("application.paths.libraries", "site/libraries/");
Config::set("application.paths.helpers", "site/helpers/");
Config::set("application.paths.assets", "site/assets/");

Config::set("application.database.host", "localhost");
Config::set("application.database.user", "root");
Config::set("application.database.pass", "");
Config::set("application.database.name", "worklogs");

Config::set("site.uri.base", "/worklogs/");
Config::set("site.uri.index_page", "index.php");
Config::set("site.uri.full", "http://localhost/worklogs/");
?>