<?php

class SiteModel extends Model
{
    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }
    
	public function get_siteObject()
	{
		$site = new Site();
		
		$queryResult = $this->getAll('site_config');
		
		if (count($queryResult) >= 4)
		{
			$site->constructObject(
				$queryResult[0]['conf_value'],
				$queryResult[1]['conf_value'],
				$queryResult[2]['conf_value'],
				$queryResult[3]['conf_value'],
				$queryResult[4]['conf_value']
			);
		}
		else
		{
			$site->set_siteStatus(false);
		}
		
		return $site;
	}
	
	public function get_isInstalled()
	{
		$conf = $this->getAll('site_config');
		if(!$conf)
		{
			return false;
		}
		$users = $this->getAll('users');
		if(!$users || count($users) < 1)
		{
			return false;
		}
		return $conf !== false;
	}
	
	public function set_confOption($name, $value)
	{
	    try
	    {
    	    $sql = 'UPDATE site_config SET conf_value = :value WHERE conf_name = :name';
    	    $stmt = $this->dbc->prepare($sql);
    	    $stmt->bindValue(':value', $value);
    	    $stmt->bindValue(':name', $name);
    	    $stmt->execute();
	    }
	    catch (Exception $e)
	    {
	        return false;
	    }
	    return true;
	}
	
	public function set_isInstalled($site)
	{
		$retval = true;
		foreach (glob('./inc/ins/sql/*.sql') as $sql)
		{
		    try
		    {
		        $stmt = $this->dbc->prepare($sql);
		        $stmt->execute();
		    }
		    catch (Exception $e)
		    {
		        $retval = false;
		        echo "Error in " . $sql;
		    }
		}
		$this->set_confOption('site_status', $site->get_siteStatus());
		$this->set_confOption('site_url', $site->get_siteUrl());
		$this->set_confOption('site_name', true);
		
		return $retval;
	}
}