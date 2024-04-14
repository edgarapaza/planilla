<?php

class Login extends Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function user()
	{
		$user = $_POST['usuario'];
		$pass = $_POST['passwd'];

		$data = $this->model->Validar($user, $pass);

		if($data['chkusu'] == 1){
			session_start();
			$_SESSION['katari'] = $data['personal'];
			//$this->view->Render('main/index');
			header('location: '. constant('URL').'main/');
		}else{
			$this->view->mensaje = "Usuario o contraseña incorrecta";
			$this->view->Render('login/index');
		}
	}

	function render()
	{
		$this->view->Render('login/index');
	}
}