<?php

class Logout extends Controller
{
    public function __construct($dbc)
    {
        parent::__construct($dbc);
    }
    
    protected function default()
    {
		session_unset();
		session_destroy();
		session_id(SESS_ID);
		session_start();
		header('Location: '.$this->site->get_siteUrl());
    }
}
?>