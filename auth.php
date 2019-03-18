<?php

/* Param:
	u => Username
	p => Password
*/

$intracall = true;
include_once("inc/Message.php");
include_once("inc/dbc.php");

$user = $_POST['u']; // Username
$pass = $_POST['p']; // Password

// Sanitize
$user = htmlentities($user);

if(preg_match('[^A-Za-z0-9]',$user))
{
	$out = new Message(50,"Invalid Username: Contains non-alphanumeric characters");
	echo $out->json();
	die();
}

$result = $DB_link->query("SELECT * FROM `shepf_users` WHERE user='$user'");
if($result == false)
{
	$out = new Message(50, "Database Error: ".$DB_link->error);
	echo $out->json();
	die();
}

if($result->num_rows < 1)
{
	$out = new Message(50, "Invalid Username");
	echo $out->json();
	die();
}

$row = $result->fetch_assoc();
if(password_verify($pass,$row["pass"]))
{
	$id = $row["id"];
	$time = time();
	$token = $token = bin2hex(openssl_random_pseudo_bytes(64));
	$result = $DB_link->query("UPDATE `shepf_users` SET `token`='$token' WHERE id=$id");
	if($result)
	{
		$out = new Message(99,"$token");
		echo $out->json();
		die();
	} else {
		DatabaseError();
	}
} else {
	$out = new Message(50, "Invalid Login Details");
	echo $out->json();
	die();
}