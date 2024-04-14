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
  public function Search($data){
    $sql = "SELECT id, CONCAT(nombres,' ',ap,' ',am) AS nombres, cargo, fecha_inicial, fecha_final FROM tabla WHERE nombres LIKE '%$data%' OR ap LIKE '%$data%';";
    $res = $this->conn->ConsultaCon($sql);
    return $res;
  }


}