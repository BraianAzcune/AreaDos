<?php
session_start();
header('Access-Control-Allow-Origin: *');
error_reporting(E_ALL ^ E_NOTICE);
    include('./turno.php');

    $email=$_SESSION['email'];
    $hora=$_POST['hora'];
    $cancha=$_POST['cancha'];
    $fecha=$_POST['fecha'];
    $t=new Turno();
    return $t->registrarSolicitudDeTurno($email,$hora,$cancha,$fecha);
  
?>