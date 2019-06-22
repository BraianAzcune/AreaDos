<?php
    session_start();
    header('Access-Control-Allow-Origin: *');
    include_once('./turno.php');
    include_once('./usuario.php');

    $fecha=$_POST['fecha'];
    $color_cancha=$_POST['cancha'];
    $email=$_SESSION["email"];

    $t=new Turno();
    $u=new Usuario();
    $r=$u->esAdmin($email);
   
    if($r==1){
         $t->mostrarSolicitudesPorCancha($fecha,$color_cancha);
    }else{
        $t->mostrarTurnosPendientesPorCancha($email,$fecha,$color_cancha);
    }
 ?>