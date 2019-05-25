<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
hola
-->
<html>

<head>
    <title>Area 2</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/estiloIngresar.css">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
	

    <script src="js/comprobarUsuarioLogeado.js"></script>
    <script>
        comprobarUsuarioLogeado();
    </script>
</head>

<body>
    <form>
        <div class="container col-xs-12"
            style="margin-top:5%;display: flex; flex-direction: column; align-items: center;">
            <div class="card center-block" style="width: 25rem; align-items: center; border-radius: 20px">
                <img src="./IMG/area2.jpg">
                <div class="form-inline" style="display: flex; align-items: center;">
                    <div class="form-group">
                        <label for="nombre"></label>
                        <input class="form-control bg-light" type="text" id="email" name="email"
                            placeholder="Email" required autofocus>
                    </div>
                </div>

                <div class="form-inline" style="display: flex;margin-top:5%; align-items: center;">
                    <div class="form-group">
                        <label for="pass"></label>
                        <input class="form-control bg-light" type="password" id="pass" name="pass"
                            placeholder="Contraseña" required="">
                    </div>
                </div>
                <br>
                <div>
                    <label><input type="checkbox" id="recordar" name="remember" style="margin-top: 8px; margin-bottom:8px">
                        Recordarme</label>
                </div>
                <input class="btn btn-lg btn-primary btn-block  bg-danger text-white " 
                style="width:60%; border-radius:5px; margin: 0;border:none;"  type="submit" value="Ingresar">
                <div class="" style="margin-top: 8px; margin-bottom: 8px;">
                    <a href="" style="text-decoration: none;">¿Olvidaste la contraseña?</a>
                </div>
            </div>
        </div>
    </form>
    <!--Alerta contraseña incorrecta-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <p class="text-center">Por favor, verifique los datos ingresados.</p>
                </div>
                <div class="modal-footer">
                    <input class="btn btn-sm btn-primary btn-block  bg-danger text-white" data-dismiss="modal"
                        style="border-radius: 30px " type="submit" value="Aceptar">
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--Alerta contraseña incorrecta-->
</body>

<script>
  
    $(document).ready(function () {

        $('form').submit(function (e) {
            e.preventDefault();

            localStorage.setItem("email", $('#email').val());
            localStorage.setItem("pass", $('#pass').val());
            
            comprobarUsuarioLogeado(comprobarRecordarme,true,mostrarModal);


        })
    })
    function comprobarRecordarme() {
        if ($("#recordar").is(':checked')) {
            localStorage.setItem("email", $('#email').val());
            localStorage.setItem("pass", $('#pass').val());
            localStorage.setItem("recordar", true);
        }else{
            localStorage.removeItem("email");
            localStorage.removeItem("pass");
            localStorage.removeItem("recordar");
        }
    }

    function mostrarModal(){
         $('#myModal').modal('show');
    }


</script>

</html>