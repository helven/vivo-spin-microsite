<?php
class Controller
{
    public $db;
    public $xls;
    public $config;
    public $className;
    public $methodName;
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| MAGIC FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
    function __construct()
    {
        global $config;
        $this->config   = $config;

        session_start();
    }
    
    function __destruct()
    {
    
    }
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PUBLIC function
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
    function z_construct()
    {
        $this->pageName = str_replace('_', ' ', $this->methodName);
        $this->pageName = str_replace(' ', '', ucwords($this->pageName));
        $this->pageName = $this->className.'_'.$this->pageName;
    }
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PROTECTED function
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
    function p_load_view($view, $autorender=FALSE)
    {
        if(!$autorender)
        {
            ob_start();
            require_once(BASEPATH.'/views/'.$view.EXT);
            return ob_get_clean();
        }
        else
        {
            require_once(BASEPATH.'/views/'.$view.EXT);
        }
    }
}