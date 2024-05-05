<?php

class Planilla extends Controller
{

    function __construct()
    {
        parent::__construct();
    }
    public function render()
    {
        $this->view->Render('planilla/index');
    }
    public function create()
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
        // Inputs numeros
        $muc = $_POST['muc'] == '' ? 0 : $_POST['muc'];
        $vet = $_POST['vet'] == '' ? 0 : $_POST['vet'];
        $rembasica = $_POST['remBasica'] == '' ? 0 : $_POST['remBasica'];
        $remunifi = $_POST['remReunificada'] == '' ? 0 : $_POST['remReunificada'];
        $ds276 = $_POST['deSupremo'] == '' ? 0 : $_POST['deSupremo'];
        $remotros = $_POST['otros'] == '' ? 0 : $_POST['otros'];
        $ley19990 = $_POST['ley19990'] == '' ? 0 : $_POST['ley19990'];
        $ley20530 = $_POST['ley20530'] == '' ? 0 : $_POST['ley20530'];
        $afp = $_POST['afp'] == '' ? 0 : $_POST['afp'];
        $ipss = $_POST['ipss'] == '' ? 0 : $_POST['ipss'];
        $fonavi = $_POST['fonavi'] == '' ? 0 : $_POST['fonavi'];
        $trabajador = $_POST['trabajador'];

        # Se valida usando el metodo validar->Devuelve TRUE si la validacion es correcta
        if ($this->validacionDatos(nombre: $nombres,apellido: $apellidopa, numero: $idpersonal,fecha: $fechaI) && $this->validacionDatos(apellido: $apellidoma, fecha:$fechaF,descripcion: $cargo)) {
            # Se hace la insercion
            $res = $this->model->Create($condicion, $nombres, $apellidopa, $apellidoma, $fechaI, $fechaF, $cargo, $rembasica, $remunifi, $ds276, $remotros, $ley19990, $ley20530, $afp, $ipss, $fonavi, $moneda, $trabajador, $muc, $vet, $idpersonal);
            # Se verifica si la insercion fue exitosa
            if ($res) {
                echo "EXITO";
                //$this->view->Render("main/inicio");
            }else{
                echo "ERROR";
                //$this->render();
            }
        } else {
            echo 'ERROR';
            //$this->render();
        }
    }
}