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
        $persona = $this->model->buscarxId($id);
        $nombre = $persona['nombres'];
        $ap = $persona['ap'];
        $am = $persona['am'];

        $sql = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE nombres = '$nombre' and ap = '$ap' and am = '$am' group by year(spdat1);";
        $dataa = $this->model->AniosTrabajados($sql);

        $anioinicio = array();
        $aniofinal = array();
        $aini = array();
        $afin = array();

        $i = 0;
        while ($row = $dataa->fetch_array(MYSQLI_ASSOC)) {
            $anioinicio[] = $row['spdat1'];
            $aini[] = substr($anioinicio[$i], 0, 4);
            $i++;
        }
        # Muestra el array de años que ha trabajado
        /*for($i = 0; $i < count($aini); $i++){
            echo $aini[$i]."<br>";
        }*/
        $sql2 = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE nombres = '$nombre' and ap = '$ap' and am = '$am';";
        $data = $this->model->AniosTrabajados($sql2);
        $fechainicio = array();
        $fechafinal = array();

        while ($row1 = mysqli_fetch_array($data)) {
            $fechainicio[] = $row1['spdat1'];
            $fechafinal[] = $row1['spdat2'];
        }
        // #echo "Inicio: ". $fechainicio[0];
        // #echo " Fin:". $fechafinal[count($fechafinal)-1];

        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->AddPage();

        /* Agregando nombre*/
        $pdf->SetXY(30, 21);
        $pdf->Cell(0, 10, $nombre . " " . $ap . " " . $am, 0, 1, 'L');
        $pdf->SetXY(30, 27);
        $pdf->Cell(0, 10, $fechainicio[0] . " HASTA " . $fechafinal[count($fechafinal) - 1], 0, 1, 'L');
        #$this->Cell(0, 10, "DESDE: ".$fechainicio[0]."    HASTA: ".$fechafinal[count($fechafinal)-1]." ", 0, 1, 'L');
        $header = array('Desde', 'Hasta', 'TOT DIA', 'CARGO', 'BASICA', 'REUNIFICADA', 'D.S.276', 'OTROS', 'TOTAL REMU', '20530', '19990', 'AFP', 'IPSS', 'FONAVI');
        // Colors, line width and bold font
        $pdf->SetFillColor(200, 100, 100);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('', 'B');
        // Header
        $w = array(20, 20, 10, 50, 15, 15, 15, 15, 25, 15, 15, 15, 15, 15);

        for ($i = 0; $i < count($header); $i++)
            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $pdf->Ln();
        // Color and font restoration
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        // Data
        $fill = false;
        $dias = array();

        foreach ($aini as $anio) {
            $pdf->Cell($w[0], 6, $anio, 'LR', 0, 'L', $fill);
            $pdf->Ln();
            $datap = $this->model->DetallexAnio($anio, $nombre, $ap, $am);

            while ($row = mysqli_fetch_array($datap)) {
                ;
                $pdf->Cell(20, 6, $row['spdat1'], 'LR', 0, 'L', $fill);
                $pdf->Cell(20, 6, $row['spdat2'], 'LR', 0, 'L', $fill);
                $fecha1 = new DateTime($row['spdat1']);
                $fecha2 = new DateTime($row['spdat2']);
                $diff = $fecha1->diff($fecha2);
                $dias[] = $diff->days + 1;

                #echo $sum;
                // El resultados sera 3 dias
                #echo $diff->days . ' dias';

                $pdf->Cell(10, 6, $diff->days + 1, 'LR', 0, 'L', $fill);
                $pdf->Cell(50, 6, $row['cargo'], 'LR', 0, 'L', $fill);
                $pdf->Cell(15, 6, number_format($row['rembasica']), 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, number_format($row['remunifi']), 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, number_format($row['ds276']), 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, number_format($row['remotros']), 'LR', 0, 'R', $fill);
                $total = $row['rembasica'] + $row['remunifi'] + $row['ds276'] + $row['remotros'];
                $pdf->Cell(25, 6, number_format($total), 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, number_format($row['ley20530']), 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, number_format($row['ley19990']), 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, number_format($row['afp']), 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, number_format($row['ipss']), 'LR', 0, 'R', $fill);
                $pdf->Cell(15, 6, number_format($row['fonavi']), 'LR', 0, 'R', $fill);

                $pdf->Ln();
                $fill = !$fill;
            }
            $sum = 0;
            for ($i = 0; $i < count($dias); $i++) {
                $sum += $dias[$i];
            }
            $pdf->Cell(15, 6, '      TOTAL DIAS: ' . $sum, 'L', 0, 'L', $fill);
            $pdf->Ln();
            /* Limpiando el array*/
            unset($dias);
        }
        // Closing line
        $pdf->Cell(array_sum($w), 0, '', 'T');
        $pdf->Output();
    }

}






?>