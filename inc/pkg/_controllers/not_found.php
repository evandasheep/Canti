<?php

class Not_Found extends Controller
{
    protected function default()
    {
        include 'web/404.view';
        exit;
    }
}