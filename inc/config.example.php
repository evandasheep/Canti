<?php

// inc/config.php

/*******************************/
/***** Database Connection *****/
/*******************************/

// DB_server
//  MySQL Databse server address
$DB_server = 	"localhost";

// DB_user
//  MySQL Database server username
$DB_user =		"mysqluser";

// DB_pass
//  MySQL Database server password
$DB_pass =		"Mysqlpass123";

// DB_db
//  MySQL Database name
$DB_db =		"canti";

// DB_pre
//  MySQL Database table prefix
$DB_pre =		"";

/*******************************/
/***** Permission Settings *****/
/*******************************/

// ACCESSLEVELS
//  Simple permission system's user access levels
$ACCESSLEVELS = array(
	0 => "Banned",
	1 => "Spectator",
	2 => "User",
	3 => "Moderator",
	4 => "Admin",
	5 => "Sysadmin"
	);

// PERMISSION
//  SImple permission system required permission levels
$PERMISSION = array(
	// Access to the admin functions, like editing users
	"admin" => 5,
	// Ability to create a new page
	"newpage" => 4,
	// Ability to edit pages
	"editword" => 4
	);
	

