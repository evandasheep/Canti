<?php

include_once("dbc.php");

function validateToken($link, $token)
{
	$result = $link->query("SELECT * FROM `shepf_users` WHERE token='$token'");
	
	if($result->num_rows < 1)
	{
		return 0;
	} else {
		$resp = $result->fetch_assoc();
		return $resp["accesslevel"];
	}
}

function checkPermission($priv, $process)
{
	
	$req = $PERMISSION[$process];
	
	if(!is_int($req)) {
		if ($priv >= $req) {
			return true;
		} else {
			$out = new Message(91,$process);
			echo $out->json();
			die();
		}
	} else {
		$out = new Message(50, "Invalid Permission");
		echo $out->json();
		die();
	}
}

function getUID($link, $t)
{
	$ures = $link->query("SELECT `id` FROM `shepf_users` WHERE `token`='$t'");
	return $ures->fetch_row()[0];
}

function isJson($string)
{
 json_decode($string);
 return (json_last_error() == JSON_ERROR_NONE);
}

/// public Function sanitize Sanitize input for use in SQL and storage
function sanitize($link, $raw)
{
	$raw = htmlspecialchars($raw);
	$safe = $link->escape_string($raw);
	return $safe;
}

/***			    ****
**** Error Handlers ****
****				***/					

function InvalidTokenProcedure()
{
	$out = new Message(50, "Invalid Token");
	echo $out->json();
	die();
}

function DatabaseError()
{
	$out = new Message(50, "Database Error: ".$DB_link->error);
	echo $out->json();
	die();
}
