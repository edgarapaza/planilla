<?php

class MainModel extends Model
{
  function __construct()
  {
    parent::__construct();
  }
  public function Read(){
    $sql = "SELECT id, CONCAT(nombres,' ',ap,' ',am) AS nombres,cargo, fecha_inicial, fecha_final FROM tabla;";
    $res = $this->conn->ConsultaCon($sql);
    return $res;
  }
  public function Search($nombres,$ap,$am,$cargo){
    $sql = "SELECT id, CONCAT(nombres,' ',ap,' ',am) AS nombres, cargo, fecha_inicial, fecha_final FROM tabla WHERE nombres LIKE '%$nombres%' AND ap LIKE '%$ap%' AND am LIKE '%$am%' AND cargo LIKE '%$cargo%';";
    $res = $this->conn->ConsultaCon($sql);
    return $res;
  }
  // Solo mostrar datos de una planilla por ID ==== SI ES NECESARIO CAMBIAR POR NOMBRES, AP, AM Y CARGO
  public function GetPlanilla($id){
    $sql = "SELECT id, nombres, ap, am, cargo FROM planilla WHERE id = '$id';";
    $res = $this->conn->ConsultaArray($sql);
    return $res;
  }


}