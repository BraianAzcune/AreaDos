<?php

    session_start();
    
    if (!isset($_SESSION['email']) || ($_SESSION['tipo']!=false)) {
        
            header('Location: Ingresar.php');
    }
    
?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Area Dos</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/now-ui-dashboard.css?v=1.0.1" rel="stylesheet" />
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="dark">
            <div class="logo">
                <a class="simple-text logo-normal" style="font-weight:bold;" id="saludoParaUsuario">
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li>
                        <a href="#">
                            <i class=""></i>
                            <p id="Ver_Turnos">Ver Turnos</p>
                        </a>
                    </li>
                      <li>
                        <a href="#">
                            <i class=""></i>
                            <p id="TurnosPendientes">Turnos Pendientes</p>
                        </a>
                    </li>
                      <li>
                        <a href="#">
                            <i class=""></i>
                            <p id="">Mis Turnos</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Comienzo de barra de navegacion -->
            <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" style="font-weight:bold; font-size:2.3em;">Area Dos</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <!--Aca a futuro podria ir un buscador-->
                        <form>
                            <div class="input-group no-border" style="display:none;">
                                <input type="text" value="" class="form-control" placeholder="Search...">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                                </span>
                            </div>
                        </form>

                        <!--Fin futuro buscador-->
                        <ul class="navbar-nav">
                            <!--Aca podrian ir un item para la barra de navegacion-->
                            <li class="nav-item" style="display: none;">
                                <a class="nav-link" href="#pablo">
                                    <i class="now-ui-icons media-2_sound-wave"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Stats</span>
                                    </p>
                                </a>
                            </li>
                            <!--Aca podrian ir un item para la barra de navegacion-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <p style="font-weight:bold;">Mi Cuenta</p>
                                    <p>
                                        <span class="d-lg-none d-md-block">Mi Cuenta</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">Datos Personales</a>
                                    <a class="dropdown-item" href="#">
                                        <p data-toggle="modal" data-target="#ModalCambiarContrasena">Cambiar Contrase&ntildea</p>
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="cerrarSesion()">Cerrar Sesión</a>
                                </div>
                            </li>

                            <!--Aca podrian ir un item para la barra de navegacion-->
                            <li class="nav-item" style="display: none;">
                                <a class="nav-link" href="#pablo">
                                    <i class="now-ui-icons users_single-02"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block"></span>
                                    </p>
                                </a>
                            </li>
                            <!--Aca podrian ir un item para la barra de navegacion-->

                        </ul>
                    </div>
                </div>
            </nav>
            <!-- FIN barra de navegacion -->
            <div class="panel-header panel-header-sm"></div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <!--comienzo Carta-->
                        <div class="card">
                            <div class="card-header clearfix" id="turnos">
                                <h4 class="card-title text-center" id="titulo_Pendientes"></h4>
                                <div class="text-center ">
                                    <div class="row" id="contenedor_canchasYfecha">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <label for="sel1" style="font-size:18px;"> Fecha:</label>
                                            <input style="padding:8px;" type="date" name="dias" id="dias" value=""
                                                data-toggle="tooltip"
                                                title="Aqui podras seleccionar la fecha y te mostrara una tabla con los horarios y turnos reservados para las respectivas canchas!"
                                                onchange="seleccionarCancha()" />
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="sel1" style="font-size:18px;"> Filtrar por:</label>
                                                <select class="form-control" onchange="seleccionarCancha()"
                                                    id="filtrado">
                                                    <option selected="selected">Cancha Roja</option>
                                                    <option> Cancha Verde</option>
                                                    <option>Cancha Azul</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="contenedor">
                                           
                                            
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--fin Carta-->
                        </div>
                    </div>
                </div>
                
                <!--Modal para cambiar contraseña-->
            <!-- Modal -->
            <div class="modal fade" id="ModalCambiarContrasena">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar contraseña</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="contraseña">Ingrese contrase&ntildea actual:</label>
                                <input type="text" class="form-control" name="contrasena">
                            </div>
                            <div class="form-group">
                                <label for="nuevaContraseña">Ingrese nueva contrase&ntildea:</label>
                                <input type="text" class="form-control" name="nuevaContrasena">
                            </div>                        
                        </div>
                        <!--footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal" id="cambiarContrasena">Cambiar contraseña</button>
                        </div>
                    </div>
                </div>
            </div>
            <!------------------------FIN MODAL PARA CAMBIAR CONTRASEÑA---------------->
                
                <!--Comienzo del FOOTER-->
                <footer class="footer">
                    <div class="copyright">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>, DiseÃ±ado por
                        <a href="#" target="_blank">D&D Software</a>.
                    </div>
            </div>
            </footer>
            <!--Fin del FOOTER-->
        </div>
    </div>
</body>
<!-- Primero carga la fecha actual al input-->
<!-- Cuando un usuario ingresa, por defecto se le mostraran los turnos disponibles en el dia actual-->
<!-- Para una cancha definida por defecto, es este caso la roja-->

<!--   Archivos JS   -->
<script src="assets/js/core/jquery.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Chart JS -->
<script src="assets/js/plugins/chartjs.min.js"></script>
<!--  PLugin de notificaciones    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="assets/js/now-ui-dashboard.js?v=1.0.1"></script>
<script src="js/user.js"></script>
<script src="js/notify.js"></script>
<script src="js/cerrarSesion.js"></script>

</html>