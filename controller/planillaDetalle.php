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
    public function getPlanilla()
    {
        $nombres = $_POST['nombres'];
        $ap = $_POST['ap'];
        $am = $_POST['am'];
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];
        try {
            $data = $this->model->GetPlanilla($nombres, $ap, $am, $mes, $anio);
            echo json_encode($data);
        } catch (\Throwable $th) {
            $error = array('error' => 'error en la consulta: ' . $th->getMessage());
            echo json_encode($error);
        }
        //$data = $this->model->GetPlanilla('isidro','manzano','flores',12,1990);
        //echo var_dump($data);
    }
    public function update()
    {
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
        //inputs numeros
        $muc = $_POST['muc'] == '' ? 0 : $_POST['muc'];
        $vet = $_POST['vet'] == '' ? 0 : $_POST['vet'];
        $rembasica = $_POST['remBasica'] == '' ? 0 : $_POST['remBasica'];
        $remunifi = $_POST['remReunificada'] == '' ? 0 : $_POST['remReunificada'];
        $ds276 = $_POST['desupremo'] == '' ? 0 : $_POST['desupremo'];
        $remotros = $_POST['otros'] == '' ? 0 : $_POST['otros'];
        $ley19990 = $_POST['ley19990'] == '' ? 0 : $_POST['ley19990'];
        $ley20530 = $_POST['ley20530'] == '' ? 0 : $_POST['ley20530'];
        $afp = $_POST['afp'] == '' ? 0 : $_POST['afp'];
        $ipss = $_POST['ipss'] == '' ? 0 : $_POST['ipss'];
        $fonavi = $_POST['fonavi'] == '' ? 0 : $_POST['fonavi'];
        $trabajador = $_POST['trabajador'];
        $id = $_POST['id'];

        # Se valida usando el metodo validar->Devuelve TRUE si la validacion es correcta
        if ($this->validacionDatos(numero: $idpersonal, fecha: $fechaI) && $this->validacionDatos(fecha: $fechaF, descripcion: $cargo)) {
            # Se hace la insercion
            $res = $this->model->Update($id, $condicion, $nombres, $apellidopa, $apellidoma, $fechaI, $fechaF, $cargo, $rembasica, $remunifi, $ds276, $remotros, $ley19990, $ley20530, $afp, $ipss, $fonavi, $moneda, $trabajador, $muc, $vet, $idpersonal);
            # Se verifica si la insercion fue exitosa
            if ($res) {
                echo "EXITO";
            } else {
                echo "ERROR";
            }
        } else {
            echo "ERROR";
        }
    }
    public function getAllPlanilla()
    {
        $nombres = $_POST['nombres'];
        $ap = $_POST['ap'];
        $am = $_POST['am'];
        $data = $this->model->GetAllPlanilla($nombres, $ap, $am);
        $json = array();
        while ($row = mysqli_fetch_array($data)) {
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