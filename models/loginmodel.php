<?php

class LoginModel extends Model
{
  function __construct()
  {
    parent::__construct();
  }

  function Validar($username, $password)
  {
    $sql = "SELECT (SELECT concat(p.nombre,' ',p.apellido) FROM mtc.personal as p WHERE p.idpersonal = l.idpersonal) as personal,l.nivusu,l.chkusu FROM login as l WHERE l.usuario = '$username' AND l.passwd = '$password' LIMIT 1;";
    $res = $this->conn->ConsultaArray($sql);
    return $res;
  }

}