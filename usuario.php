<?php
header('Access-Control-Allow-Origin: *');
include_once('./conexionBD.php');
error_reporting(E_ALL^E_NOTICE);

class Usuario{
    function usuarioDisponible($email) {
        $con=ConexionBD::getConexion();
        $sql="SELECT * FROM USUARIO WHERE email='$email';";
        $respuesta=$con->existe($sql);
        
        if($respuesta){
            
            return false;
        }else {
            return true;
        }
    }
    function agregarUsuario($nombre,$apellido,$contacto,$email,$pass){
        $con=ConexionBD::getConexion();
        $sql="INSERT INTO USUARIO (email,nombre,apellido,contacto,password,tipo_usuario) VALUES ('$email',
        '$nombre','$apellido','$contacto','$pass',0)";
        $con->insertar($sql);
    }
    function verificarUsuario($email,$pass){
        $con=ConexionBD::getConexion();
        $sql="SELECT * FROM USUARIO WHERE email='$email' AND password='$pass';";
        return $con->existe($sql);
    }
    function verificarContraseña($email,$pass){
        $con=ConexionBD::getConexion();
        $sql="SELECT * FROM USUARIO WHERE email='$email' AND password='$pass';";
        return $con->existe($sql);
    }
    function cambiarContraseña($email,$pass){
        $con=ConexionBD::getConexion();
        $sql="UPDATE USUARIO SET password='$pass' WHERE email='$email';";
        $con->update($sql);
    }
    function esAdmin($email){
        $con=ConexionBD::getConexion();
        $sql="SELECT * FROM usuario WHERE email = '$email' AND tipo_usuario = 1";
        return $con->existe($sql);
    }
}
?> 

