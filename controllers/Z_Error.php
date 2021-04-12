<?php
Class Z_Error extends Z_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function error404()
	{
		$this->p_load_view('error/404', TRUE);
	}
}