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

        $numeros = array($muc, $vet, $rembasica, $remunifi, $ds276, $remotros, $ley19990, $ley20530, $afp, $ipss,$fonavi);
        # Se valida usando el metodo validar->Devuelve TRUE si la validacion es correcta
        if ($this->validacionDatos(numero: $idpersonal, numeros: $numeros) && $this->validacionDatos(nombre: $nombres, apellido: $apellidopa) && $this->validacionDatos(apellido: $apellidoma, descripcion: $cargo)) {
            # Se hace la insercion
            $res = $this->model->Create($condicion, $nombres, $apellidopa, $apellidoma, $fechaI, $fechaF, $cargo, $rembasica, $remunifi, $ds276, $remotros, $ley19990, $ley20530, $afp, $ipss, $fonavi, $moneda, $trabajador, $muc, $vet, $idpersonal);
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
}