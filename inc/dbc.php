<?php

if (!$intracall)
{
	http_response_code(403);
	die();
}

include_once("config.php");
include_once("Message.php");

$DB_link = mysqli_connect($DB_server,$DB_user,$DB_pass,$DB_db);

if (!$DB_link)
{
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}