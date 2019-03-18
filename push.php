<?php

//

/* Param:
	t => Auth Token
	a => Action
	j => Json Data
*/

$intracall = true;
include_once("inc/Message.php");
include_once("inc/dbc.php");
include_once("inc/func.php");

$token = sanitize($DB_link, $_POST['t']);

$priv = validateToken($DB_link, $token);
if($priv == 0) InvalidTokenProcedure();

$action = $_POST['a'];

switch($action) {

	case "newword":
		checkPermission($priv, "newword");
		
		$j = $_POST["j"];
		
		$wdata = json_decode($j);
		//var_dump($wdata);
		$word = sanitize($DB_link, strtolower($wdata[0]));
		$lett = sanitize($DB_link, strtolower($wdata[1]));
		$defn = trim(sanitize($DB_link, $wdata[2]));
		$sdef = strtolower($defn);
		
		if(strlen($word) < 2 || strlen($lett) < 3 || strlen($defn) < 6) {
			$out = new Message(50, "W: $word --- L: $lett --- $defn");
			echo $out->json();
			die();
		}
		
		$result = $DB_link->query("INSERT INTO `shepf_definitions` (`word`, `letters`, `definition`, `s_def`) VALUES ('$word', '$lett', '$defn', '$sdef')");
		if($result) {
			$result = $DB_link->query("SELECT word FROM `shepf_definitions`");
			$words = array();
			$n = 0;
			while($row = $result->fetch_row())
			{
				$words[$n] = $row[0];
				$n++;
			}
			$out = new Message(11, $words);
			echo $out->json();
			die();
		} else {
			DatabaseError();
		}
		
		break;
		
	case "editword":
		checkPermission($priv, "editword");
		
		$j = $_POST["j"];
		
		$wdata = json_decode($j);
		
		$word = strtolower(sanitize($DB_link, $wdata[0]));
		$lett = strtolower(sanitize($DB_link, $wdata[1]));
		$defn = sanitize($DB_link, $wdata[2]);
		$sdef = strtolower($defn);
		
		if(strlen($word) < 2 || strlen($lett) < 3 || strlen($defn) < 6) {
			$out = new Message(50, "W: $word --- L: $lett --- $defn");
			echo $out->json();
			die();
		}
		
		$result = $DB_link->query("UPDATE `shepf_definitions` SET `letters`='$lett',`definition`='$defn', `s_def`='$sdef' WHERE `word`='$word'");
		if($result) {
			$out = new Message(12, array($word,$lett,$defn));
			echo $out->json();
			die();
		} else {
			DatabaseError();
		}
		break;
	case "wordset":
		$j = $_POST["j"];
		
		$data = json_decode($j);
		
		$name = sanitize($DB_link, $data[0]);
		$words = $data[1];
		
		if(!isJson($words)) {
			$out = new Message(50,"Bad Words: $words");
			echo $out->json();
			die();
		}
		$uid = getUID($DB_link, $token);
		
		$result = $DB_link->query("INSERT INTO `shepf_saved_sets` (`owner`, `name`, `words`) VALUES ($uid, '$name', '$words')");
		if(!$result)
		{
			DatabaseError();
		}

		$out = new Message(98,"Success");
		echo $out->json();
		die();

		break;
	case "changepass":
		$j = $_POST["j"];
		
		$data = json_decode($j);
		
		$oldp = $data[0];
		$newp = $data[1];
		
		$pres = $DB_link->query("SELECT `pass` FROM `shepf_users` WHERE `token`='$token'");
		if($pres)
		{
			if($pres->num_rows != 1) 
			{
				$out = new Message(50,"User not found");
				echo $out->json();
				die();
			}
			$row = $pres->fetch_assoc();
			if(password_verify($oldp, $row["pass"]))
			{
				if(strlen($newp) < 6)
				{
					$out = new Message(50, "Password not long enough");
					echo $out->json();
					die();
				}
				$newhash = password_hash($newp,PASSWORD_DEFAULT);
				$result = $DB_link->query("UPDATE `shepf_users` SET `pass`='$newhash' WHERE `token`='$token'");
				if($result)
				{
					$out = new Message(98, "Success");
					echo $out->json();
					die();
				} else {
					DatabaseError();
				}
			} else {
				$out = new Message(50, "Invalid password");
				echo $out->json();
				die();
			}
			
		} else {
			DatabaseError();
		}
		break;
}