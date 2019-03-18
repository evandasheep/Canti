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
	case "newuser":
		$udata = json_decode($_POST["j"]);
		//var_dump($udata);
		
		$user = sanitize($DB_link, $udata[0]);
		$pass = $udata[1];
		$alvl = (int)($udata[2]);
		
		if(preg_match('[^A-Za-z0-9]',$user))
		{
			$out = new Message(50,"Invalid Username: Contains non-alphanumeric characters");
			echo $out->json();
			die();
		}
		
		if(strlen($user) < 4)
		{
			$out = new Message(50,"Invalid Username: Too Short");
			echo $out->json();
			die();
		}
		
		if(strlen($pass) < 6)
		{
			$out = new Message(50,"Invalid Password: Too Short");
			echo $out->json();
			die();
		}
		
		$existq = $DB_link->query("SELECT `id` WHERE `user`='$user'");
		if($existq->num_rows != 0)
		{
			$out = new Message(50, "Username already in use");
			echo $out->json();
			die();
		}
		
		if(!is_int($alvl) || $alvl < 1 || $alvl > 5)
		{
			$out = new Message(50, "Invalid Access Level");
			echo $out->json();
			die();
		}
		
		$hash = password_hash($pass,PASSWORD_DEFAULT);
		
		$result = $DB_link->query("INSERT INTO `shepf_users` (`user`, `pass`, `accesslevel`) VALUES ('$user', '$hash', '$alvl')");
		if($result)
		{
			$res = $DB_link->query("SELECT * FROM `shepf_users`");
			$userlist = array();
			$n = 0;
			while($row = $res->fetch_row())
			{
				$userlist[$n] = $row[1];
				$n++;
			}
			$out = new Message(98, $userlist);
			echo $out->json();
			die();
		}
		else
		{
			DatabaseError();
		}
		break;
	case "edituser":
		$udata = json_decode($_POST["j"]);
		//var_dump($udata);
		
		$user = sanitize($DB_link, $udata[0]);
		$alvl = (int)($udata[1]);
		
		if(!is_int($alvl) || $alvl < 1 || $alvl > 5)
		{
			$out = new Message(50, "Invalid Access Level");
			echo $out->json();
			die();
		}
		
		$result = $DB_link->query("UPDATE `shepf_users` SET `accesslevel`=$alvl WHERE `user`='$user'");
		if($result)
		{
			$out = new Message(98, $alvl);
			echo $out->json();
			die();
		}
		else
		{
			DatabaseError();
		}
		break;
}