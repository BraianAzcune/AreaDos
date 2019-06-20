<?php
   header('Access-Control-Allow-Origin: *');
    session_start();

    include('./turno.php');

    $email=$_SESSION['email'];
    $t= new Turno();
    $t->mostrarTurnosConfirmados($email);
    
    return $t;
 ?>