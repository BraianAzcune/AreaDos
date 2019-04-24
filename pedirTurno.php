<?php
	include('./turno.php');
	error_reporting(E_ALL^E_NOTICE);

	$nombre=$_POST["nombre"];
	$apellido=$_POST["apellido"];
	$contacto=$_POST["contacto"];
	$cancha=$_POST["cancha"];
	$fecha=$_POST["fecha"];
	$horario=$_POST["horario"];

	$t=new Turno();

	$existe=$t->controlarTurno($cancha,$fecha,$horario);
	if($existe==true) {
		return -1;
	
	} else {
		$resultado=$t->reservarTurno($nombre,$apellido,$contacto,$cancha,$fecha,$horario);
		return $resultado;
	}
?>