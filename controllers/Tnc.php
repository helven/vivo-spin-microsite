<?php
Class Tnc extends Z_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->pageContent	= $this->p_load_view('tnc/index');
		$this->p_load_view('theme_empty', TRUE);
	}
	
	function test()
	{
		$this->p_render('test/test');
	}
}