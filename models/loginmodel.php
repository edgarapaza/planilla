<?php

class LoginModel extends Model
{
  function __construct()
  {
    parent::__construct();
  }

  function Validar($username, $password)
  {
    $sql = "SELECT idpersonal, nivusu, chkusu FROM login WHERE username = '$username' AND passwd = '$password' LIMIT 1;";
    $res = $this->conn->ConsultaArray($sql);
    return $res;
  }
}