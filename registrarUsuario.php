<?php
include('./usuario.php');
error_reporting(E_ALL^E_NOTICE);

$nombre=$_POST["nombre"];
$apellido=$_POST["apellido"];
$contacto=$_POST["contacto"];
$email=$_POST["email"];
$contrasena=$_POST["contraseña"];


$u = new usuario();
$control= $u->usuarioDisponible($email);

if($control){
    $u->agregarUsuario($nombre,$apellido,$contacto,$email,$contrasena);
    echo 1;
}else{
    echo -1;
}

?>