<?php
require_once 'fpdf.php';
require_once '../model/buscar.php';

$buscar = new Buscar();

$nombre = 'HERMOGENES M.';
$ap = 'QUILCA';
$am = 'MORALES';

$sql = "SELECT spdat1,spdat2 FROM mtc.planilla WHERE nombres = '$nombre' and ap = '$ap' and am = '$am' group by year(spdat1);";
$dataa = $buscar->AniosTrabajados($sql);
$anioinicio = array();
$aniofinal  = array();
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
$data = $buscar->AniosTrabajados($sql2);
$fechainicio = array();
$fechafinal  = array();

while ($row1 = mysqli_fetch_array($data)) {
    $fechainicio[] = $row1['spdat1'];
    $fechafinal[] = $row1['spdat2'];
}
// #echo "Inicio: ". $fechainicio[0];
// #echo " Fin:". $fechafinal[count($fechafinal)-1];

class PDF extends FPDF
{
    public $minombre;
    public $fechaInicial;
    public $fechaFinal;

    function Header()
    {
        // Logo
        $this->Image('logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',10);
        // Move to the right
        $this->Cell(1);
        // Title
        $this->Cell(260, 5, 'DIRECCION REGIONAL DE TRANSPORTES, COMUNICACIONES, VIVIENDA Y CONSTRUCCION -  PUNO', 0, 1, 'C');
        $this->Cell(260, 5, 'CONSTANCIA CERTIFICADA DE PAGOS DE REMUNERACIONES Y DESCUENTOS DE ACUERDO A LAS PLANILLAS', 0, 1, 'C');
        $this->Cell(260, 5, 'UNICAS DE PAGO DE REMUNERACIONES CONSTA LOS SERVICIOS PRESTADOS', 0, 1, 'C');
        $this->Cell(20, 1, "DON(ÑA):". $this->minombre, 0, 1, 'L');
        $this->Cell(20, 10, 'FECHA: ', 0, 1, 'L');

    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    // Load data
    function LoadData($file)
    {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach ($lines as $line)
            $data[] = explode(';', trim($line));
        return $data;
    }

    // Simple table
    function BasicTable($header, $data)
    {
        // Header
        foreach ($header as $col)
            $this->Cell(40, 5, 15, 1);
        $this->Ln();
        // Data
        foreach ($data as $row) {
            foreach ($row as $col)
                $this->Cell(40, 6, $col, 1);
            $this->Ln();
        }
    }

    // Better table
    function ImprovedTable($header, $data)
    {
        // Column widths
        $w = array(40, 35, 40, 45);
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        $this->Ln();
        // Data
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR');
            $this->Cell($w[1], 6, $row[1], 'LR');
            $this->Cell(15, 6, number_format($row[2]), 'LR', 0, 'R');
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
            $this->Ln();
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Colored table
    function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(200, 100, 100);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 35, 40, 45);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell(15, 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetFont('Arial', 'B', 8);
$pdf->AddPage();


#$this->Cell(0, 10, "DESDE: ".$fechainicio[0]."    HASTA: ".$fechafinal[count($fechafinal)-1]." ", 0, 1, 'L');
$header = array('Desde', 'Hasta', 'TOT DIA','CARGO', 'BASICA','MUC','BET','REUNIF','D.S.276','OTROS', 'TOTAL REMU','20530','19990','AFP','IPSS','FONAVI');
// Colors, line width and bold font
$pdf->SetFillColor(200, 100, 100);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(128, 0, 0);
$pdf->SetLineWidth(.3);
$pdf->SetFont('', 'B');
// Header
$w = array(20,20,10, 45,15,15,15,15,15,15,15,15,15,15);

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
    $datap = $buscar->DetallexAnio($anio,$nombre,$ap,$am);

    while ($row = mysqli_fetch_array($datap)) {;
        $pdf->Cell(20, 6, $row['spdat1'], 'LR', 0, 'L', $fill);
        $pdf->Cell(20, 6, $row['spdat2'], 'LR', 0, 'L', $fill);
        $fecha1= new DateTime($row['spdat1']);
        $fecha2= new DateTime($row['spdat2']);
        $diff = $fecha1->diff($fecha2);
        $dias[] = $diff->days +1;

        #echo $sum;
        // El resultados sera 3 dias
        #echo $diff->days . ' dias';

        $pdf->Cell(10, 6, $diff->days +1, 'LR', 0, 'L', $fill);
        $pdf->Cell(45, 6, $row['cargo'], 'LR', 0, 'L', $fill);
        $pdf->Cell(15, 6, number_format($row['rembasica']), 'LR', 0, 'R', $fill);
        $pdf->Cell(15, 6, number_format($row['muc']), 'LR', 0, 'R', $fill);
        $pdf->Cell(15, 6, number_format($row['vet']), 'LR', 0, 'R', $fill);
        $pdf->Cell(15, 6, number_format($row['remunifi']), 'LR', 0, 'R', $fill);
        $pdf->Cell(15, 6, number_format($row['ds276']), 'LR', 0, 'R', $fill);
        $pdf->Cell(15, 6, number_format($row['remotros']), 'LR', 0, 'R', $fill);
        $total = $row['rembasica'] + $row['remunifi'] + $row['ds276'] + $row['remotros'];
        $pdf->Cell(15, 6, number_format($total), 'LR', 0, 'R', $fill);
        $pdf->Cell(15, 6, number_format($row['ley20530']), 'LR', 0, 'R', $fill);
        $pdf->Cell(15, 6, number_format($row['ley19990']), 'LR', 0, 'R', $fill);
        $pdf->Cell(15, 6, number_format($row['afp']), 'LR', 0, 'R', $fill);
        $pdf->Cell(15, 6, number_format($row['ipss']), 'LR', 0, 'R', $fill);
        $pdf->Cell(15, 6, number_format($row['fonavi']), 'LR', 0, 'R', $fill);

        $pdf->Ln();
        $fill = !$fill;
    }
        $sum = 0;
        for ($i=0; $i < count($dias); $i++) {
            $sum += $dias[$i];
        }
        $pdf->Cell(15, 6,'      TOTAL DIAS: '. $sum, 'L', 0, 'L', $fill);
        $pdf->Ln();
        /* Limpiando el array*/
        unset($dias);
}
// Closing line


$pdf->Cell(array_sum($w), 0, '', 'T');

$pdf->Output();

