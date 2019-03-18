<?php

/*******************
*++++++/admin++++++*
*******************/

/* Param:
	t => Auth Token
	a => Action
	j => Json data
*/

$intracall = true;
include_once("../inc/Message.php");
include_once("../inc/dbc.php");
include_once("../inc/func.php");

$token = sanitize($DB_link, $_POST['t']);

$priv = validateToken($DB_link, $token);
if($priv == 0) InvalidTokenProcedure();
checkPermission($priv, "admin");

$action = $_POST['a'];

switch($action) {
	case "userlist":
		$result = $DB_link->query("SELECT * FROM `shepf_users`");
		$userlist = array();
		$n = 0;
		while($row = $result->fetch_row())
		{
			$userlist[$n] = $row[1];
			$n++;
		}
		$out = new Message(98, $userlist);
		echo $out->json();
		die();
		break;
	case "user":
		$user = sanitize($DB_link, $_POST['j']);
		if(preg_match('[^A-Za-z0-9]',$user))
		{
			$out = new Message(50,"Invalid Username");
			echo $out->json();
			die();
		}
		
		$result = $DB_link->query("SELECT * FROM `shepf_users` WHERE `user`='$user'");
		if($result)
		{
			$row = $result->fetch_assoc();
			$udata = array(
				$row['user'],
				$row['accesslevel'],
				$row['lastlogin']
			);
			$out = new Message(98,$udata);
			echo $out->json();
			die();
		}
		else
		{
			DatabaseError();
		}
		break;
}