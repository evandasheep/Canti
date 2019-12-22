<?php

if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

require_once('./inc/core.php');

session_start();

$siteSettings = $diagnosis->get_settings();
$sessionTimeout = $siteSettings['sess']['timeout'];

if (isset($_SESSION['lastActivity']) && ($_SERVER['REQUEST_TIME'] - $_SESSION['lastActivity']) > $sessionTimeout)
{
	session_unset();
	session_destroy();
	session_id(SESS_ID);
	session_start();
}

$route = new Route($diagnosis->get_dbc());
$route->load();