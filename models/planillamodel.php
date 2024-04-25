<?php

class PlanillaModel extends Model
{
  function __construct()
  {
    parent::__construct();
  }
  public function Create($condicion, $nombres, $apellidopa, $apellidoma, $fechaI, $fechaF, $cargo, $rembasica, $remunifi, $ds276, $remotros, $ley19990, $ley20530, $afp, $ipss, $fonavi, $moneda, $trabajador, $muc, $vet, $idpersonal){
    $sql = "INSERT INTO `mtc`.`planilla`(`condiper`, `nombres`, `ap`, `am`, `spdat1`, `spdat2`, `cargo`, `rembasica`, `remunifi`, `ds276`, `remotros`, `ley19990`, `ley20530`, `afp`, `ipss`, `fonavi`, `moneda`, `trabajador`, `muc`, `vet`, `idpersonal`)VALUES ('$condicion','$nombres', '$apellidopa', '$apellidoma', '$fechaI', '$fechaF', '$cargo', '$rembasica', '$remunifi','$ds276','$remotros', '$ley19990', '$ley20530', '$afp', '$ipss', '$fonavi', '$moneda', '$trabajador', '$muc', '$vet', '$idpersonal');";
    echo $sql;
    $res = $this->conn->ConsultaSin($sql);
    return $res;
  }
}
