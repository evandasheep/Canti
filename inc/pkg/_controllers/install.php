<?php

class Install extends Controller
{
    public function __construct($dbc)
    {
        parent::__construct($dbc);
    }
    
    protected function default()
    {
        $this->start();
    }
    
    protected function start()
    {
        include 'web/install/start.view';
        exit;
    }
}