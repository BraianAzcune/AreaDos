<?php
//EL NOMBRE NO ES APROPIADO, el valiente que se atreva que le ponga un nombre acorde.
//Esta clase se encarga de manejar a los clientes conectados a websocket
//Mantiene un array de "clientes" que se utiliza para notificarles cuando ocurra algun evento.
//Ante un error o desconexion el cliente es sacado de este array.
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $clave;


    public function __construct() {
        $this->clients = new \SplObjectStorage();
        echo "Server WebSocket iniciado\n";
        echo "No cerrar esta ventana\n";
        $this->clave="ClaveParaEvitarQueUnUsuarioHagaMacanas  1239d12je09321u9d2138120831yr0fd134__^1¡23123";
    }


     //Detectara si lo recibido es algun comando por parte nuestra, si no coicide nada, se imprime por consola
     private function Analizar($from,$msg){
        //Decodificamos el mensaje
        $mensaje=json_decode($msg);

        //Sea administrador o usuario tiene que llegar un comando y un mensaje.
        if(isset($mensaje->comando) && isset($mensaje->msg)){
        
            //vemos si es administrador.
            if(isset($mensaje->clave) && $mensaje->clave==$this->clave){
                switch($mensaje->comando){
                    case "estaConectado":
                        $this->estaConectado($mensaje->msg,$from);
                        break;
                    case "TurnoPendienteConfirmado":
                        $this->TurnoPendienteConfirmado($mensaje->comando,$mensaje->msg);
                        break;
                    default:
                        echo "LLEGO un comando no reconocido: ".$mensaje->comando;
                }
            }else{
            //Si se entra aqui deberia ser usuario
                switch($mensaje->comando){
                    case "registrarEmail":
                        $this->registrarEmail($mensaje->msg,$from);
                        break;
                    default:
                        echo "LLego un comando no reconocido: ".$mensaje->comando;
                }
            }


        }



    }



    /**
     * TurnoPendienteConfirmado
     * Recibe un comando y el email del usuario al que debe notificarle, que se confirmo el turno.
     * Y envia el mensaje al usuario donde el json tiene
     * json="{"comando":"TurnoPendienteConfirmado"}"
     *
     * @param string $comando="TurnoPendienteConfirmado" (deberia ser siempre eso)
     * @param string $emailUsuario
     * @return void
     */
    private function TurnoPendienteConfirmado($comando,$emailUsuario){
        $conn=$this->obtenerConexion($emailUsuario);
        if($conn){
            $respuesta = new \stdClass();
            $respuesta->comando=$comando;

            $enviar=json_encode($respuesta);
            $conn->send($enviar);
        }else{
            //NO IMPLEMENTADO
            //Se deberia enviar email, o decirle a notificarUsuario que no se pudo, y que el envie el email
        }
    }
    
    /**
     * registrarEmail
     *El primer mensaje que debe enviar un usuario al servidor websocket, es registrarEmail, esto, es para
     *que despues, se pueda localizar una conexion segun email.
     *
     * @param string $email
     * @param ConnectionInterface $from
     * @return void
     */
    private function registrarEmail($email,$from){
        $this->clients->offsetSet($from,$email);
    }

    
    /**
     * obtenerConexion
     *Dado un email retorna la conexion para ese email, sino hay nada retorna falso
     * 
     * @param string $email
     * @return ConnectionIterface/false
     */
    private function obtenerConexion($email){
        $respuesta=false;
        foreach($this->clients as $conn){
            if($this->clients[$conn]==$email){
                $respuesta=$conn;
                break;
            }
        }
        return $respuesta;
    }

    
    /**
     * estaConectado
     * Envia un mensaje a quien invoque, respondiendo en formato json, si esta conectado o no.
     * json="{"respuesta":true}"
     *
     * @param string $email
     * @param ConnectionInterface $aQuienResponder
     * @return void(envia un mensaje a connectionInterface)
     */
    private function estaConectado($email,$aQuienResponder){
        
        $respuesta = new \stdClass();
        $respuesta->respuesta=FALSE;


        foreach($this->clients as $conn){
            if($this->clients[$conn]==$email){
                $respuesta->respuesta=TRUE;
                break;
            }
        }

        $enviar=json_encode($respuesta);
        $aQuienResponder->send($enviar);//Return
        
    }


    //DE ACA PARA ABAJO HAY CODIGO NO INVOLUCRADO CON NUESTRO PROYECTO
    //________________________________________________________________
    //________________________________________________________________
    //________________________________________________________________
    //________________________________________________________________

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        //Creamos un nuevo cliente, con su conexion y sin email.
        $this->clients->offsetSet($conn);//Ojo esto es una tabla hash con doble parametro.

        echo "New connection! ({$conn->resourceId})\n";

    }

    public function onMessage(ConnectionInterface $from, $msg) {
        //Debug
        
        echo sprintf('Conexion %d envia mensaje: "%s"' . "\n", $from->resourceId, $msg);
        //Fin Debug

        $this->Analizar($from, $msg);

    }

   

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->offsetUnset($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }
    
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        //Si ocurre algun error por aqui, borar esto de abajo, y probar.
        $this->clients->offsetUnset($conn);

        $conn->close();
    }
}