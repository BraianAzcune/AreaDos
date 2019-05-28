<?php
session_start();
header('Access-Control-Allow-Origin: *');

if (!isset($_SESSION['email']) || ($_SESSION['tipo']!=true)){
        
    echo "Error: falta de credenciales, no eres administrador";
    
} 
    


    include('./turno.php');

    $email=$_POST['email'];
    $hora=$_POST['hora'];
    $cancha=$_POST['cancha'];
    $fecha=$_POST['fecha'];
    $t=new Turno();
    
    echo $t->confirmarSolicitudDeTurno($email,$hora,$cancha,$fecha);
  
?>