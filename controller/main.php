<?php

class Main extends Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function render()
	{
		$this->view->Render('main/index');
	}
	function inicio()
	{
		$this->view->Render('main/inicio');
	}
	public function renderPlanilla($param = null){
		$id = $param[0];
		$data = $this->model->GetPlanilla($id);
		$this->view->data = $data;
		$this->view->Render('planilla/index');
	}
	public function read(){
		$data = $this->model->Read();
		$json = array();
		while($row = mysqli_fetch_array($data)){
			$json[] = array(
				'id' => $row['id'],
				'nombres' => $row['nombres'],
				'cargo' => $row['cargo'],
				'fecha_inicial' => $row['fecha_inicial'],
				'fecha_final' => $row['fecha_final'],
			);
			
		}
		echo json_encode($json);
	}
	public function search(){
		$nombres = $_POST['nombres'];
		$ap = $_POST['ap'];
		$am = $_POST['am'];
		$cargo = $_POST['cargo'];
		$data = $this->model->Search($nombres,$ap,$am,$cargo);
		$json = array();
		while($row = mysqli_fetch_array($data)){
			$json[] = array(
				'id' => $row['id'],
				'nombres' => $row['nombres'],
				'cargo' => $row['cargo'],
				'fecha_inicial' => $row['fecha_inicial'],
				'fecha_final' => $row['fecha_final'],
			);
			
		}
		
		echo json_encode($json);
	}	
}