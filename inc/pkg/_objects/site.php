<?php
	
class Site extends DataObject
{
	protected $siteStatus;
	protected $siteUrl;
	protected $siteName;
	protected $siteTagline;
	protected $allowUserRegister;
	
	public function __construct()
	{
		// Defaults
		$this->siteStatus = true;
		$this->siteUrl = 'http://'.$_SERVER['SERVER_NAME'];
		$this->siteName = 'Canti Framework';
		$this->siteTagline = "Let's start a fire";
		$this->allowUserRegister = false;
	}
	
	public function constructObject($siteStatus, $siteUrl, $siteName, $siteTagline, $allowRegister)
	{
		$this->siteStatus = $siteStatus;
		$this->siteUrl = $siteUrl;
		$this->siteName = $siteName;
		$this->siteTagline = $siteTagline;
		$this->allowUserRegister = $allowRegister;
	}
	
	// GET
	public function get_siteStatus()
	{
		return $this->siteStatus;
	}
	
	public function get_siteUrl()
	{
		return $this->siteUrl;
	}
	
	public function get_siteName()
	{
		return $this->siteName;
	}
	
	public function get_siteTagline()
	{
		return $this->siteTagline;
	}
	
	public function get_allowUserRegister()
	{
		return $this->allowUserRegister;
	}
	
	// SET
	public function set_siteStatus($status)
	{
		$this->siteStatus = $status;
	}
	
	public function set_siteUrl($url)
	{
		$this->siteUrl = $url;
	}
	
	public function set_siteName($name)
	{
		$this->siteName = $name;
	}
	
	public function set_siteTagline($tagline)
	{
		$this->siteTagline = $tagline;
	}
	
	public function set_allowUserRegister($status)
	{
		$this->allowUserRegister = $status;
	}
	
}