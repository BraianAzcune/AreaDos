<?php
header('Access-Control-Allow-Origin: *');
    include('./turno.php');

    $fecha=$_POST['fecha'];
    $t=new Turno();
    $t->mostrarTurnos($fecha);
?>