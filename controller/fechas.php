<?php
require_once 'fpdf.php';

class Fechas extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $id = $_REQUEST['id'];
        $this->view->datos = $id;

        $fechaInicio = $_REQUEST['fechaInicio'];
        $fechaFinal  = $_REQUEST['fechaFinal'];
        $idpersonal  = $_REQUEST['idpersonal'];
        if(isset($_REQUEST['btnImprimir'])){
            echo "Presionado";
            $this->view->d1 =$fechaInicio;
            $this->view->d2 =$fechaFinal;
            $this->view->d3 =$idpersonal;
            $ruta = constant('URL')."/impresion/pdfFecha";
            header("Location: ". $ruta);
        }else{
            echo "NO presionado";
        }
        $this->view->Render('fechas/index');
    }
}
