<?php

namespace Canti;

use Canti\Engine;
	// MySQLi Handler for Canti engine
	
	class DBConnector
	{
		private $_handle;
		
		// Initialize database connection
		public function connect(Engine $engine)
		{
			$config = $engine->GetSettings("Database");
			$this->_handle = mysqli_connect(
				$config["Database"]["Server"],
				$config["Database"]["Username"],
				$config["Database"]["Password"],
				$config["Database"]["Database"]
			);
		}
		
		public function getRows(string $query, $resulttype = MYSQLI_NUM)
		{
			$result = $this->_handle->query($query);
			if ($result != false)
			{
				return $result->fetch_array($resulttype);
			}
			else
			{
				return null;
			}
		}
	}