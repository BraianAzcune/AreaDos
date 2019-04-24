<?php
   header('Access-Control-Allow-Origin: *');
    include('./conexionBD.php');

        $fecha =$_POST['fecha'];
        $id_cancha = $_POST['id_cancha']; 
        $respuesta = array();
        $con = ConexionBD::getConexion();
        $sql = "SELECT hora FROM usuario_x_cancha WHERE fecha ='$fecha' AND cancha_id_cancha='$id_cancha' AND estado=1 ORDER BY hora";
        $respuesta = $con->recuperar($sql);
        //control de resultado
        if (empty($respuesta)) //si esta vacio el array entonces quiere decir que no hay turnos en la fecha
            {
                echo -1;
            }
        else{
                 echo json_encode($respuesta);

            }

 ?>