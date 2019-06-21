
$(document).ready(function () {
  Actualizar_FechaActual_Input();
    
    Buscarturnos();
    
});

$("#ver_turnos").click(function () {
  
  $(".contenedor").empty();
  $("#agregar_turno").show();
  
  Buscarturnos();
});

//----------------ENVIA LOS DATOS AL ARCHIVO PEDIRTURNO.PHP---------------------------------------
$("#cargarTurno").click(function () {

  var nombre = $("input[name='nombre']").val();
  var apellido = $("input[name='apellido']").val();
  var contacto = $("input[name='contacto']").val();
  var fecha = Obtener_Fecha_input();
  var cancha_id;
  var horario;

  cancha_id = document.getElementById("cancha").value;

  if (cancha_id === 'Roja') {
    cancha_id = 1;
  } else if (cancha_id === 'Verde') {
    cancha_id = 2;
  } else if (cancha_id === 'Azul') {
    cancha_id = 3;
  }

  horario = document.getElementById("horario").value;
  //deberia obtener las horas

  $.post("pedirTurno.php",
    {
      nombre: nombre,
      apellido: apellido,
      contacto: contacto,
      horario: horario,
      cancha: cancha_id,
      fecha: fecha

    },
    function (data, status) {
      alert(data);
      if (data == 1) {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("Turno cargado", "success", { position: 'left' });
        Buscarturnos();
      } else {
        if (data == 0) {
          $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 6000 });
          $.notify("El turno no se puede cargar", "danger", { position: 'left' });
        }
        else {
          $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 6000 });
          $.notify("Revise los datos cargados", "danger", { position: 'left' });
        }

      }
    });
  updateModal();
});
//---------------------------------Cargar Usuario----------------------------------------
$("#cargarUsuario").click(function () {
  var nombre = $("input[name='nombre_usuario']").val();
  var apellido = $("input[name='apellido_usuario']").val();
  var contacto = $("input[name='contacto_usuario']").val();
  var email = $("input[name='Email']").val();
  var contraseña = $("input[name='contraseña']").val();
  $(":input", $("#ModalUsuario")).val("");
  $.post(
    "registrarUsuario.php",
    {
      nombre: nombre,
      apellido: apellido,
      contacto: contacto,
      email: email,
      contraseña: contraseña
    },
    function (data, status) {

      if (data == -1) {
        $.notify.defaults({
          globalPosition: "bottom right",
          autoHideDelay: 3000
        });
        $.notify("El Usuario ya Existe", "danger", { position: "left" });
      } else {
        $.notify.defaults({
          globalPosition: "bottom right",
          autoHideDelay: 3000
        });
        $.notify("Usuario Cargado con Éxito", "success", { position: "left" });

        //-------------------enviar mail-----------
        $.post(
          "PHPMailer/mail.php",
          {
            nombre: nombre,
            apellido: apellido,
            contacto: contacto,
            email: email,
            contraseña: contraseña
          },
          function (data, status) {
            console.log(data);
            if (data == -1) {
              $.notify.defaults({
                globalPosition: "bottom right",
                autoHideDelay: 3000
              });
              $.notify("fayo el envio", "danger", { position: "left" });
            } else {
              $.notify.defaults({
                globalPosition: "bottom right",
                autoHideDelay: 3000
              });
              $.notify("Se ha enviado el mail", "success", {
                position: "left"
              });
            }
          }
        );
      }
    }
  );
});

//---------------------------------Cambiar contraseña----------------------------------------
//No se si fallara porque el mail a veces esta vacio, llenarlo con basura en admin.php
$("#cambiarContrasena").click(function () {
  var contrasena = $("input[name='contrasena']").val();
  var nuevaContrasena = $("input[name='nuevaContrasena']").val();

  $.post(
    "cambiarContrasena.php",
    {
      contrasena: contrasena,
      nuevaContrasena: nuevaContrasena
    },
    function (data, status) {
      if (data == -1) {
        $.notify.defaults({
          globalPosition: "bottom right",
          autoHideDelay: 3000
        });
        $.notify("Contraseña incorrecta", "danger", { position: "left" });

        $(".modalpasschange").val("");
      } else if (data == 1) {
        $.notify.defaults({
          globalPosition: "bottom right",
          autoHideDelay: 3000
        });
        $.notify("Contraseña cambiada. Cerrando sesión", "success", {
          position: "left"
        });

        setTimeout(importarCerrarSession, 2000);
      }
    }
  );
});

function importarCerrarSession() {
  $.getScript("/AreaDos/js/cerrarSesion.js", function (
    script,
    textStatus,
    jqXHR
  ) {
    cerrarSesion();
  });
}

//---------------------------archiVo php para obtener los turnos de la respectiva fecha--------------------------------
function Buscarturnos() {
  $('#filtrado').prop('selectedIndex',0);//Ponemos el filtro en todos
  var fecha = Obtener_Fecha_input();
  $.post(
    "levantarTurno.php",
    {
      fecha: fecha
    },
    function (data) {
      if (data == -1) {
        $(".contenedor").empty();
        $("#agregar_turno").show();
      } else {
        $(".contenedor").empty();
        $(".contenedor").append(data);
        $("#agregar_turno").show();
      }
    }
  );
}

