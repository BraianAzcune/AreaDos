<?php  
session_start();

include('./usuario.php');
//error_reporting(E_ALL^E_NOTICE);


$nombre_usuario=$_SESSION['email'];
 

$contrasena=$_POST["contrasena"];
$nuevaContrasena=$_POST["nuevaContrasena"];

$u = new usuario();
$control=$u->verificarContraseña($nombre_usuario,$contrasena);


if($control){
    
    $u->cambiarContraseña($nombre_usuario,$nuevaContrasena);  

/* if (isset($_SESSION['email'])) {
    echo '<script>localStorage.removeItem("email");
        localStorage.removeItem("pass");
        localStorage.removeItem("recordar"); </script>';
 } */
 //cerrar sesion
    
    echo 1;

}else{
    echo -1;
}

?>