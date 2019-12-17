<?php

class Login extends Controller
{
    public function __construct($dbc)
    {
        parent::__construct($dbc);
    }
    
    protected function default()
    {
        include 'web/login.view';
    }
}
?>