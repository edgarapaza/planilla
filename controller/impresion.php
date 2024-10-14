<?php
require_once 'fpdf.php';

class Impresion extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function pdf($param = null)
    {
        $id = $param[0];
        if ($id == null || $id == '')
        {
            $this->view->Render("main/inicio");
        }

        # Calcular la suma total de dias
        $suma_total = array();

        setlocale(LC_TIME, 'es_ES.UTF-8');

        $persona = $this->model->buscarxId($id);
        $nombre = $persona['nombres'];
        $ap = $persona['ap'];
        $am = $persona['am'];
        $consultaFechas = $this->model->consultaFechas($nombre,$ap,$am);

        /* Fechas generales*/
        $sql = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE nombres = '$nombre' and ap = '$ap' and am = '$am' ORDER BY spdat1;";
        $data = $this->model->AniosTrabajados($sql);
        $fechainicio = array();
        $fechafinal = array();

        $t = 0;
        while ($row1 = mysqli_fetch_array($data))
        {
            $fechainicio[$t] = $row1['spdat1'];
            $fechafinal[$t] = $row1['spdat2'];
            $t++;
        }
        // #echo "Inicio: ". $fechainicio[0];
        // #echo " Fin:". $fechafinal[count($fechafinal)-1];
        //  FIN FECHAS GENERALES

        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', 'B', 8);

        $pdf->minombre = $nombre. " " . $ap ." ". $am;
        $pdf->fechaInicial = $fechainicio[0];
        $pdf->fechaFinal = $fechafinal[count($fechafinal)-1];

        $pdf->AddPage();

        $header = array('Desde', 'Hasta', 'Dias', 'CARGO', 'BASICA', 'MUC', 'BET', 'REUNIF', 'D.S.276', 'OTROS', 'TOTAL REMU', '20530', '19990', 'AFP', 'IPSS', 'FONAVI');
        // Colors, line width and bold font
        $pdf->SetFillColor(200, 100, 100);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('', 'B');
        // Header
        $w0 = array(16, 16, 8, 40, 15, 15, 15, 15, 15, 22, 22, 15, 15, 15, 15);

        // Color and font restoration
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        // Data
        $fill = false;

        /* SECCION PARA SOLES DE ORO  */
        $sqlo = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE moneda = 'O' AND nombres = '$nombre' and ap = '$ap' and am = '$am' group by year(spdat1);";

        $datao = $this->model->AniosTrabajados($sqlo);
        $anioinicio1 = array();
        $aini1 = array();
        $a = 0;
        while ($row = $datao->fetch_array(MYSQLI_ASSOC))
        {
            $anioinicio1[$a] = $row['spdat1'];
            $aini1[$a] = substr($anioinicio1[$a], 0, 4);
            $a++;
        }

        $dias1 = array();
        $p = 0;
        foreach ($aini1 as $anio1)
        {
            $pdf->Cell($w0[0], 6, $anio1, 'LR', 0, 'L', $fill);
            $pdf->Ln();
            $data1 = $this->model->DetallexAnioo($anio1, $nombre, $ap, $am);

            while ($row = mysqli_fetch_array($data1))
            {
                $pdf->Cell(16, 6, $row['spdat1'], 'LR', 0, 'L', $fill);
                $pdf->Cell(16, 6, $row['spdat2'], 'LR', 0, 'L', $fill);
                $fecha1 = new DateTime($row['spdat1']);
                $fecha2 = new DateTime($row['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $dias1[] = $diff->days + 1;
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
            for ($e = 0; $e < count($dias1); $e++) {
                $sum1 = $sum1 + $dias1[$e];
            }
            $pdf->Cell(15, 6, '      TOTAL DIAS: ' . $sum1, 'L', 0, 'L', $fill);
            $pdf->Ln();
            /* Limpiando el array*/
            array_push($suma_total, $sum1);
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
        while ($row = $datai->fetch_array(MYSQLI_ASSOC))
        {
            $anioinicio2[$b] = $row['spdat1'];
            $aini2[$b] = substr($anioinicio2[$b], 0, 4);
            $b++;
        }

        $dias2 = array();
        $q = 0;
        foreach ($aini2 as $anio2)
        {
            $pdf->Cell($w0[0], 6, $anio2, 'LR', 0, 'L', $fill);
            $pdf->Ln();
            $data2 = $this->model->DetallexAnioi($anio2, $nombre, $ap, $am);

            while ($row = mysqli_fetch_array($data2))
            {
                $pdf->Cell(16, 6, $row['spdat1'], 'LR', 0, 'L', $fill);
                $pdf->Cell(16, 6, $row['spdat2'], 'LR', 0, 'L', $fill);
                $fecha1 = new DateTime($row['spdat1']);
                $fecha2 = new DateTime($row['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $dias2[] = $diff->days + 1;
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

            $stot1 = 0;
            for ($l = 0; $l < count($dias2); $l++)
            {
                $stot1 = $stot1 + $dias2[$l];
            }

            $pdf->Cell(15, 6, '      TOTAL DIAS: ' . $stot1, 'L', 0, 'L', $fill);
            $pdf->Ln();
            array_push($suma_total, $stot1);
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

        while ($row = $dataS->fetch_array(MYSQLI_ASSOC))
        {
            $anioinicio3[$c] = $row['spdat1'];
            $aini3[$c] = substr($anioinicio3[$c], 0, 4);
            $c++;
        }

        $dias3 = array();
        $r = 0;
        foreach ($aini3 as $anio3)
        {
            $pdf->Cell($w0[0], 6, $anio3, 'LR', 0, 'L', $fill);
            $pdf->Ln();
            $data3 = $this->model->DetallexAnios($anio3, $nombre, $ap, $am);

            while ($row = mysqli_fetch_array($data3))
            {
                $pdf->Cell(16, 6, $row['spdat1'], 'LR', 0, 'L', $fill);
                $pdf->Cell(16, 6, $row['spdat2'], 'LR', 0, 'L', $fill);
                $fecha1 = new DateTime($row['spdat1']);
                $fecha2 = new DateTime($row['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $dias3[] = $diff->days + 1;
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
            for ($n = 0; $n < count($dias3) ; $n++) {
                $sum3 = $sum3 + $dias3[$n];
            }
            $pdf->Cell(15, 6, '      TOTAL DIAS: ' . $sum3, 'L', 0, 'L', $fill);
            $pdf->Ln();
            array_push($suma_total, $sum3);
            /* Limpiando el array*/
            unset($dias3);
        }

        $resumen3 = $this->model->planillas($nombre, $ap, $am);
        $pdf->cell(275, 10, "                                                                               TOTAL NS/.                       " . $resumen3['bruto'], 1, 1, 'C');


        $pdf->Cell(array_sum($w0), 0, '', 'T');

        $pdf->Ln(10);
        #MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])

        #####################################################################################################
        ###########      RESUMEN
        #####################################################################################################

        $pdf->AddPage();
        $pdf->Ln(10);
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

        $sumu1 =0;
        for($u=1; $u< count($suma_total);$u++)
        {
            $sumu1 = $sumu1 + $suma_total[$u];
        }
        #echo "Total de dias: " . $sumu1;

        $totalDias = $sumu1;

        // Un año tiene 365 días
        $años = floor($totalDias / 365);

        // Restamos los días completos de los años para obtener los días restantes
        $diasRestantes = $totalDias % 365;

        // Un mes promedio tiene 30.44 días
        $meses = floor($diasRestantes / 30.44);

        // Restamos los días completos de los meses para obtener los días restantes
        $dias = round($diasRestantes % 30.44);

        #echo "$totalDias días son aproximadamente $años años, $meses meses y $dias días.";
        //$consultaFechas = $this->model->consultaFechas($nombre,$ap,$am);
        $date_inicio = new DateTime($consultaFechas['inicio']);
        $date_final = new DateTime($consultaFechas['final']);
    
        // Calcular la diferencia
        $interval = $date_inicio->diff($date_final);
    
        // Obtener los años, meses y días
        $aniosServicio = $interval->y;
        $mesesServicio = $interval->m;
        $diasServicio = $interval->d;
        $info = "De lo detallado de las paginas, se desprende que Don(ña):  " . $ap . " " . $am . ", " . $nombre . " ha prestado sus servicios al Estado desde " . $fecInicio1 . " hasta " . $fecInicio2 . " durante ".$años." años, ".$meses." meses y ". $dias ." dia(s), en condicion de " . $tipoemleado . " con el cargo de " . $resum['cargo'] . " con una remuneración de:";

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

    function pdfFecha()
    {
        echo $this->view->d1;
        echo $this->view->d2;
        echo $this->view->d3;


    }

    // FUNCION PARA CONVERTIR A ISO-8859-1 Y USAR ENIE
    function utf8_to_iso88591($string) {
        return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $string);
    }


    /***************************************************************************/
    /***************************************************************************/
    /************          F   O    N   A   V   I   ***************************/
    /***************************************************************************/
    /***************************************************************************/

    public function fonavi($param = null)
    {
        $id = $param[0];
        $persona = $this->model->buscarxId($id);
        $nombre = $persona['nombres'];
        $ap = $persona['ap'];
        $am = $persona['am'];

        setlocale(LC_TIME, 'es_ES.UTF-8');

        /* Para mostrar la fecha inicio y la fecha final*/
        $sqlfechas = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE nombres = '$nombre' and ap = '$ap' and am = '$am' AND fonavi <> 0 ORDER BY spdat1;";

        $datafechasF = $this->model->AniosTrabajados($sqlfechas);
        $fechainiciof1 = array();
        $fechafinalf1 = array();

        $f1=0;
        while ($rowfechas = $datafechasF->fetch_array(MYSQLI_ASSOC))
        {
            $fechainiciof1[$f1] = $rowfechas['spdat1'];
            $fechafinalf1[$f1] = $rowfechas['spdat2'];
            $f1++;
        }
        // #echo "Inicio: ". $fechainiciof1[0];
        // #echo " Fin:". $fechafinalf1[count($fechafinalf1)-1];


        /* Halla los años que tiene aportaciones en FONAVI por SOLES DE ORO*/
        $sqlfo = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE moneda = 'O' AND nombres = '$nombre' and ap = '$ap' and am = '$am' AND fonavi <> 0 group by year(spdat1);";

        $datofo = $this->model->AniosTrabajados($sqlfo);
        $anioinicioforo = array();
        $ainifo = array();

        $g = 0;
        while ($rowo = $datofo->fetch_array(MYSQLI_ASSOC))
        {
            $anioinicioforo[$g] = $rowo['spdat1'];
            $ainifo[$g] = substr($anioinicioforo[$g], 0, 4);
            $g++;
        }


        $pdf = new Fonavi('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', 'B', 8);

        $pdf->minombre = $nombre. " " . $ap ." ". $am;
        $pdf->fechaInicial = $fechainiciof1[0];
        $pdf->fechaFinal = $fechafinalf1[count($fechafinalf1)-1];

        $pdf->AddPage();

        $header = array('PERIODO', 'DIA', 'CARGO', 'TOTAL REMENU', 'FONAVI');
        // Colors, line width and bold font
        $pdf->SetFillColor(200, 100, 100);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('', 'B');
        // Header
        $w1 = array(30, 10, 45, 35, 35);

        for ($u = 0; $u < count($header); $u++)
        {
            $pdf->Cell($w1[$u], 7, $header[$u], 1, 0, 'C', true);
        }
        $pdf->Ln();
        // Color and font restoration
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        # id, spdat1, spdat2,cargo, sum(rembasica +remunifi+ds276+remotros) as bruto, fonavi
        // Data
        $fill = false;

        $anioo = array();
        $mesfo = array();
        $diasfo = array();
        $v = 0;
        foreach ($ainifo as $aniof1)
        {
            $pdf->Cell($w1[0], 6, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "Año:  ") . $aniof1, 'LR', 0, 'L', $fill);
            $pdf->Ln();

            $datafo1 = $this->model->fonavio($aniof1, $nombre, $ap, $am);

            while ($filafo = $datafo1->fetch_array(MYSQLI_ASSOC))
            {
                $anioo[$v] = $filafo['spdat1'];
                $mesfo[$v] = substr($anioo[$v], 5, 2);

                switch ($mesfo[$v]) {
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

                $fecha1 = new DateTime($filafo['spdat1']);
                $fecha2 = new DateTime($filafo['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $diasfo[] = $diff->days + 1;

                #echo $sum;
                // El resultados sera 3 dias
                #echo $diff->days . ' dias';

                $pdf->Cell(10, 6, $diff->days + 1, 'LR', 0, 'L', $fill);
                $pdf->Cell(45, 6, $filafo['cargo'], 'LR', 0, 'L', $fill);
                $pdf->Cell(35, 6, $filafo['bruto'], 'LR', 0, 'R', $fill);
                $pdf->Cell(35, 6, $filafo['fonavi'], 'LR', 0, 'R', $fill);

                $pdf->Ln();
                $fill = !$fill;
                $v++;
            }

            $sumfo = 0;

            for ($a1 = 0; $a1 < count($diasfo); $a1++)
            {
                $sumfo = $sumfo + $diasfo[$a1];
            }

            $pdf->Cell(15, 6, '              TOTAL DIAS : ' . $sumfo, 'L', 0, 'L', $fill);
            $pdf->Ln();
            unset($diasfo);
        }

        $resumenf1 = $this->model->totafonavioro($nombre, $ap, $am);
        $pdf->cell(155, 10, "                                                                               TOTAL SO/.                       " . $resumenf1['bruto'] . "                             " . $resumenf1['fonavi'], 1, 1, 'C');


        /* *****************************************************************************/
        /* info para Intis */
        /* *****************************************************************************/
        /* Halla los años que tiene aportaciones en FONAVI por intis  */
        $sqlfi = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE moneda = 'I' AND nombres = '$nombre' and ap = '$ap' and am = '$am' AND fonavi <> 0 group by year(spdat1);";


        $datafi = $this->model->AniosTrabajados($sqlfi);
        $anioiniciofi2 = array();
        $ainifi2 = array();

        $b1 = 0;
        while ($fila4 = $datafi->fetch_array(MYSQLI_ASSOC))
        {
            $anioiniciofi2[$b1] = $fila4['spdat1'];
            $ainifi2[$b1] = substr($anioiniciofi2[$b1], 0, 4);
            $b1++;
        }

        // Data
        $fill = false;
        $aniofi2 = array();
        $mes2 = array();
        $diasfi = array();

        $c1 = 0;
        foreach ($ainifi2 as $aniof2)
        {
            $pdf->Cell($w1[0], 6, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "Año:  ") . $aniof2, 'LR', 0, 'L', $fill);
            $pdf->Ln();

            $datafi2 = $this->model->fonavii($aniof2, $nombre, $ap, $am);

            while ($filafi2 = $datafi2->fetch_array(MYSQLI_ASSOC)) {
                $aniofi2[$c1] = $filafi2['spdat1'];
                $mes2[$c1] = substr($aniofi2[$c1], 5, 2);

                switch ($mes2[$c1]) {
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

                $fecha1 = new DateTime($filafi2['spdat1']);
                $fecha2 = new DateTime($filafi2['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $diasfi[] = $diff->days + 1;

                #echo $sum;
                // El resultados sera 3 dias2
                #echo $diff->days . ' dias2';

                $pdf->Cell(10, 6, $diff->days + 1, 'LR', 0, 'L', $fill);
                $pdf->Cell(45, 6, $filafi2['cargo'], 'LR', 0, 'L', $fill);
                $pdf->Cell(35, 6, $filafi2['bruto'], 'LR', 0, 'R', $fill);
                $pdf->Cell(35, 6, $filafi2['fonavi'], 'LR', 0, 'R', $fill);

                $pdf->Ln();
                $fill = !$fill;
                $c1++;
            }

            $sumf2 = 0;

            for ($j2 = 0; $j2 < count($diasfi); $j2++) {
                $sumf2 += $diasfi[$j2];
            }
            $pdf->Cell(15, 6, '              TOTAL DIAS : ' . $sumf2, 'L', 0, 'L', $fill);
            $pdf->Ln();
            unset($diasfi);
        }

        //$resumen1 = $buscar->totafonaviinti($nombre, $ap, $am);
        $resumenf2 = $this->model->totafonaviinti($nombre, $ap, $am);
        $pdf->cell(155, 10, "                                                                               TOTAL I/.                       " . $resumenf2['bruto'] . "                             " . $resumenf2['fonavi'], 1, 1, 'C');



        /* info para NUEVOS SOLES */
        /* Halla los años que tiene aportaciones en FONAVI por NUEVOS SOLES  */
        $sqlfs = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE moneda = 'S' AND nombres = '$nombre' and ap = '$ap' and am = '$am' AND fonavi <> 0 group by year(spdat1);";

        $datafs = $this->model->AniosTrabajados($sqlfs);
        $anioiniciof3 = array();
        $ainif3 = array();

        $i3 = 0;
        while ($fila5 = $datafs->fetch_array(MYSQLI_ASSOC)) {
            $anioiniciof3[$i3] = $fila5['spdat1'];
            $ainif3[$i3] = substr($anioiniciof3[$i3], 0, 4);
            $i3++;
        }

        // Data
        $fill = false;

        $aniosf3 = array();
        $mesf3 = array();
        $diasf3 = array();
        $i5 = 0;
        foreach ($ainif3 as $aniof3) {
            $pdf->Cell($w1[0], 6, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "Año:  ") . $aniof3, 'LR', 0, 'L', $fill);
            $pdf->Ln();

            $datafns = $this->model->fonavis($aniof3, $nombre, $ap, $am);

            while ($filafs = $datafns->fetch_array(MYSQLI_ASSOC))
            {
                $aniosf3[$i5] = $filafs['spdat1'];
                $mesf3[$i5] = substr($aniosf3[$i5], 5, 2);

                switch ($mesf3[$i5]) {
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

                $fecha1 = new DateTime($filafs['spdat1']);
                $fecha2 = new DateTime($filafs['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $diasf3[] = $diff->days + 1;

                #echo $sum;
                // El resultados sera 3 dias3
                #echo $diff->days . ' dias3';

                $pdf->Cell(10, 6, $diff->days + 1, 'LR', 0, 'L', $fill);
                $pdf->Cell(45, 6, $filafs['cargo'], 'LR', 0, 'L', $fill);
                $pdf->Cell(35, 6, $filafs['bruto'], 'LR', 0, 'R', $fill);
                $pdf->Cell(35, 6, $filafs['fonavi'], 'LR', 0, 'R', $fill);

                $pdf->Ln();
                $fill = !$fill;
                $i5++;
            }

            $sumf33 = 0;

            for ($j4 = 0; $j4 < count($diasf3); $j4++) {
                $sumf33 = $sumf33 + $diasf3[$j4];
            }
            $pdf->Cell(15, 6, '              TOTAL DIAS : ' . $sumf33, 'L', 0, 'L');
            $pdf->Ln();
            unset($diasf3);

        }

        //$resumen1 = $buscar->totafonavisoles($nombre, $ap, $am);
        $resumenf3 = $this->model->totafonavisoles($nombre, $ap, $am);
        $pdf->cell(155, 10, "                                                                               TOTAL NS/.                       " . $resumenf3['bruto'] . "                             " . $resumenf3['fonavi'], 1, 1, 'C');

        $pdf->Cell(20, 5, 'Lo que se expide a solicitud del interesado conforme a los descuentos en Planilla de Remuneraciones con la moneda de los', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(20, 3, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "años que se le pago."), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(20, 4, 'SO/. = Sol de Oro        I/.= Intis         NS/.= Nuevos Soles', 0, 0, 'L');
        $pdf->Ln();


        $fecActual = strftime("%d de %B del %Y");

        $pdf->Cell(180, 7, "Puno, ". $fecActual, 0, 0, 'R');

        $pdf->Output();
    }

}

?>