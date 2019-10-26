<?php

require_once('./inc/core.php');

session_start();

$siteSettings = $diagnosis->get_settings();
$sessionId = $siteSettings['sess']['sessionId'];
$sessionTimeout = $siteSEttings['sess']['timeout'];

if (isset($_SESSION['lastActivity']) && ($_SERVER['REQUEST_TIME'] - $_SESSION['lastActivity']) > $sessionTimeout)
{
	session_unset();
	session_destroy();
	session_id($sessionId);
	session_start();
}

$route = new Route($diagnosis->get_dbc());
$route->load();