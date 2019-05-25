<?php
include_once('./conexionBD.php');
error_reporting(E_ALL ^ E_NOTICE);

class Turno
{
    //CONTROLAR TURNO PARA VER SI YA EXISTE
    function controlarTurno($cancha, $fecha, $horario)
    {
        $con = ConexionBD::getConexion();
        $sql = "SELECT * FROM usuario_x_cancha WHERE cancha_id_cancha='$cancha' AND fecha ='$fecha' AND hora='$horario' AND estado=1";
        $existe = $con->existe($sql);
        return $existe;
    }
    
    //RESERVAR TURNO
    function  reservarTurno($nombre, $apellido, $contacto, $cancha, $fecha, $horario)
    {
        $con = ConexionBD::getConexion();
        $sql = "INSERT INTO RESERVA (nombre,apellido,contacto,cancha,fecha,horario) VALUES ('$nombre','$apellido','$contacto','$cancha','$fecha','$horario')";
        $resultado = $con->insertar($sql);
        return $resultado;
    }
    //REGISTRAR SOLICITUD DE TURNO
    function  registrarSolicitudDeTurno($email, $hora, $cancha, $fecha)
    {
        $con = ConexionBD::getConexion();
        $sql = "INSERT INTO usuario_x_cancha (usuario_email,cancha_id_cancha,hora,fecha,estado) VALUES ('$email','$cancha','$hora','$fecha',0)";
        $resultado = $con->insertar($sql);
        return $resultado;
    }

    //ELIMINAR TURNO
    function eliminarTurno($id,$hora,$fecha){
        $con = ConexionBD::getConexion();
        $sql = "DELETE FROM usuario_x_cancha WHERE cancha_id_cancha='$id' AND hora='$hora' AND fecha='$fecha' ";
        $operacion = $con->insertar($sql);
        return $operacion;
    }

    //MOSTRAR TODOS LOS TURNOS
    function mostrarTurnos($fecha)
    {
        $muestra_color=null;
        $color = null;
        $respuesta = array();
        $con = ConexionBD::getConexion();
        $sql = "SELECT * FROM usuario_x_cancha WHERE fecha ='$fecha' AND estado=1 ORDER BY hora,cancha_id_cancha";

        $respuesta = $con->recuperar($sql);
        //control de resultado
        if (empty($respuesta)){ //si esta vacio el array entonces quiere decir que no hay turnos en la fecha
                return -1;
            } else {
            echo "<div class='table-responsive'>
                                    <table class='table'>
                                        <thead class='text-primary'>
                                            <th style='font-weight:bold;'>
                                                Hora
                                            </th>
                                            <th style='font-weight:bold;'>
                                            Reserva
                                            </th>
                                            <th style='font-weight:bold;'>
                                               Cancha
                                            </th>
                                            <th style='font-weight:bold;'>
                                               Acción
                                            </th>
                                        </thead>";
            echo "<tbody>";
            //comienzo foreach

            foreach ($respuesta as $turno) {
                echo "<tr>
                        <td>";
                echo "<p>";
                echo $turno[2];
                echo "</p>";
                echo "</td>";

                $color = $turno[1];
                if ($color == 1) {
                      $color = "tomato";
                      $muestra_color="Roja";
                } elseif ($color == 2) {
                    $color = "MediumSeaGreen";
                    $muestra_color="Verde";
                } else {
                    $color = "blue";
                    $muestra_color="Azul";
                }
                echo "<td>";
                echo "<a style='cursor:pointer;color:tomato;font-size:18px;' class='float-left'>";
                echo $turno[0];
                echo " ";
                //echo $turno[2];
                echo "</a>";
                echo "</td>";
                echo "<td style='border:2px solid $color;' class='text-center'>";
                echo "<p style='font-weight:bold;font-size:18px;color:$color;'>";
                echo $muestra_color;
                echo "</td>
                        <td class='text-center'>
                        <i onclick=eliminar_turno($turno[1],$turno[2],'$turno[3]') class='fas fa-trash-alt'  style='padding:5px;color:tomato;cursor:pointer;font-size:20px;'></i>
                        </td>

                </tr>";
            }
            echo "</tbody>
                           </table>
                           </div>";
                           
        }
    }

