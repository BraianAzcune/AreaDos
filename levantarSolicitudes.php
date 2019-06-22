<?php
   header('Access-Control-Allow-Origin: *');
    session_start();

        
    if (!isset($_SESSION['email']) || ($_SESSION['tipo']!=true)) {
        
        return "Error: falta de credenciales, no eres administrador";
        
    } 

    include('./turno.php');
    $fecha=$_POST['fecha'];
    $t= new Turno();
    $t->mostrarSolicitudes($fecha);
    
    return $t;
 ?>