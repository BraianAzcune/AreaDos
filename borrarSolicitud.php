<?php
   header('Access-Control-Allow-Origin: *');
   error_reporting(E_ALL^E_NOTICE);
    include_once("./turno.php");
    

    $email=$_POST['email'];
    $id=$_POST["id"];
    $hora=$_POST["hora"];
    $fecha=$_POST["fecha"];

    $t=new Turno();
    $operacion=$t->eliminarSolicitud($email,$id,$hora,$fecha);
    echo $operacion;
?>