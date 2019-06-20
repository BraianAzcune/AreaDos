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
	$resultado= -1;//-
	$email=$u->getEmail($nombre,$apellido,$contacto);
	if(!empty($email)){// si no esta vacio, existe el usuario
		$existe=$t->existeTurno($cancha,$fecha,$horario);
		if(!$t->existeTurno($cancha,$fecha,$horario)){ //si el turno no exite aun
			if($t->reservarTurno($email[0][0],$cancha,$fecha,$horario)){
				$resultado=1;
			} //lo reservo
			else{
				$resultado=0;
			}
		}
		else{
			$resultado=0;
		}

	}
	echo $resultado //-1 signidica que el usuario no existe, 0 el turno no esta disponible o error al cargar, 1 se cargo con exito
?>