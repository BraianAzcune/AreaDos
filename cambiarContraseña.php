<?php
include('./usuario.php');
error_reporting(E_ALL^E_NOTICE);

$nombre_usuario=$_POST["nombre_usuario"];
$contraseña=$_POST["contraseña"];
$nuevaContraseña=$_POST["nuevaContraseña"];

$u = new usuario();
$control=$u->verificarContraseña($nombre_usuario,$contraseña);
if($control){
$u->cambiarContraseña($nombre_usuario,$nuevaContraseña);    
}
else{
    echo -1;
}

?>