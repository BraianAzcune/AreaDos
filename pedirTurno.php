<?php
	include('./turno.php');
	include('./usuario.php');
	error_reporting(E_ALL^E_NOTICE);

	$nombre=$_POST["nombre"];
	$apellido=$_POST["apellido"];
	$contacto=$_POST["contacto"];
	$cancha=$_POST["cancha"];
	$fecha=$_POST["fecha"];
	$horario=$_POST["horario"];

	$t=new Turno();
	$u=new Usuario();
	$mail=$u->getEmail($nombre,$apellido,$contacto);
	$existe=$t->existeTurno($cancha,$fecha,$horario);
	if($existe==true) {
		return -1;
	} else {
		return $t->reservarTurno($mail[0][0],$cancha,$fecha,$horario);
	}
?>