<?php

class PlanillaDetalleModel extends Model
{
  function __construct()
  {
    parent::__construct();
  }
  // Obtiene solo datos del personal
  public function GetPlanillaPersonal($id){
    $sql = "SELECT id, nombres, ap, am FROM planilla WHERE id = '$id';";
    $res = $this->conn->ConsultaArray($sql);
    return $res;
  }
  public function GetPlanilla($nombres,$ap,$am,$mes,$anio)
  {
    $sql = "SELECT * FROM planilla 
    WHERE nombres = '$nombres' AND ap='$ap' AND am = '$am' 
    AND MONTH(spdat1) = $mes AND YEAR(spdat1) = $anio;";
    $data = $this->conn->ConsultaArray($sql);
    return $data;
  }
  public function Update($id,$condicion, $nombres, $apellidopa, $apellidoma, $fechaI, $fechaF, $cargo, $rembasica, $remunifi, $ds276, $remotros, $ley19990, $ley20530, $afp, $ipss, $fonavi, $moneda, $trabajador, $muc, $vet, $idpersonal){
    $sql = "UPDATE planilla SET `condiper` = '$condicion', `nombres` = '$nombres', `ap` = '$apellidopa', `am` = '$apellidoma', `spdat1` = '$fechaI', `spdat2` = '$fechaF', `cargo` = '$cargo', `rembasica` = '$rembasica', `remunifi` = '$remunifi', `ds276` = '$ds276', `remotros` = '$remotros', `ley19990` = '$ley19990', `ley20530` = '$ley20530', `afp` = '$afp', `ipss` = '$ipss', `fonavi` = '$fonavi', `moneda` = '$moneda', `trabajador` = '$trabajador', `muc` = '$muc', `vet` = '$vet', `idpersonal` = '$idpersonal' WHERE (`id` = '$id');";
    $res = $this->conn->ConsultaSin($sql);
    return $res;
  }
  public function GetAllPlanilla($nombres,$ap,$am){
    $sql = "SELECT id, CONCAT(nombres,' ',ap,' ',am) AS nombres,cargo, spdat1 AS fecha_inicial, spdat2 AS fecha_final FROM planilla WHERE nombres = '$nombres' AND ap='$ap' AND am = '$am' ORDER BY spdat1 DESC;";
    $data = $this->conn->ConsultaCon($sql);
    return $data;   
  }
}