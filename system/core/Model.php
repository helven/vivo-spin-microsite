<?php
class Model
{
    public $db;

    function __construct()
    {
        global $config;
        
        $this->config	= $config;
        $this->db   = new Database;
    }
}