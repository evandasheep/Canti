<?php

class Diagnosis
{
    private $dbc;
	private $settings;
    private $generalStatus;
	private $testResults = [];
    
    function __construct()
    {
		$this->generalStatus = true;
    }
	
	public function start()
	{
		$this->settings = parse_ini_file('./inc/settings.ini', true);
		$this->testResults[1] = !empty($this->settings);
		
		$dsn = 'mysql:dbname=' . $this->settings['db']['name'] . ';host=' . $this->settings['db']['host'];
		try
		{
			$this->dbc = new PDO($dsn, $this->settings['db']['user'], $this->settings['db']['pass']);
			$this->testResults[2] = true;
		}
		catch (PDOException $e)
		{
			$this->testResults[2] = false;
		}
		
		define('INSTALL_PATH', $this->settings['core']['path']);
	}
	
	public function running()
	{
		foreach($this->testResults as $result)
		{
			if($result == false)
			{
				$this->generalStatus = false;
			}
		}
		return $this->generalStatus;
	}
    
    public function get_dbc()
	{
		return $this->dbc;
    }
	
	public function get_settings()
	{
		return $this->settings;
	}
}