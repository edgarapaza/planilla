<?php

class LoginModel extends Model
{
  function __construct()
  {
    parent::__construct();
  }

  function Validar($username, $password)
  {
    $sql = "SELECT l.idpersonal, (SELECT concat(p.nombre,' ',p.apellido) FROM mtc.personal as p WHERE p.idpersonal = l.idpersonal) as personal,l.nivusu,l.chkusu FROM login as l WHERE l.usuario = '$username' AND l.passwd = '$password' LIMIT 1;";
    $res = $this->conn->ConsultaArray($sql);
    return $res;
  }
  function ValidarUsuario($username)
  {
    $sql = "SELECT l.idpersonal,l.usuario, l.passwd, (SELECT concat(p.nombre,' ',p.apellido) FROM mtc.personal as p WHERE p.idpersonal = l.idpersonal) as personal,l.nivusu,l.chkusu FROM login as l WHERE l.usuario = '$username' LIMIT 1;";
    $res = $this->conn->ConsultaArray($sql);
    return $res;
  }
  public function bitacora($idpersonal, $fecha, $hora, $tipo,$ip){
    $sql ="INSERT INTO `mtc`.`bitacora` (`idpersonal`, `fecha`, `hora`, `tipo`,`ip`) VALUES ('$idpersonal', '$fecha', '$hora', '$tipo','$ip');";
    $res = $this->conn->ConsultaSin($sql);
    return $res;
  }
  public function bitacoraSalir($idpersonal, $hora, $fecha){
    $sql ="UPDATE `mtc`.`bitacora` SET `horasalida` = '$hora', `tiempo` = TIMESTAMPDIFF(MINUTE,hora,horasalida) WHERE `idpersonal` = '$idpersonal' and fecha = '$fecha';
    ";
    $res = $this->conn->ConsultaSin($sql);
    return $res;
  }
  

}