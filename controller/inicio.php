<?php

class Inicio extends Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function render()
	{
		$this->view->Render('inicio/index');
	}
    function login(){
        $this->view->Render('login/index');
    }
}