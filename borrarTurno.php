<?php
    include_once("./turno.php");
    error_reporting(E_ALL^E_NOTICE);

    $id=$_POST["id"];
    $hora=$_POST["hora"];
    $fecha=$_POST["fecha"];

    $t=new Turno();
    $operacion=$t->eliminarTurno($id,$hora,$fecha);
    echo $operacion;
?>