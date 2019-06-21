<?php
session_start();
header('Access-Control-Allow-Origin: *');

if (!isset($_SESSION['email']) || ($_SESSION['tipo']!=true)){
        
    echo "Error: falta de credenciales, no eres administrador";
    
} 
    

    include('./websocket/NotificacionWebSocket/NotificarUsuario.php');
    include('./turno.php');

    $email=$_POST['email'];
    $hora=$_POST['hora'];
    $cancha=$_POST['cancha'];
    $fecha=$_POST['fecha'];
    $t=new Turno();
    
    $resultado=$t->confirmarSolicitudDeTurno($email,$hora,$cancha,$fecha);
    echo $resultado;//para avisarle al javascript que se inserto bien


//Codigo agregado para NotificarTurnoPendienteConfirmado
    //Convertimos numero de cancha a color 1 rojo, 2 verde, 3 azul
    if($cancha == 1) {
        $color="Roja";
    }elseif ($cancha == 2) {
        $color="Verde";
    }else{
        $color="Azul";
    }

    //Preparamos el mensaje que se le enviara por email, en caso de que este desconectado
    $mensaje="Se confirmo su turno para la cancha ".$color." a las ".$hora." hs, para la fecha ".$fecha;


    //si se inserto bien, enviamos notificacion.
    if($resultado){
        $notificar= new NotificarUsuario($email);
        $notificar->TurnoPendienteConfirmado($mensaje);
    }
  
?>