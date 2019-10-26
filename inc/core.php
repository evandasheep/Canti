<?php

foreach(glob("./inc/pkg/_default/*.php") as $default)
{
	require_once $default;
}

$diagnosis = new Diagnosis();
$diagnosis->start();
if(!$diagnosis->running())
{
	include './web/install/index.view';
	exit;
}