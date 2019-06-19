<?php
//Clase base para enviar Notificaciones

//Dependencias usadas para enviar mensajes por sockets.
require('./vendor/autoload.php');
use WebSocket\Client;

class Notificar{

    protected $urlServidorWebSocket;
    protected $clave;

    public function __construct($url="ws://localhost:8080"){
        $this->urlServidorWebSocket=$url;
        $this->clave="ClaveParaEvitarQueUnUsuarioHagaMacanas  1239d12je09321u9d2138120831yr0fd134__^1¡23123";
    }

    
    /**
     * enviar
     *Envia mensaje a Chat.php, se debe pasar un string en formato json,(usar darFormato())
     * @param stringJson $msg
     * @return void
     */
    public function enviar($msg="Mensaje por defecto"){

        $client = new Client($this->urlServidorWebSocket);
        $client->send($msg);
        $client->close();
    }

    
    /**
     * darFormato
     * Todos los mensajes enviados al servidor websocket, deben pasar por este metodo antes de enviarse.
     * TODOS los mensajes tienen un comando, msg, y clave.
     *
     * @param string $comando
     * @param string $msg
     * @return stringJSON
     */
    protected function darFormato($comando,$msg){
        $mensaje = new \stdClass();
        $mensaje->comando=$comando;//Comando solicitado al servidorWebSocket
        $mensaje->msg=$msg;//El mensaje, dependiendo el comando se espera una u otra cosa
        $mensaje->clave=$this->clave;//clave para asegurar que somos nosotros
        
        $myJSON = json_encode($mensaje);
        
        

        return $myJSON;
    }

    
    /**
     * estaConectado
     *Dado el email, retorna verdadero si esta conectado el usuario.
     * @param string $email
     * @return boolean
     */
    public function estaConectado($email){

        $msg=$this->darFormato("estaConectado",$email);
        $client = new Client($this->urlServidorWebSocket);
        $client->send($msg);

        $recibido=$client->receive();
        //echo "mensaje crudo: ".$recibido."<br>";
        $client->close();

        $respuesta=json_decode($recibido);
       
        
        return $respuesta->respuesta;

    }

}