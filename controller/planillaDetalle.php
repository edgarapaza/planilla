<?php

class PlanillaDetalle extends Controller
{

    function __construct()
    {
        parent::__construct();
    }
    public function render()
    {
        $this->view->Render('planillaDetalle/index');
    }
    public function renderDetalle($parant = null)
    {
        $id = $parant[0];
        $data = $this->model->GetPlanillaPersonal($id);
        $this->view->data = $data;
        $this->view->Render('planillaDetalle/index');
    }
    public function getPlanilla(){
        $nombres = $_POST['nombres'];
        $ap = $_POST['ap'];
        $am = $_POST['am'];
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];
        try {
            $data = $this->model->GetPlanilla($nombres,$ap,$am,$mes,$anio);
            echo json_encode($data);
        } catch (\Throwable $th) {
            $error = array('error' => 'error en la consulta: '.$th->getMessage());
            echo json_encode($error);
        }
        //$data = $this->model->GetPlanilla('isidro','manzano','flores',12,1990);
        //echo var_dump($data);
    }
    public function update(){
        # se obtiene los datos
        $nombres = $_POST['nombres'];
        $apellidopa = $_POST['apellidopa'];
        $apellidoma = $_POST['apellidoma'];
        $cargo = $_POST['cargo'];
        $fechaI = $_POST['fechaI'];
        $fechaF = $_POST['fechaF'];
        $idpersonal = $_POST['idpersonal'];
        $condicion = $_POST['condicion'];
        $moneda = $_POST['moneda'];
         // Si es necesario formatear los numeros para que solo 
         //tengan 2 flotantes
        $muc = $_POST['muc'];
        $vet = $_POST['vet'];
        $rembasica = $_POST['remBasica'];
        $remunifi = $_POST['remReunificada'];
        $ds276 = $_POST['deSupremo'];
        $remotros = $_POST['otros'];
        $ley19990 = $_POST['ley19990'];
        $ley20530 = $_POST['ley20530'];
        $afp = $_POST['afp'];
        $ipss = $_POST['ipss'];
        $fonavi = $_POST['fonavi'];
        $trabajador = $_POST['trabajador'];
        $id = $_POST['id'];

        $numeros = array($muc, $vet, $rembasica, $remunifi, $ds276, $remotros, $ley19990, $ley20530, $afp, $ipss,$fonavi,$id);
        # Se valida usando el metodo validar->Devuelve TRUE si la validacion es correcta
        if ($this->validacionDatos(numero: $idpersonal, numeros: $numeros) && $this->validacionDatos(nombre: $nombres, apellido: $apellidopa) && $this->validacionDatos(apellido: $apellidoma, descripcion: $cargo)) {
            # Se hace la insercion
            $res = $this->model->Update($id,$condicion, $nombres, $apellidopa, $apellidoma, $fechaI, $fechaF, $cargo, $rembasica, $remunifi, $ds276, $remotros, $ley19990, $ley20530, $afp, $ipss, $fonavi, $moneda, $trabajador, $muc, $vet, $idpersonal);
            # Se verifica si la insercion fue exitosa
            if ($res) {
                echo "REGISTRO EXITOSO";
            }else{
                echo "ERROR EN LA INSERCION";
            }
        } else {
            echo 'ERROR EN LA VALIDACION DE DATOS';
        }
    }
    public function getAllPlanilla(){
        $nombres = $_POST['nombres'];
        $ap = $_POST['ap'];
        $am = $_POST['am'];
        $data = $this->model->GetAllPlanilla($nombres,$ap,$am);
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