<?php
class ImpresionModel extends Model
{
	function __construct()
	{
		parent::__construct();
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

	function buscarxId($id)
	{
		$sql ="SELECT nombres, ap, am FROM mtc.planilla WHERE id = $id;";
		$data = $this->conn->ConsultaArray($sql);
		return $data;
	}
}