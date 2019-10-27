<?php
	
class Site extends DataObject
{
	protected $siteStatus;
	protected $siteUrl;
	protected $siteName;
	protected $siteTagline;
	
	public function __construct()
	{
		// Defaults
		$this->siteStatus = true;
		$this->siteName = 'Canti Framework';
		$this->siteTagline = "Let's start a fire";
	}
	
	public function constructObject($siteStatus, $siteName, $siteTagline)
	{
		$this->siteStatus = $siteStatus;
		$this->siteName = $siteName;
		$this->siteTagline = $siteTagLine;
	}
	
	// gets
}