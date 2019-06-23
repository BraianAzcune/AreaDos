<?php
//Clase para enviar notificaciones a los administradores

require_once "Notificar.php";
require_once "./conexionBD.php";

class NotificarAdministrador extends Notificar{
    

    /**
     * notificarNuevaSolicitud
     *Envia una notificacion a todos los administradores, si no hay ninguno conectado
     *Chat.php enviara un email a algun administrador.
     * @return void
     */
    public function notificarNuevaSolicitud(){
    
        $bd = ConexionBD::getConexion();
        //Tomamos el email de todos los administradores
        $query = "SELECT email FROM usuario WHERE tipo_usuario = 1;";
        $respuesta = $bd->recuperar_asociativo($query);

        $list=array();
        foreach($respuesta as $user){
            
            array_push($list,$user);
        }
        $listStringJSON=json_encode($list);


        $JSON= $this->darFormato("notificarNuevaSolicitud",$listStringJSON);
        $this->enviar($JSON);
    }



    /**
     * notificarCancelacionDeTurno
     *Envia una notificacion a todos los administradores de que se cancelo un turno que estaba reservado
     *
     * @param string $mensaje
     * @return void
     */
    public function notificarCancelacionDeTurno($mensaje){
        $bd = ConexionBD::getConexion();
        //Tomamos el email de todos los administradores
        $query = "SELECT email FROM usuario WHERE tipo_usuario = 1;";
        $respuesta = $bd->recuperar_asociativo($query);

        $list=array();
        array_push($list,$mensaje);
        foreach($respuesta as $user){
            
            array_push($list,$user);
        }

        $listStringJSON=json_encode($list);

        $JSON= $this->darFormato("notificarCancelacionDeTurno",$listStringJSON);
        $this->enviar($JSON);
    }


}