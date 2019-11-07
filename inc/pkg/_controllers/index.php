<?php
	
class Index extends Controller
{
	public function __construct($dbc)
	{
		parent::__construct($dbc);
	}
	
	protected function default()
	{
		$this->pageTitle = "Home";
		include 'web/index.view';
		exit;
	}
}