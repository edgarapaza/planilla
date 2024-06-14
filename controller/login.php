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
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		$tipo = "Ingreso";
		$ip = $_SERVER['REMOTE_ADDR'];

		$data = $this->model->ValidarUsuario($user);
		if (password_verify($pass, $data['passwd'])) {
			if ($data['chkusu'] == 1) {
				session_start();
				$_SESSION['katari'] = $data['personal'];
				$_SESSION['idper'] = $data['idpersonal'];
				//$this->view->Render('main/index');
				if ($this->model->bitacora($data['idpersonal'], $fecha, $hora, $tipo, $ip)) {
					$this->view->mensaje = "no se inserto a la bitacora su ingreso";
				}
				header('location: ' . constant('URL') . 'main/');
			} else {
				$this->view->mensaje = "Usuario o contraseña incorrecta";
				$this->view->Render('login/index');
			}
		} else {
			$this->view->Render('login/index');
		}
	}
	function salir()
	{
		$hora = date('H:i:s');
		$fecha = date('Y-m-d');
		if($this->model->bitacoraSalir($_SESSION['idper'], $hora, $fecha)){
			$this->view->mensaje = "no pudo actualizar la bitacora de salida";
		}
		session_destroy();
		$_SESSION['katari'] = "";
		$_SESSION['idper'] = "";

		$this->view->Render('inicio/index');
	}
	function render()
	{
		$this->view->Render('login/index');
	}
	public function getIp()
	{
		echo $_SERVER['REMOTE_ADDR'] . '<br>';
		//echo var_dump($_SERVER).'<br>';
		foreach ($_SERVER as $clave => $valor) {
			echo "$clave => $valor<br>";
		}
		$this->model->bitacora($_SESSION['idper'], date('Y-m-d'), date('H:i:s'), 'Ingreso al sistema', $_SERVER['REMOTE_ADDR']);
	}
}