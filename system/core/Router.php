<?php
class Router
{
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| MAGIC FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
	public $class;
	public $method;
	
	function __construct()
	{
		
	}
	
	function __destruct()
	{
	
	}
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PUBLIC FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
	function init()
	{
		$uri	= '';
		if (!isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']))
		{
			//return '';
		}
		else
		{
			// parse_url() returns false if no host is present, but the path or query string
			// contains a colon followed by a number
			$uri = parse_url('http://dummy'.$_SERVER['REQUEST_URI']);
			$query = isset($uri['query']) ? $uri['query'] : '';
			$uri = isset($uri['path']) ? $uri['path'] : '';
		}
		
		if (isset($_SERVER['SCRIPT_NAME'][0]))
		{
			if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
			{
				$uri = (string) substr($uri, strlen($_SERVER['SCRIPT_NAME']));
			}
			elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
			{
				$uri = (string) substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
			}
		}
		
		// This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
		// URI is found, and also fixes the QUERY_STRING server var and $_GET array.
		if (trim($uri, '/') === '' && strncmp($query, '/', 1) === 0)
		{
			$query = explode('?', $query, 2);
			$uri = $query[0];
			$_SERVER['QUERY_STRING'] = isset($query[1]) ? $query[1] : '';
		}
		else
		{
			$_SERVER['QUERY_STRING'] = $query;
		}

		parse_str($_SERVER['QUERY_STRING'], $_GET);

		if ($uri === '/' OR $uri === '')
		{
			$segments	= '/';
		}
		
		$segments	= $this->p_remove_relative_directory($uri);
		
		$a_Segments	= array('index', 'index');
		if($segments != '')
		{
			$a_Segments	= explode('/', $segments);
		}
		
		$this->class	= $a_Segments[0];
		$this->class	= str_replace(array('-', '_'), ' ', $this->class);
		$this->class	= ucwords($this->class);
		$this->class	= str_replace(' ', '_', $this->class);

		$this->method	= (isset($a_Segments[1]) && $a_Segments[1] != '')?$a_Segments[1]:'index';
		$this->method	= strtolower(str_replace('-', '_', $this->method));

	}

/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PROTECTED FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
	protected function p_remove_relative_directory($uri)
	{
		$uris = array();
		$tok = strtok($uri, '/');
		while ($tok !== FALSE)
		{
			if (( ! empty($tok) OR $tok === '0') && $tok !== '..')
			{
				$uris[] = $tok;
			}
			$tok = strtok('/');
		}

		return implode('/', $uris);
	}
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PRIVATE FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
}