    //MOSTRAR TURNOS POR COLOR DE CANCHA
    function mostrarTurnosPorCancha($fecha, $color_cancha)
    {

        $color = null;
        $muestra_color=null;
        $respuesta = array();
        $con = ConexionBD::getConexion();
        $sql = "SELECT * FROM usuario_x_cancha WHERE fecha ='$fecha' AND cancha_id_cancha='$color_cancha' AND estado=1 ORDER BY hora";
        $respuesta = $con->recuperar($sql);
        //control de resultado
        if (empty($respuesta)) //si esta vacio el array entonces quiere decir que no hay turnos en la fecha
            {
                return -1;
            } else {
            echo "<div class='table-responsive'>
                                    <table class='table'>
                                        <thead class='text-primary'>
                                            <th style='font-weight:bold;'>
                                                Hora
                                            </th>
                                            <th style='font-weight:bold;'>
                                            Reserva
                                            </th>
                                            <th style='font-weight:bold;'>
                                               Cancha
                                            </th>
                                            <th style='font-weight:bold;'>
                                               Acción
                                            </th>
                                        </thead>";
            echo "<tbody>";
            //comienzo foreach

            foreach ($respuesta as $turno) {
                echo "<tr>
                        <td>";
                echo "<p>";
                echo $turno[2];
                echo "</p>";
                echo "</td>";

                $color = $turno[1];
                if ($color == 1) {
                      $color = "tomato";
                      $muestra_color="Roja";
                } elseif ($color == 2) {
                    $color = "MediumSeaGreen";
                    $muestra_color="Verde";
                } else {
                    $color = "blue";
                    $muestra_color="Azul";
                }
                echo "<td class='clearfix' style='cursor:pointer;font-size:18px;'>";
                echo "<a style='cursor:pointer;color:tomato;font-size:18px;' class='float-left'>";
                echo $turno[0];
                echo " ";
                //echo $turno[2];
                echo "</a>";
                echo "</td>";
                echo "<td style='border:2px solid $color;' class='text-center'>";
                echo "<p style='font-weight:bold;font-size:18px;color:$color;'>";
                echo $muestra_color;
                echo "</td>
                        <td class='text-center'>
                        <i onclick=eliminar_turno($turno[1],$turno[2],'$turno[3]') class='fas fa-trash-alt'  style='padding:5px;color:tomato;cursor:pointer;font-size:20px;'></i>
                        </td>

                </tr>";
            }
            echo "</tbody>
                           </table>
                           </div>";
        }
    }

    function mostrarTurnosPorCanchaUser($fecha, $color_cancha)
    {
        $color = null;
        $respuesta = array();
        $con = ConexionBD::getConexion();
        $sql = "SELECT hora,estado FROM usuario_x_cancha WHERE fecha ='$fecha' AND cancha_id_cancha='$color_cancha'";
        
        $respuesta = $con->recuperar($sql);

        echo "<div class='table-responsive'>
                <table class='table'>
                    <thead>
                        <tr style='display: flex; flex-direction:column;'>
                            <th class='text-primary' style='font-weight:bold; display: flex; flex-direction:row; justify-content:space-around'>
                            <div style='width:100%; display:flex; justify-content:center;'>    
                                <p>Hora</p>
                            </div>
                            <div style='width:100%; display:flex; justify-content:center;'>
                                <p>Disponibilidad</p>
                            </div>
                            </th>
                    </thead>";
        echo "<tbody>";
        $horario = 17;
        $bandera=0;
        while ($horario <= 23) {
            echo "<tr><td style='display:flex;flex-direction:row; justify-content:space-around;'>
                    <div style=' width:100%;display:flex; justify-content:center; align-items:center;'>
                        <p>$horario</p>
                    </div>
                    <div style='width:100%; display:flex; justify-content:center;'>";

            foreach ($respuesta as $hora) {
                if ($horario == $hora[0]){ 
                    $bandera = 1;
                    $estado=$hora[1];
                }
            }

            if ($bandera == 1 AND $estado==1) {
                echo "<button type='button' class='btn btn-danger disabled' data-dismiss='modal' id='$horario'>Reservado</button>";
            } else if($bandera==1 AND $estado==0){
                echo "<button type='button' class='btn btn-info disabled' data-dismiss='modal'  style='margin:0' id='$horario'>Pendiente</button>";
            }
            else {
                echo "<button type='button' class='btn btn-success' data-dismiss='modal'  style='margin:0' id='$horario' onclick='RealizarSolicitud($horario)'>Reservar</button>";
            }
            $bandera = 0;
            $horario = $horario + 1;
        }
        echo "</div></td></tr><tr><td></td></tr></tbody></div>";
    }

    function mostrarTurnosPendientes($email)
    {
        $con = ConexionBD::getConexion();
        $sql = "SELECT cancha_id_cancha,hora,fecha FROM usuario_x_cancha WHERE usuario_email='$email' AND estado=0 ";
        $respuesta = $con->recuperar($sql);
        //control de resultado
        if (empty($respuesta)){
            return -1;
        }else{

            foreach ($respuesta as $turno_pendiente)
            {
                echo "<div class='card'>
                    <div class='card-body'>
                       <div class='d-flex'>
                            <div class='p-2 mr-auto'>
                                <p class='card-title'>Fecha: $turno_pendiente[2]</p>
                           </div>

                            <div class='p-2'>
                                <p class='card-title'>Hora:  $turno_pendiente[1] hs</p>
                            </div>
                        </div>
                            <p class='card-text' style='font-size:17px;'>Turno esperando respuesta</p>
                            <a href='#' class='card-link btn btn-danger' style='font-weight:bold;'>Cancelar Solicitud</a>
                         
                    </div>

                </div>";
            }

        }


    }
}
