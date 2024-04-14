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
		$data = $_POST['search'];
		$data = $this->model->Search($data);
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