<?php
require_once 'Conexion.php';

class Buscar
{
	public $conn;
	function __construct()
	{
		$this->conn = new Conexion();
		return $this->conn;
	}

	function AniosTrabajados($sql)
	{
		$data = $this->conn->ConsultaCon($sql);
		return $data;
	}

	function DetallexAnio($anio,$nombres,$ap,$am)
	{
		$sql = "SELECT * FROM mtc.planilla WHERE nombres = '$nombres' and ap = '$ap' and am = '$am' and spdat1 LIKE '$anio%' ORDER BY spdat1 ASC;";
		$data = $this->conn->ConsultaCon($sql);
		return $data;
	}
}
