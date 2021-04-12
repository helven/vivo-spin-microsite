<?php
session_start();
$basePath   = @realpath(dirname(__FILE__).'/../../');

define('EXT','.php');
define('BASEPATH', $basePath);
define('HELPERPATH', $basePath.'/helper');

date_default_timezone_set('Asia/Kuala_Lumpur');

require_once(BASEPATH.'/config/config'.EXT);
require_once(BASEPATH.'/config/database'.EXT);

require_once(BASEPATH.'/system/core/Router'.EXT);

require_once(BASEPATH.'/system/core/Database'.EXT);
require_once(BASEPATH.'/system/core/Controller'.EXT);

require_once(BASEPATH.'/config/autoload'.EXT);

// REFINE baseurl
$config['base_url'] = str_replace('/controllers', '', $config['base_url']);
$config['base_url'] = str_replace('/helpers', '', $config['base_url']);
$config['base_url'] = str_replace('/libraries', '', $config['base_url']);

$o_Router	= new Router();
$o_Router->init();
$class	= $o_Router->class;
$method	= $o_Router->method;

$classFilePath	= BASEPATH.'/controllers/'.$class.EXT;

$error404	= FALSE;

// Check if class file exists
if(!file_exists($classFilePath))
{
	$error404	= TRUE;
}
else
{
	require_once($classFilePath);
	// Check if class exists
	if(!class_exists($class))
	{
		$error404	= TRUE;
	}
	else
	{
		$cls	= new $class();
		if(!method_exists($cls, $method))
		{
			$error404	= TRUE;
		}
	}
}
if($error404)
{
	$class	= 'Z_Error';
	$method	= 'error404';
	require_once(BASEPATH.'/controllers/Z_Error'.EXT);
}

$cls	= new $class();
$cls->className		= $class;
$cls->methodName	= $method;
$cls->z_construct();
$cls->$method();