//-----El admin confirma una solicitud y pasa a ser un turno.
function confirmarSolicitudDeTurno(email, hora, id_cancha, fecha) {
  $.post(
    "confirmarSolicitud.php",
    {
      email: email,
      hora: hora,
      cancha: id_cancha,
      fecha: fecha
    },
    function (data, status) {
      alert(data);
      if (data == 1) {
        $.notify.defaults({
          globalPosition: "bottom right",
          autoHideDelay: 3000
        });
        $.notify("Solicitud confirmada", "success", { position: "left" });
      } else {
        $.notify.defaults({
          globalPosition: "bottom right",
          autoHideDelay: 3000
        });
        $.notify("Error al aceptar solicitud", "warning", { position: "left" });
      }
    }
  );
}

//---------------------------------------------Eliminar turno---------------------------------------------------------------
function eliminar_turno(id_cancha, hora, fecha) {
  $.post(
    "borrarTurno.php",
    {
      id: id_cancha,
      hora: hora,
      fecha: fecha
    },
    function (data, status) {
      if (data == 1) {
        $.notify.defaults({
          globalPosition: "bottom right",
          autoHideDelay: 3000
        });
        $.notify("Turno Eliminado", "success", { position: "left" });
        Buscarturnos();//Refrescamos los turnos, para que desaparezca el turno borrado.
      } else {
        $.notify.defaults({
          globalPosition: "bottom right",
          autoHideDelay: 3000
        });
        $.notify("Error al eliminar el turno", "warning", { position: "left" });
      }
    }
  );
}
//FUNCION QUE OBTIENE EL PARAMETRO PARA FILTRAR A TRAVÉS DE UN CAMBIO EN EL INPUT

function seleccionarCancha() {
  var id_cancha;
  var filtrarPor = document.getElementById("filtrado").value;
  if (filtrarPor === "Todos") {
    Buscarturnos();
  } else if (filtrarPor === "Cancha Roja") {
    id_cancha = 1;
    getTurnosPorCancha(id_cancha);
  } else if (filtrarPor === "Cancha Verde") {
    id_cancha = 2;    
    getTurnosPorCancha(id_cancha);
  } else if (filtrarPor === "Cancha Azul") {
    id_cancha = 3;
    getTurnosPorCancha(id_cancha);
  }
  return id_cancha;
}

function getTurnosPorCancha(id_cancha) {
  var fecha = Obtener_Fecha_input();
  $.post(
    "levantarTurnoPorCancha.php",
    {
      fecha: fecha,
      cancha: id_cancha
    },
    function (data, nombre) {
      if (data == -1) {
        $(".contenedor").empty();
      } else {
        $(".contenedor").empty();
        $(".contenedor").append(data);
      }
    }
  );
}

//_--------------------------------click a Estadisticas---------------------------------------//

$("#estadisticas").click(function () {
  

  $("#agregar_turno").hide();

  $(".contenedor").empty();
});



//coloca la fecha actual al input
function Actualizar_FechaActual_Input() {
  var fecha = new Date();
  var dia = fecha.getDate();
  var mes = fecha.getMonth();
  mes++;
  var anio = fecha.getFullYear();
  if (dia < 10) {
    dia = "0" + dia; //agrega cero si el menor de 10
  }
  if (mes < 10) {
    mes = "0" + mes;
  }
  var fechaActual = anio + "-" + mes + "-" + dia;
  var fecha = $("input[name='dias']").val(fechaActual);
}

//--------------------Aca se obtiene la fecha del input-------------------------------------------------------------
function Obtener_Fecha_input() {
  var fecha = $("input[name='dias']").val();
  return fecha;
}

//-------------ACTUALIZAR EL MODAL CON HORARIOS Y CANCHAS DISPONIBLES------/
function updateModal() {
  fecha = Obtener_Fecha_input();
  cancha_id = document.getElementById("cancha").value;

  if (cancha_id === 'Roja') {
    cancha_id = 1;
  } else if (cancha_id === 'Verde') {
    cancha_id = 2;
  } else if (cancha_id === 'Azul') {
    cancha_id = 3;
  }

  $.post("buscarHorasDisponibles.php",
    {
      fecha: fecha,
      id_cancha: cancha_id
    },
    function (data) {
      if (data == -1) {
        $("#horario").empty();
        for (var j = 17; j <= 23; j++) {
          $("#horario").append("<option>" + j + "</option>");
        }
      }
      else {
        alert(data);
        var horas = JSON.parse(data);
        var existe=false;
      
        $("#horario").empty();
        for (var j = 17; j <= 23; j++) {
          for (var i = 0; i < horas.length; i++) {
            if (horas[i] == j) {
              existe = true;
            }
          }
          if (!existe) {
            $("#horario").append("<option>" + j + "</option>");
          }
          existe=false;
        }
      }
    });
}

$("#agregar_turno").click(function () {
  updateModal();
});

//-----------------------SOLICITUDES-----------------------------

$("#solicitudes").click(function() {

  //Ocultamos la campanita que notifica que hay una solicitud
  $("#campanaSolicitudes").hide();

  

  //borramos lo que tiene el contenedor compartido.
  $(".contenedor").empty();

  //Ocultar cosas del boton ver turnos
  $("#agregar_turno").hide();

  //ejecutar ajax para refrescar solicitudes nuevas
  actualizarSolicitudes();
});

function actualizarSolicitudes() {
  var fecha = Obtener_Fecha_input();
  $.post(
    "levantarSolicitudes.php",
    {
      fecha: fecha
    },
    function (data) {
      $(".contenedor").empty();
      $(".contenedor").append(data);
    }
  );
}
