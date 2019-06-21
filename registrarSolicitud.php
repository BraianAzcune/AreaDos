<?php
session_start();
header('Access-Control-Allow-Origin: *');
error_reporting(E_ALL ^ E_NOTICE);
    include('./turno.php');
    include('./websocket/NotificacionWebSocket/NotificarAdministrador.php');

    $email=$_SESSION['email'];
    $hora=$_POST['hora'];
    $cancha=$_POST['cancha'];
    $fecha=$_POST['fecha'];
    $t=new Turno();
    $respuesta=$t->registrarSolicitudDeTurno($email,$hora,$cancha,$fecha);
    
    //Se envian la notificacion al administrador.

    $notificar= new NotificarAdministrador();
    $notificar->notificarNuevaSolicitud();
    //Fin enviar notificacion admin

    return $respuesta;

?>