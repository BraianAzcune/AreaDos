<?php
header('Access-Control-Allow-Origin: *');
include_once('./conexionBD.php');
error_reporting(E_ALL ^ E_NOTICE);

	$con = ConexionBD::getConexion();

	//---------------------------COnsulta para devolver el usuario que saco mas turnos---------------------------------

	$consulta="SELECT COUNT(usuario_email), usuario_email
				FROM usuario_x_cancha
				WHERE estado=1
				GROUP BY usuario_email
				HAVING COUNT(usuario_email) > 1";
	$usuario = $con->recuperar($consulta);

//---------------------------COnsulta para devolver la cancha mas reservada--------------------------------
$consulta="SELECT COUNT(cancha_id_cancha), cancha_id_cancha
				FROM usuario_x_cancha
				WHERE estado=1
				GROUP BY cancha_id_cancha
				HAVING COUNT(cancha_id_cancha) > 1";
	$cancha = $con->recuperar($consulta);
	if($cancha[0][1]==1)
	{
		$color_cancha="Roja";
	}elseif($cancha[0][1]==2){
		$color_cancha="Verde";
	}else {
		$color_cancha="Azul";
	}

//---------------------------COnsulta para devolver el horario  mas reservado-------------------------------
$consulta="SELECT COUNT(hora), hora
				FROM usuario_x_cancha
				WHERE estado=1
				GROUP BY hora
				HAVING COUNT(hora) > 1";
	$hora = $con->recuperar($consulta);

echo "
		<div class='container' style='background:hsl(0, 0%, 24%);padding:15px;'>
		    	<h4 class='card-title text-center' style='font-weight:bold;color:white;'>Centro de Estadísticas</h4>
		 </div>
		<div class='card shadow p-4 mb-4 bg-white'>
		  <div class='card-body'>
		   <i><img src='https://img.icons8.com/color/48/000000/stadium.png'>Cancha mas Reservada: </i>";echo "<span class='badge badge-secondary' style='font-size:16px;'>";echo $color_cancha;echo "</span>";echo "<hr>
		    <i><img src='https://img.icons8.com/color/48/000000/time-span.png'>Horario mas Reservado: </i>";echo "<span class='badge badge-secondary' style='font-size:16px;'>";echo $hora[0][1];echo "</span>";echo "<hr>
		    <i><img src='https://img.icons8.com/color/50/000000/messi.png'>Jugador con mas Reservas: </i>";echo "<span class='badge badge-secondary' style='font-size:16px;'>";echo $usuario[0][1];echo "</span>"; echo "
		  </div>	
		</div>";


?>