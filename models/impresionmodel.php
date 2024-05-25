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
	function DetallexAnio($anio, $nombres, $ap, $am)
	{
		$sql = "SELECT * FROM mtc.planilla WHERE nombres = '$nombres' and ap = '$ap' and am = '$am' and spdat1 LIKE '$anio%' ORDER BY spdat1 ASC;";
		$data = $this->conn->ConsultaCon($sql);
		return $data;
	}
	function buscarxId($id)
	{
		$sql = "SELECT nombres, ap, am FROM mtc.planilla WHERE id = $id;";
		$data = $this->conn->ConsultaArray($sql);
		return $data;
	}
	function DetallexAnioo($anio,$nombre,$ap,$am)
	{
		$sql = "SELECT id,condiper,nombres,ap,am,spdat1,spdat2,cargo,format(rembasica,2) as rembasica,format(remunifi,2) as remunifi,format(ds276,2) as ds276,format(remotros,2) as remotros,format(ley19990,2) as ley19990,format(ley20530,2) as ley20530,format(afp,2) as afp,format(ipss,2) as ipss,format(fonavi,2) as fonavi,moneda,trabajador,muc,vet,idpersonal, format(rembasica+remunifi+ds276+remotros,2) as bruto
			FROM mtc.planilla WHERE moneda = 'O' AND nombres = '$nombre' and ap = '$ap' and am = '$am' and spdat1 LIKE '$anio%' ORDER BY spdat1 ASC;";
		$data = $this->conn->ConsultaCon($sql);
		return $data;
	}

	function DetallexAnioi($anio,$nombre,$ap,$am)
	{
		$sql = "SELECT id,condiper,nombres,ap,am,spdat1,spdat2,cargo,format(rembasica,2) as rembasica,format(remunifi,2) as remunifi,format(ds276,2) as ds276,format(remotros,2) as remotros,format(ley19990,2) as ley19990,format(ley20530,2) as ley20530,format(afp,2) as afp,format(ipss,2) as ipss,format(fonavi,2) as fonavi,moneda,trabajador,muc,vet,idpersonal, format(rembasica+remunifi+ds276+remotros,2) as bruto
			FROM mtc.planilla WHERE moneda = 'I' AND nombres = '$nombre' and ap = '$ap' and am = '$am' and spdat1 LIKE '$anio%' ORDER BY spdat1 ASC;";
		$data = $this->conn->ConsultaCon($sql);
		return $data;
	}

	function DetallexAnios($anio,$nombre,$ap,$am)
	{
		$sql = "SELECT id,condiper,nombres,ap,am,spdat1,spdat2,cargo,format(rembasica,2) as rembasica,format(remunifi,2) as remunifi,format(ds276,2) as ds276,format(remotros,2) as remotros,format(ley19990,2) as ley19990,format(ley20530,2) as ley20530,format(afp,2) as afp,format(ipss,2) as ipss,format(fonavi,2) as fonavi,moneda,trabajador,muc,vet,idpersonal, format(rembasica+remunifi+ds276+remotros+muc+vet,2) as bruto
			FROM mtc.planilla WHERE moneda = 'S' AND nombres = '$nombre' and ap = '$ap' and am = '$am' and spdat1 LIKE '$anio%' ORDER BY spdat1 ASC;";
		$data = $this->conn->ConsultaCon($sql);
		return $data;
	}

	function planillao($nombre,$ap,$am)
	{
		$sql ="SELECT spdat1, spdat2,cargo,trabajador,format(sum(rembasica +remunifi+ds276+remotros),2) as bruto
		FROM planilla
		WHERE moneda = 'O' AND ap = '$ap' AND am='$am' AND nombres ='$nombre';";
		$data = $this->conn->ConsultaArray($sql);
		return $data;
	}

	function planillai($nombre,$ap,$am)
	{
		$sql ="SELECT spdat1, spdat2,cargo,trabajador, format(sum(rembasica +remunifi+ds276+remotros),2) as bruto
		FROM planilla
		WHERE moneda = 'I' AND ap = '$ap' AND am='$am' AND nombres ='$nombre';";
		$data = $this->conn->ConsultaArray($sql);
		return $data;
	}

	function planillas($nombre,$ap,$am)
	{
		$sql ="SELECT spdat1, spdat2,cargo,trabajador, format(sum(rembasica+remunifi+ds276+remotros+muc+vet),2) as bruto
		FROM planilla
		WHERE moneda = 'S' AND ap = '$ap' AND am='$am' AND nombres ='$nombre';";
		$data = $this->conn->ConsultaArray($sql);
		return $data;
	}
	// ****************************************************************
	/* CONSULTAS PARA FONAVI */
	// ****************************************************************|

	function fonavio($anio, $nombre, $ap, $am)
	{
		$sql = "SELECT id, spdat1, spdat2,cargo, format(sum(rembasica +remunifi+ds276+remotros),2) as bruto, format(fonavi,2) as fonavi
			FROM mtc.planilla
			WHERE moneda='O' AND ap = '$ap' AND am='$am' AND nombres ='$nombre' AND fonavi <> 0 AND spdat1 LIKE '$anio%' group by spdat1;";
		$data = $this->conn->ConsultaCon($sql);
		return $data;
	}
	function fonavii($anio, $nombre, $ap, $am)
	{
		$sql = "SELECT id, spdat1, spdat2,cargo, format(sum(rembasica +remunifi+ds276+remotros),2) as bruto, format(fonavi,2) as fonavi
			FROM mtc.planilla
			WHERE moneda='I' AND ap = '$ap' AND am='$am' AND nombres ='$nombre' AND fonavi <> 0 AND spdat1 LIKE '$anio%' group by spdat1;";
		$data = $this->conn->ConsultaCon($sql);
		return $data;
	}
	function fonavis($anio, $nombre, $ap, $am)
	{
		$sql = "SELECT id, spdat1, spdat2,cargo, format(sum(rembasica +remunifi+ds276+remotros),2) as bruto, format(fonavi,2) as fonavi
			FROM mtc.planilla
			WHERE moneda='S' AND ap = '$ap' AND am='$am' AND nombres ='$nombre' AND fonavi <> 0 AND spdat1 LIKE '$anio%' group by spdat1;";
		$data = $this->conn->ConsultaCon($sql);
		return $data;
	}

	function totafonavioro($nombre, $ap, $am)
	{
		$sql = "SELECT format(sum(rembasica +remunifi+ds276+remotros),2) as bruto, format(sum(fonavi),2) as fonavi
		FROM planilla
		WHERE moneda = 'O' AND ap = '$ap' AND am='$am' AND nombres ='$nombre' AND fonavi <> 0;";
		$data = $this->conn->ConsultaArray($sql);
		return $data;
	}
	function totafonaviinti($nombre, $ap, $am)
	{
		$sql = "SELECT format(sum(rembasica +remunifi+ds276+remotros),2) as bruto, format(sum(fonavi),2) as fonavi
		FROM planilla
		WHERE moneda = 'I' AND ap = '$ap' AND am='$am' AND nombres ='$nombre' AND fonavi <> 0;";
		$data = $this->conn->ConsultaArray($sql);
		return $data;
	}
	function totafonavisoles($nombre, $ap, $am)
	{
		$sql = "SELECT format(sum(rembasica +remunifi+ds276+remotros),2) as bruto, format(sum(fonavi),2) as fonavi
		FROM planilla
		WHERE moneda = 'S' AND ap = '$ap' AND am='$am' AND nombres ='$nombre' AND fonavi <> 0;";
		$data = $this->conn->ConsultaArray($sql);
		return $data;
	}
}
