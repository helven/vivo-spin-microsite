<?php
Class Privacy_Policy extends Z_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->pageContent	= $this->p_load_view('privacy_policy/index');
		$this->p_load_view('theme_empty', TRUE);
	}
}