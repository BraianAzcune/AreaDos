<?php
//header('Access-Control-Allow-Origin: *');


//Ejemplo de como utilizar NotificarUsuario/NotificarAdministrador/Notificar, para saber si un usuario esta conectado.

include('../websocket/NotificacionWebSocket/NotificarUsuario.php');



$notificacion= new NotificarUsuario("Pedro");

if($notificacion->estaConectado("tano@hotmail.com")){
    echo "verdad";
}else{
    echo "falso";
}