<?php
// SE NECESITA CORRER ESTE CODIGO EN CMD
//Estando en la carpeta websocket escribir 
//php server.php 
//Este codigo se crea de poner al script a la escucha de solicitudes en el puerto 8080
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;

    require dirname(__DIR__) . '/vendor/autoload.php';

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Chat()//Clase al que se le delega la responsabilidad ante eventos
            )
        ),
        8080//PUERTO QUE SE UTILIZA
    );

    $server->run();