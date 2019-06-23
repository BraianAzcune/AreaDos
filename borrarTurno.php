<?php
    header('Access-Control-Allow-Origin: *');
    session_start();

    include_once("./turno.php");
    include('./websocket/NotificacionWebSocket/NotificarAdministrador.php');
    error_reporting(E_ALL^E_NOTICE);

    $id=$_POST["id"];
    $hora=$_POST["hora"];
    $fecha=$_POST["fecha"];

    $t=new Turno();
    //buscamos el responsable
    $datosResponsable=$t->darNombreApellidoDadoCiertoTurno($id,$hora,$fecha);//devuelve un array que tiene 1 elemento
    $datosResponsable=array_shift($datosResponsable);//ahora es 1 objeto
    //eliminamos el turno
    $operacion=$t->eliminarTurno($id,$hora,$fecha);
    echo $operacion;

    //Comienza proceso de enviar notificaciones
    if($id == 1) {
        $color="Roja";
    }elseif ($id == 2) {
        $color="Verde";
    }else{
        $color="Azul";
    }
    
    

    //preparamos el mensaje
    $mensaje= "Se cancelo un turno para la fecha ".$fecha." a las ".$hora." hs en la cancha ".$color."\n
    Datos del usuario= ".$datosResponsable[0]." ".$datosResponsable[1]." tel=".$datosResponsable[2];
    if(!$_SESSION['tipo']){
        //Si no es administrador enviamos notificacion al administrador de que le cancelaron un turno confirmado
        $notificar= new NotificarAdministrador();
        $notificar->notificarCancelacionDeTurno($mensaje);
    }

?>