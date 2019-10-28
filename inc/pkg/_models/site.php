<?php

class SiteModel extends Model
{
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
	
	public function set_isInstalled($site, $user)
	{
		// TODO: Create required DB tables and insert provided config and admin user
	}
}