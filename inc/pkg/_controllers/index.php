<?php
	
class Index extends Controller
{
	public function __construct($dbc)
	{
		parent::__construct($dbc);
	}
	
	public function default()
	{
		$this->pageTitle = "Home";
		include 'web/index.view';
		exit;
	}
}