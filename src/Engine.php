<?php

namespace Canti;

use Canti\DBConnector;

class Engine
{
	private $_db;
	private $_settings;
	
	public function __construct(string $configfile)
	{
		$this->_settings = parse_ini_file($configfile, true);
		$this->_db = new DBConnector(this);
	}
	
	public function GetSettings($set)
	{
		return $_settings[$set];
	}
	
	public function GetDB()
	{
		return $_db;
	}
}