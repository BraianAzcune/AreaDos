<?php
include('./usuario.php');
error_reporting(E_ALL^E_NOTICE);

$nombre=$_POST["nombre"];
$apellido=$_POST["apellido"];
$contacto=$_POST["contacto"];
$email=$_POST["email"];
$contraseña=$_POST["contraseña"];


$u = new usuario();
$control=$u->usuarioDisponible($email);
if($control==-1){
$u->agregarUsuario($nombre,$apellido,$contacto,$email,$contraseña);
}
else{
    echo -1;
}

?>