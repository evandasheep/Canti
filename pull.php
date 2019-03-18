<?php

/* Param:
	t => Auth Token
	a => Action
	j => Json data
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
	case "wordlist":
		$result = $DB_link->query("SELECT word FROM `shepf_definitions` ORDER BY `word` ASC");
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
		break;
	case "word":
		$j = $_POST['j'];
		$rword = sanitize($DB_link, $j);
		$result = $DB_link->query("SELECT * FROM `shepf_definitions` WHERE `word`='$rword'");
		if($result == false || $result->num_rows != 1)
		{
			DatabaseError();
		}
		$row = $result->fetch_row();
		$odata = array($row[0],$row[1],$row[2]);
		$out = new Message(12, $odata);
		echo $out->json();
		die();
		break;
	case "mypriv":
		$out = new Message(98, $priv);
		echo $out->json();
		die();
		break;
	case "search":
		$term = strtolower(sanitize($DB_link, $_POST['j']));
		$result = $DB_link->query("SELECT * FROM `shepf_definitions` WHERE (`word` LIKE '%$term%' OR `s_def` LIKE '%$term%') ORDER BY `word` ASC");
		$ret = array();
		$n = 0;
		while($row = $result->fetch_row())
		{
			$ret[$n] = $row[0];
			$n++;
		}
		$out = new Message(11, $ret);
		echo $out->json();
		die();
		break;
	case "wordsets":
		$uid = getUID($DB_link, $token);
		$result = $DB_link->query("SELECT * FROM `shepf_saved_sets` WHERE `owner`=$uid");
		$ret = array(array(),array());
		$n = 0;
		while($row = $result->fetch_row())
		{
			$ret[0][$n] = $row[0];
			$ret[1][$n] = $row[2];
		}
		$ret = json_encode($ret);
		$out = new Message(98,$ret);
		echo $out->json();
		die();
		break;
	case "wordset":
		$j = $_POST["j"];
		
		$id = sanitize($DB_link, $j);
		
		$result = $DB_link->query("SELECT * FROM `shepf_saved_sets` WHERE `id`=$id");
		if(!$result) {
			DatabaseError();
		}
		
		$row = $result->fetch_row();
		$ret = json_encode(array($row[2],$row[3]));
		
		$out = new Message(98,$ret);
		echo $out->json();
		die();
		break;
}