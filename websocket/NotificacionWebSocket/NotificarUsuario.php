<?php
//Clase para enviar notificaciones a los usuarios

require_once "Notificar.php";


class NotificarUsuario extends Notificar{
    
    private $emailUsuario;
    
    
    /**
     * __construct
     *
     * Se debe dar el email del usuario
     * @param string $email
     */
    public function __construct($email) {
        parent::__construct();
        $this->emailUsuario=$email;
    }

    
    /**NO IMPLEMENTADO
     * TurnoPendienteConfirmado
     * Envia una notificacion al usuario con el email puesto en el constructor
     * con el comando que tiene un turno confirmado
     * si el usuario no esta conectado se le enviara un email notificando.
     * 
     *@param string $mensaje
     *Este debe ser el mensaje que se le enviara por email en caso de que no este conectado.
     *Si esta conectado el sistema refrescara la pagina para avisarle
     * 
     * @return void
     */
    public function TurnoPendienteConfirmado($mensaje){
        //Preguntar si el cliente esta online
        //si esta se le envia la notificacion
        //sino se envia un email
    }
}