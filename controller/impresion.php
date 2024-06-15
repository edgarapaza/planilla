<?php
require_once 'fpdf.php';    
header("Content-Type: text/html;charset=utf-8");
class Impresion extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function pdf($param = null)
    {
        $id = $param[0];
        if ($id == null || $id == '') {
            $this->view->Render("main/inicio");
        }

        setlocale(LC_TIME, 'es_ES.UTF-8');

        $persona = $this->model->buscarxId($id);
        $nombre = $persona['nombres'];
        $ap = $persona['ap'];
        $am = $persona['am'];


        /* Fechas generales*/
        $sql = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE nombres = '$nombre' and ap = '$ap' and am = '$am';";
        $data = $this->model->AniosTrabajados($sql);
        $fechainicio = array();
        $fechafinal = array();

        while ($row1 = mysqli_fetch_array($data)) {
            $fechainicio[] = $row1['spdat1'];
            $fechafinal[] = $row1['spdat2'];
        }
        // #echo "Inicio: ". $fechainicio[0];
        // #echo " Fin:". $fechafinal[count($fechafinal)-1];
        //  FIN FECHAS GENERALES



        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->AddPage();


        $time1 = strtotime($fechainicio[0]);
        $fecString1 = strftime("%d-%B-%Y", $time1);

        $time2 = strtotime($fechafinal[count($fechafinal) - 1]);
        $fecString2 = strftime("%d-%B-%Y", $time2);

        /* Agregando nombre*/
        $pdf->SetXY(30, 21);
        $pdf->Cell(0, 10, $nombre . " " . $ap . " " . $am, 0, 1, 'L');
        $pdf->SetXY(30, 27);
        $pdf->Cell(0, 10, $fecString1 . " HASTA " . $fecString2 , 0, 1, 'L');


        #$this->Cell(0, 10, "DESDE: ".$fechainicio[0]."    HASTA: ".$fechafinal[count($fechafinal)-1]." ", 0, 1, 'L');
        $header = array('Desde', 'Hasta', 'Dias', 'CARGO', 'BASICA', 'MUC', 'BET', 'REUNIF', 'D.S.276', 'OTROS', 'TOTAL REMU', '20530', '19990', 'AFP', 'IPSS', 'FONAVI');
        // Colors, line width and bold font
        $pdf->SetFillColor(200, 100, 100);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('', 'B');
        // Header
        $w = array(16, 16, 8, 40, 15, 15, 15, 15, 15, 22, 22, 15, 15, 15, 15);

        for ($k = 0; $k < count($header); $k++) {
            $pdf->Cell($w[$k], 7, $header[$k], 1, 0, 'C', true);
        }
        $pdf->Ln();
        // Color and font restoration
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        // Data
        $fill = false;

        $dias1 = array();
        $dias2 = array();
        $dias3 = array();

        /* SECCION PARA SOLES DE ORO  */
        $sqlo = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE moneda = 'O' AND nombres = '$nombre' and ap = '$ap' and am = '$am' group by year(spdat1);";

        $datao = $this->model->AniosTrabajados($sqlo);
        $anioinicio1 = array();
        $aini1 = array();
        $a = 0;
        while ($row = $datao->fetch_array(MYSQLI_ASSOC)) {
            $anioinicio1[$a] = $row['spdat1'];
            $aini1[$a] = substr($anioinicio1[$a], 0, 4);
            $a++;
        }

        $p = 0;
        foreach ($aini1 as $anio) {
            $pdf->Cell($w[0], 6, $anio, 'LR', 0, 'L', $fill);
            $pdf->Ln();
            $datap = $this->model->DetallexAnioo($anio, $nombre, $ap, $am);

            while ($row = mysqli_fetch_array($datap)) {
                $pdf->Cell(16, 6, $row['spdat1'], 'LR', 0, 'L', $fill);
                $pdf->Cell(16, 6, $row['spdat2'], 'LR', 0, 'L', $fill);
                $fecha1 = new DateTime($row['spdat1']);
                $fecha2 = new DateTime($row['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $dias1[$p] = $diff->days + 1;
                $pdf->Cell(8, 6, $diff->days + 1, 'LR', 0, 'L', $fill);
                $pdf->Cell(40, 6, $row['cargo'], 'LR', 0, 'L', $fill);
                $pdf->Cell(15, 6, $row['rembasica'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['muc'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['vet'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['remunifi'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ds276'], 'LR', 0, 'R', $fill);
                $pdf->Cell(22, 6, $row['remotros'], 'LR', 0, 'R', $fill);
                $pdf->Cell(22, 6, $row['bruto'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ley20530'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ley19990'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['afp'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ipss'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['fonavi'], 'LR', 0, 'R', $fill);

                $pdf->Ln();
                $fill = !$fill;
                $p++;
            }
            $sum1 = 0;
            for ($j = 0; $j < count($dias1); $j++) {
                $sum1 += $dias1[$j];
            }
            $pdf->Cell(15, 6, '      TOTAL DIAS: ' . $sum1, 'L', 0, 'L', $fill);
            $pdf->Ln();
            /* Limpiando el array*/
            unset($dias1);
        }

        $resumen1 = $this->model->planillao($nombre, $ap, $am);
        $pdf->cell(275, 10, "                                                                               TOTAL SO/.                       " . $resumen1['bruto'], 1, 1, 'C');



        /* SECCION PARA INTIS  */
        $sqli = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE moneda = 'I' AND nombres = '$nombre' and ap = '$ap' and am = '$am' group by year(spdat1);";

        $datai = $this->model->AniosTrabajados($sqli);
        $anioinicio2 = array();
        $aini2 = array();
        $b = 0;

        while ($row = $datai->fetch_array(MYSQLI_ASSOC)) {
            $anioinicio2[] = $row['spdat1'];
            $aini2[] = substr($anioinicio2[$b], 0, 4);
            $b++;
        }
        $q = 0;
        foreach ($aini2 as $anio) {
            $pdf->Cell($w[0], 6, $anio, 'LR', 0, 'L', $fill);
            $pdf->Ln();
            $datap = $this->model->DetallexAnioi($anio, $nombre, $ap, $am);

            while ($row = mysqli_fetch_array($datap)) {
                $pdf->Cell(16, 6, $row['spdat1'], 'LR', 0, 'L', $fill);
                $pdf->Cell(16, 6, $row['spdat2'], 'LR', 0, 'L', $fill);
                $fecha1 = new DateTime($row['spdat1']);
                $fecha2 = new DateTime($row['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $dias2[$q] = $diff->days + 1;
                $pdf->Cell(8, 6, $diff->days + 1, 'LR', 0, 'L', $fill);
                $pdf->Cell(40, 6, $row['cargo'], 'LR', 0, 'L', $fill);
                $pdf->Cell(15, 6, $row['rembasica'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['muc'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['vet'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['remunifi'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ds276'], 'LR', 0, 'R', $fill);
                $pdf->Cell(22, 6, $row['remotros'], 'LR', 0, 'R', $fill);
                $pdf->Cell(22, 6, $row['bruto'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ley20530'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ley19990'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['afp'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ipss'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['fonavi'], 'LR', 0, 'R', $fill);

                $pdf->Ln();
                $fill = !$fill;
                $q++;
            }
            $sum2 = 0;
            for ($m = 0; $m < count($dias2); $m++) {
                $sum2 += $dias2[$m];
            }
            $pdf->Cell(15, 6, '      TOTAL DIAS: ' . $sum2, 'L', 0, 'L', $fill);
            $pdf->Ln();
            /* Limpiando el array*/
            unset($dias2);
        }

        $resumen2 = $this->model->planillai($nombre, $ap, $am);
        $pdf->cell(275, 10, "                                                                               TOTAL I/.                       " . $resumen2['bruto'], 1, 1, 'C');



        /* SECCION PARA NUEVOS SOLES  */
        $sql3 = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE moneda = 'S' AND nombres = '$nombre' and ap = '$ap' and am = '$am' group by year(spdat1);";
        $dataS = $this->model->AniosTrabajados($sql3);
        $anioinicio3 = array();
        $aini3 = array();
        $c = 0;

        while ($row = $dataS->fetch_array(MYSQLI_ASSOC)) {
            $anioinicio3[] = $row['spdat1'];
            $aini3[] = substr($anioinicio3[$c], 0, 4);
            $c++;
        }
        $r = 0;
        foreach ($aini3 as $anio) {
            $pdf->Cell($w[0], 6, $anio, 'LR', 0, 'L', $fill);
            $pdf->Ln();
            $datap = $this->model->DetallexAnios($anio, $nombre, $ap, $am);

            while ($row = mysqli_fetch_array($datap)) {
                $pdf->Cell(16, 6, $row['spdat1'], 'LR', 0, 'L', $fill);
                $pdf->Cell(16, 6, $row['spdat2'], 'LR', 0, 'L', $fill);
                $fecha1 = new DateTime($row['spdat1']);
                $fecha2 = new DateTime($row['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $dias3[$r] = $diff->days + 1;
                $pdf->Cell(8, 6, $diff->days + 1, 'LR', 0, 'L', $fill);
                $pdf->Cell(40, 6, $row['cargo'], 'LR', 0, 'L', $fill);
                $pdf->Cell(15, 6, $row['rembasica'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['muc'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['vet'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['remunifi'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ds276'], 'LR', 0, 'R', $fill);
                $pdf->Cell(22, 6, $row['remotros'], 'LR', 0, 'R', $fill);
                $pdf->Cell(22, 6, $row['bruto'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ley20530'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ley19990'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['afp'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['ipss'], 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, $row['fonavi'], 'LR', 0, 'R', $fill);

                $pdf->Ln();
                $fill = !$fill;
                $r++;
            }
            $sum3 = 0;
            for ($n = 0; $n < count($dias3); $n++) {
                $sum3 += $dias3[$n];
            }
            $pdf->Cell(15, 6, '      TOTAL DIAS: ' . $sum3, 'L', 0, 'L', $fill);
            $pdf->Ln();
            /* Limpiando el array*/
            unset($dias3);
        }

        $resumen3 = $this->model->planillas($nombre, $ap, $am);
        $pdf->cell(275, 10, "                                                                               TOTAL NS/.                       " . $resumen3['bruto'], 1, 1, 'C');


        $pdf->Cell(array_sum($w), 0, '', 'T');

        $pdf->Ln(10);
        #MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(280, 7, 'RESUMEN', 0, 0, 'C');
        $pdf->Ln();
        #Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();

        $resum = $this->model->planillao($nombre, $ap, $am);
        $resum2 = $this->model->planillai($nombre, $ap, $am);
        $resum3 = $this->model->planillas($nombre, $ap, $am);
        // #echo "Inicio: ". $fechainicio[0];
        // #echo " Fin:". $fechafinal[count($fechafinal)-1];
         /* Llamando a Calculadora de Años meses y dias*/

        $muestra = $this->model->Calculadora($fechainicio[0], $fechafinal[count($fechafinal)-1], $id);
        if($resum['trabajador'] === "E"){
            $tipoemleado = "Empleado";
        }else{
            $tipoemleado = "Obrero";
        }

        setlocale(LC_TIME, 'es_ES.UTF-8');
        $timestamp1 = strtotime($fechainicio[0]);
        $fecInicio1 = strftime("%d de %B del %Y", $timestamp1);

        $timestamp2 = strtotime($fechafinal[count($fechafinal) - 1]);
        $fecInicio2 = strftime("%d de %B del %Y", $timestamp2);

        // convierte texto a iso88591------------------------------

        $info = "De lo detallado de las paginas, se desprende que Don(ña):  " . $ap . " " . $am . ", " . $nombre . " ha prestado sus servicios al Estado desde " . $fecInicio1 . " hasta " . $fecInicio2 . " durante ".$muestra['anios']." años, ".$muestra['meses']." meses , ".ceil($muestra['dias'])." dias, en condicion de " . $tipoemleado . " con el cargo de " . $resum['cargo'] . " con una remuneración de:";
        // convierte texto a iso88591
        $ene = $this->utf8_to_iso88591($info);
        // se usa la variable $ene para mostrar la informacion
        $pdf->MultiCell(270, 7, $ene, 0, 'L');
        // cambios hasta aqui para mostrar ene------------------------

        $pdf->Cell(100, 7, 'En Soles de Oro..........: ' . $resum['bruto'], 0, 0, 'R');
        $pdf->Ln();
        $pdf->Cell(100, 7, 'En Intis......................: ' . $resum2['bruto'], 0, 0, 'R');
        $pdf->Ln();
        $pdf->Cell(100, 7, 'En Nuevos Soles..................: ' . $resum3['bruto'], 0, 0, 'R');
        $pdf->Ln();
        $pdf->MultiCell(270, 7, "Es cuanto CERTIFICA: La Unidad de Archivos y Liquidaciones de la Direccion Regional de Transportes, Comunicaciones, Vivienda y Construccion - Puno, tal como obran las copias de planillas en esta Unidad, se expide dicha Constancia Certificada de Pagos de Remuneraciones y Descuentos a solicitud del interesado para los fines que vea convenitente.:", 0, 'L');


        $fecActual = strftime("%d de %B del %Y");

        $pdf->Cell(260, 7, "Puno, ". $fecActual, 0, 0, 'R');

        $pdf->Output();
    }
    // FUNCION PARA CONVERTIR A ISO-8859-1 Y USAR ENIE
    function utf8_to_iso88591($string) {
        return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $string);
    }
    public function fonavi($param = null)
    {
        $id = $param[0];
        //$buscar = new Buscar();
        //$id = $_GET['id'];
        //$persona = $buscar->buscarxId($id);
        $persona = $this->model->buscarxId($id);
        $nombre = $persona['nombres'];
        $ap = $persona['ap'];
        $am = $persona['am'];

        /*$nombre = 'PASCUAL';
        $ap = 'CHAMBI';
        $am = 'CAYO';*/

        /* Para mostrar la fecha inicio y la fecha final*/
        $sql = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE nombres = '$nombre' and ap = '$ap' and am = '$am' AND fonavi <> 0;";
        //$data = $buscar->AniosTrabajados($sql);
        $data = $this->model->AniosTrabajados($sql);
        $fechainicio = array();
        $fechafinal = array();

        while ($row1 = mysqli_fetch_array($data)) {
            $fechainicio[] = $row1['spdat1'];
            $fechafinal[] = $row1['spdat2'];
        }
        // #echo "Inicio: ". $fechainicio[0];
        // #echo " Fin:". $fechafinal[count($fechafinal)-1];


        /* Halla los años que tiene aportaciones en FONAVI por SOLES DE ORO*/
        $sql = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE moneda = 'O' AND nombres = '$nombre' and ap = '$ap' and am = '$am' AND fonavi <> 0 group by year(spdat1);";

        $datoo = $this->model->AniosTrabajados($sql);
        $anioinicio = array();
        $aini = array();

        $i = 0;
        while ($row = $datoo->fetch_array(MYSQLI_ASSOC)) {
            $anioinicio[] = $row['spdat1'];
            $aini[] = substr($anioinicio[$i], 0, 4);
            $i++;
        }


        $pdf = new Fonavi('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->AddPage();

        /* Agregando nombre*/
        $pdf->SetXY(30, 21);
        $pdf->Cell(0, 13, $nombre . " " . $ap . " " . $am, 0, 1, 'L');
        $pdf->SetXY(30, 28);
        $pdf->Cell(0, 10, $fechainicio[0] . " HASTA " . $fechafinal[count($fechafinal) - 1], 0, 1, 'L');
        #$this->Cell(0, 10, "DESDE: ".$fechainicio[0]."    HASTA: ".$fechafinal[count($fechafinal)-1]." ", 0, 1, 'L');

        $header = array('PERIODO', 'DIA', 'CARGO', 'TOTAL REMENU', 'FONAVI');
        // Colors, line width and bold font
        $pdf->SetFillColor(200, 100, 100);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('', 'B');
        // Header
        $w = array(30, 10, 45, 35, 35);

        for ($i = 0; $i < count($header); $i++)
            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $pdf->Ln();
        // Color and font restoration
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        # id, spdat1, spdat2,cargo, sum(rembasica +remunifi+ds276+remotros) as bruto, fonavi
        // Data
        $fill = false;
        $dias = array();
        $mes = array();
        $i = 0;
        foreach ($aini as $anio) {
            $pdf->Cell($w[0], 6, "YEAR: " . $anio, 'LR', 0, 'L', $fill);
            $pdf->Ln();
            #$data = $buscar->fonavio($anio, $nombre, $ap, $am);
            $data = $this->model->fonavio($anio, $nombre, $ap, $am);

            while ($fila3 = $data->fetch_array(MYSQLI_ASSOC)) {
                $anioo[] = $fila3['spdat1'];
                $mes[] = substr($anioo[$i], 5, 2);

                switch ($mes[$i]) {
                    case '01':
                        $pdf->Cell(30, 6, "Enero", 'LR', 0, 'L', $fill);
                        break;
                    case '02':
                        $pdf->Cell(30, 6, "Febrero", 'LR', 0, 'L', $fill);
                        break;
                    case '03':
                        $pdf->Cell(30, 6, "Marzo", 'LR', 0, 'L', $fill);
                        break;
                    case '04':
                        $pdf->Cell(30, 6, "Abril", 'LR', 0, 'L', $fill);
                        break;
                    case '05':
                        $pdf->Cell(30, 6, "Mayo", 'LR', 0, 'L', $fill);
                        break;
                    case '06':
                        $pdf->Cell(30, 6, "Junio", 'LR', 0, 'L', $fill);
                        break;
                    case '07':
                        $pdf->Cell(30, 6, "Julio", 'LR', 0, 'L', $fill);
                        break;
                    case '08':
                        $pdf->Cell(30, 6, "Agosto", 'LR', 0, 'L', $fill);
                        break;
                    case '09':
                        $pdf->Cell(30, 6, "Setiembre", 'LR', 0, 'L', $fill);
                        break;
                    case '10':
                        $pdf->Cell(30, 6, "Octubre", 'LR', 0, 'L', $fill);
                        break;
                    case '11':
                        $pdf->Cell(30, 6, "Noviembre", 'LR', 0, 'L', $fill);
                        break;
                    case '12':
                        $pdf->Cell(30, 6, "Diciembre", 'LR', 0, 'L', $fill);
                        break;
                    default:
                        $pdf->Cell(30, 6, "No reconocido", 'LR', 0, 'L', $fill);
                        break;
                }

                $fecha1 = new DateTime($fila3['spdat1']);
                $fecha2 = new DateTime($fila3['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $dias[] = $diff->days + 1;

                #echo $sum;
                // El resultados sera 3 dias
                #echo $diff->days . ' dias';

                $pdf->Cell(10, 6, $diff->days + 1, 'LR', 0, 'L', $fill);
                $pdf->Cell(45, 6, $fila3['cargo'], 'LR', 0, 'L', $fill);
                $pdf->Cell(35, 6, $fila3['bruto'], 'LR', 0, 'R', $fill);
                $pdf->Cell(35, 6, $fila3['fonavi'], 'LR', 0, 'R', $fill);

                $pdf->Ln();
                $fill = !$fill;
                $i++;
            }

            $sum = 0;
            #echo count($dias);
            for ($j = 0; $j < count($dias); $j++) {
                $sum += $dias[$j];
            }
            $pdf->Cell(15, 6, '              TOTAL DIAS : ' . $sum, 'L', 0, 'L', $fill);
            $pdf->Ln();
            unset($dias);
        }

        //$resumen1 = $buscar->totafonavioro($nombre, $ap, $am);
        $resumen1 = $this->model->totafonavioro($nombre, $ap, $am);
        $pdf->cell(155, 10, "                                                                               TOTAL SO/.                       " . $resumen1['bruto'] . "                             " . $resumen1['fonavi'], 1, 1, 'C');

        /* info para Intis */
        /* Halla los años que tiene aportaciones en FONAVI por intis  */
        $sqli = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE moneda = 'I' AND nombres = '$nombre' and ap = '$ap' and am = '$am' AND fonavi <> 0 group by year(spdat1);";

        //$datai = $buscar->AniosTrabajados($sqli);
        $datai = $this->model->AniosTrabajados($sqli);
        $anioinicio2 = array();
        $aini2 = array();

        $i = 0;
        while ($row = $datai->fetch_array(MYSQLI_ASSOC)) {
            $anioinicio2[] = $row['spdat1'];
            $aini2[] = substr($anioinicio2[$i], 0, 4);
            $i++;
        }

        // Data
        $fill = false;
        $dias2 = array();
        $mes2 = array();
        $i = 0;
        foreach ($aini2 as $anio) {
            $pdf->Cell($w[0], 6, "YEAR: " . $anio, 'LR', 0, 'L', $fill);
            $pdf->Ln();
            //$datai = $buscar->fonavii($anio, $nombre, $ap, $am);
            $datai = $this->model->fonavii($anio, $nombre, $ap, $am);

            while ($filai = $datai->fetch_array(MYSQLI_ASSOC)) {
                $anioi[] = $filai['spdat1'];
                $mes2[] = substr($anioi[$i], 5, 2);

                switch ($mes2[$i]) {
                    case '01':
                        $pdf->Cell(30, 6, "Enero", 'LR', 0, 'L', $fill);
                        break;
                    case '02':
                        $pdf->Cell(30, 6, "Febrero", 'LR', 0, 'L', $fill);
                        break;
                    case '03':
                        $pdf->Cell(30, 6, "Marzo", 'LR', 0, 'L', $fill);
                        break;
                    case '04':
                        $pdf->Cell(30, 6, "Abril", 'LR', 0, 'L', $fill);
                        break;
                    case '05':
                        $pdf->Cell(30, 6, "Mayo", 'LR', 0, 'L', $fill);
                        break;
                    case '06':
                        $pdf->Cell(30, 6, "Junio", 'LR', 0, 'L', $fill);
                        break;
                    case '07':
                        $pdf->Cell(30, 6, "Julio", 'LR', 0, 'L', $fill);
                        break;
                    case '08':
                        $pdf->Cell(30, 6, "Agosto", 'LR', 0, 'L', $fill);
                        break;
                    case '09':
                        $pdf->Cell(30, 6, "Setiembre", 'LR', 0, 'L', $fill);
                        break;
                    case '10':
                        $pdf->Cell(30, 6, "Octubre", 'LR', 0, 'L', $fill);
                        break;
                    case '11':
                        $pdf->Cell(30, 6, "Noviembre", 'LR', 0, 'L', $fill);
                        break;
                    case '12':
                        $pdf->Cell(30, 6, "Diciembre", 'LR', 0, 'L', $fill);
                        break;
                    default:
                        $pdf->Cell(30, 6, "No reconocido", 'LR', 0, 'L', $fill);
                        break;
                }

                $fecha1 = new DateTime($filai['spdat1']);
                $fecha2 = new DateTime($filai['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $dias2[] = $diff->days + 1;

                #echo $sum;
                // El resultados sera 3 dias2
                #echo $diff->days . ' dias2';

                $pdf->Cell(10, 6, $diff->days + 1, 'LR', 0, 'L', $fill);
                $pdf->Cell(45, 6, $filai['cargo'], 'LR', 0, 'L', $fill);
                $pdf->Cell(35, 6, $filai['bruto'], 'LR', 0, 'R', $fill);
                $pdf->Cell(35, 6, $filai['fonavi'], 'LR', 0, 'R', $fill);

                $pdf->Ln();
                $fill = !$fill;
                $i++;
            }

            $sum = 0;
            #echo count($dias2);
            for ($j = 0; $j < count($dias2); $j++) {
                $sum += $dias2[$j];
            }
            $pdf->Cell(15, 6, '              TOTAL DIAS : ' . $sum, 'L', 0, 'L', $fill);
            $pdf->Ln();
            unset($dias2);
        }

        //$resumen1 = $buscar->totafonaviinti($nombre, $ap, $am);
        $resumen1 = $this->model->totafonaviinti($nombre, $ap, $am);
        $pdf->cell(155, 10, "                                                                               TOTAL I/.                       " . $resumen1['bruto'] . "                             " . $resumen1['fonavi'], 1, 1, 'C');



        /* info para NUEVOS SOLES */
        /* Halla los años que tiene aportaciones en FONAVI por NUEVOS SOLES  */
        $sqls = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE moneda = 'S' AND nombres = '$nombre' and ap = '$ap' and am = '$am' AND fonavi <> 0 group by year(spdat1);";

        //$datas = $buscar->AniosTrabajados($sqls);
        $datas = $this->model->AniosTrabajados($sqls);
        $anioinicio3 = array();
        $aini3 = array();

        $i = 0;
        while ($row = $datas->fetch_array(MYSQLI_ASSOC)) {
            $anioinicio3[] = $row['spdat1'];
            $aini3[] = substr($anioinicio3[$i], 0, 4);
            $i++;
        }

        // Data
        $fill = false;
        $dias3 = array();
        $mes3 = array();
        $i = 0;
        foreach ($aini3 as $anio) {
            $pdf->Cell($w[0], 6, "YEAR: " . $anio, 'LR', 0, 'L', $fill);
            $pdf->Ln();
            //$datans = $buscar->fonavis($anio, $nombre, $ap, $am);
            $datans = $this->model->fonavis($anio, $nombre, $ap, $am);

            while ($filas = $datans->fetch_array(MYSQLI_ASSOC)) {
                $anios[] = $filas['spdat1'];
                $mes3[] = substr($anios[$i], 5, 2);

                switch ($mes3[$i]) {
                    case '01':
                        $pdf->Cell(30, 6, "Enero", 'LR', 0, 'L', $fill);
                        break;
                    case '02':
                        $pdf->Cell(30, 6, "Febrero", 'LR', 0, 'L', $fill);
                        break;
                    case '03':
                        $pdf->Cell(30, 6, "Marzo", 'LR', 0, 'L', $fill);
                        break;
                    case '04':
                        $pdf->Cell(30, 6, "Abril", 'LR', 0, 'L', $fill);
                        break;
                    case '05':
                        $pdf->Cell(30, 6, "Mayo", 'LR', 0, 'L', $fill);
                        break;
                    case '06':
                        $pdf->Cell(30, 6, "Junio", 'LR', 0, 'L', $fill);
                        break;
                    case '07':
                        $pdf->Cell(30, 6, "Julio", 'LR', 0, 'L', $fill);
                        break;
                    case '08':
                        $pdf->Cell(30, 6, "Agosto", 'LR', 0, 'L', $fill);
                        break;
                    case '09':
                        $pdf->Cell(30, 6, "Setiembre", 'LR', 0, 'L', $fill);
                        break;
                    case '10':
                        $pdf->Cell(30, 6, "Octubre", 'LR', 0, 'L', $fill);
                        break;
                    case '11':
                        $pdf->Cell(30, 6, "Noviembre", 'LR', 0, 'L', $fill);
                        break;
                    case '12':
                        $pdf->Cell(30, 6, "Diciembre", 'LR', 0, 'L', $fill);
                        break;
                    default:
                        $pdf->Cell(30, 6, "No reconocido", 'LR', 0, 'L', $fill);
                        break;
                }

                $fecha1 = new DateTime($filas['spdat1']);
                $fecha2 = new DateTime($filas['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $dias3[] = $diff->days + 1;

                #echo $sum;
                // El resultados sera 3 dias3
                #echo $diff->days . ' dias3';

                $pdf->Cell(10, 6, $diff->days + 1, 'LR', 0, 'L', $fill);
                $pdf->Cell(45, 6, $filas['cargo'], 'LR', 0, 'L', $fill);
                $pdf->Cell(35, 6, $filas['bruto'], 'LR', 0, 'R', $fill);
                $pdf->Cell(35, 6, $filas['fonavi'], 'LR', 0, 'R', $fill);

                $pdf->Ln();
                $fill = !$fill;
                $i++;
            }

            $sum = 0;
            #echo count($dias3);
            for ($j = 0; $j < count($dias3); $j++) {
                $sum += $dias3[$j];
            }
            $pdf->Cell(15, 6, '              TOTAL DIAS : ' . $sum, 'L', 0, 'L');
            $pdf->Ln();
            unset($dias3);

        }

        //$resumen1 = $buscar->totafonavisoles($nombre, $ap, $am);
        $resumen1 = $this->model->totafonavisoles($nombre, $ap, $am);
        $pdf->cell(155, 10, "                                                                               TOTAL NS/.                       " . $resumen1['bruto'] . "                             " . $resumen1['fonavi'], 1, 1, 'C');

        $pdf->Cell(20, 5, 'Lo que se expide a solicitud del interesado conforme a los descuentos en Planilla de Remuneraciones con la moneda de los', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(20, 3, 'años que se le pago.', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(20, 4, 'SO/. = Sol de Oro        I/.= Intis         NS/.= Nuevos Soles', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(165, 6, 'Puno, ' . date('d') . ' de ' . date('M') . '  de ' . date('Y'), 0, 0, 'R');


        $pdf->Output();
    }

}






?>