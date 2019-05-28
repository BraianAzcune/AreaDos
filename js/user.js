$(document).ready(function () {

  Actualizar_FechaActual_Input();
  id_intervalo=runSetInterval(seleccionarCancha);
  limitarFechaCalendario();

});

//---------------------------funcion que toma la cancha seleccionada--------------------------------//
function seleccionarCancha() {
  var id_cancha;
  var filtrarPor = document.getElementById("filtrado").value;
  if (filtrarPor == 'Cancha Roja') {
    id_cancha = 1;
    getTurnosPorCancha(id_cancha);
  }
  else if (filtrarPor == 'Cancha Verde') {
    id_cancha = 2;
    getTurnosPorCancha(id_cancha);
  }
  else if (filtrarPor == 'Cancha Azul') {
    id_cancha = 3;
    getTurnosPorCancha(id_cancha);
  }
};

//---------------------------------Cambiar contraseña----------------------------------------
//No se si fallara porque el mail a veces esta vacio, llenarlo con basura en admin.php
$("#cambiarContrasena").click(function () {

  var contrasena = $("input[name='contrasena']").val();
  var nuevaContrasena = $("input[name='nuevaContrasena']").val();


  $.post("cambiarContrasena.php",
    {

      contrasena: contrasena,
      nuevaContrasena: nuevaContrasena
    },
    function (data, status) {

      if (data == -1) {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("No se pudo modificar la contraseña", "danger", { position: 'left' });
      } else if (data == 1) {
        //$.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        //$.notify("Contraseña modificada con Éxito", "success", { position: 'left' });

        //Si se cambio la contraseña se cierra la sesion
        $.getScript("/AreaDos/js/cerrarSesion.js", function (script, textStatus, jqXHR) {
          cerrarSesion();
        });

      }
    });
});




//------------------------------------Funcion que muestra los turnos tanto disponibles , en espera o ocupados
function getTurnosPorCancha(id_cancha) {
  var fecha = Obtener_Fecha_input();
  $.post("levantarTurnoPorCancha.php",
    {
      fecha: fecha,
      cancha: id_cancha
    },
    function (data, status) {
      if (data == -1) {
        $(".contenedor").empty();
      } else {
        $(".contenedor").empty();
        $(".contenedor").append(data);
      }
    });
};


//-----------------FUNCION QUE PARA LA ACTUALIZACION DE LA PAGINA---------------------
function stopSetInterval(id_intervalo) {
  clearInterval(id_intervalo);
}
function runSetInterval(funcion) {
  id = setInterval(funcion, 1200);
  return id;
}
//------------------------------coloca la fecha actual al input---------------------
function Actualizar_FechaActual_Input() {
  var fecha = new Date();
  var dia = fecha.getDate();
  var mes = fecha.getMonth();
  mes++;
  var anio = fecha.getFullYear();
  if (dia < 10) {
    dia = '0' + dia; //agrega cero si el menor de 10
  }
  if (mes < 10) {
    mes = '0' + mes;
  }
  var fechaActual = anio + "-" + mes + "-" + dia;
  var fecha = $("input[name='dias']").val(fechaActual);
};

//----------------------------OBTENCION DE LA FECHA QUE ESTA ACTUALMENTE EN EL INPUT-----------------//
function Obtener_Fecha_input() {
  var fecha = $("input[name='dias']").val();
  return fecha;
};

//-------------------------realiza la solicitud de una cancha-----------------------------------//
function RealizarSolicitud(hora) {
  var cancha;
  var id_cancha = document.getElementById("filtrado").value;
  var fecha = Obtener_Fecha_input();
  var usuario = localStorage.getItem("nombre");
  if (id_cancha === 'Cancha Roja') {
    cancha = 1;
  }
  else if (id_cancha === 'Cancha Verde') {
    cancha = 2;
  }
  else if (id_cancha === 'Cancha Azul') {
    cancha = 3;
  }
  $.post("registrarSolicitud.php",
    {
      hora: hora,
      cancha: cancha,
      fecha: fecha,
    },
    function (data, status) {
      if (status == "success") {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("Se registro su su solicitud de turno", "success", { position: 'left' });
      }
      else {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("Algo salio mal!", "danger", { position: 'left' });

      }
    });
  stopSetInterval(id_intervalo);
  id_intervalo = runSetInterval(seleccionarCancha);
};

$("#TurnosPendientes").click(function () {
  stopSetInterval(id_intervalo);
  $("#contenedor_canchasYfecha").hide();
  $("#titulo_Pendientes").html("Mis Turnos Pendientes").css("text-decoration", "underline");
  $("#titulo_Pendientes").show();
  $(".contenedor").empty();
  $.get("TurnosPendientes.php", function (data, status) {
    if (data == -1) {
      alert("No tienes turnos en estado PENDIENTE");

    } else {

      $(".contenedor").append(data);
    }

  });

});

$("#Ver_Turnos").click(function () {
  $(".contenedor").empty();
  $("#titulo_Pendientes").hide();
  $("#contenedor_canchasYfecha").show();
  id_intervalo = runSetInterval(seleccionarCancha);
});
//-----------------ELIMINAR TURNOS PENDIENTES-----------------------------
function eliminar_turno(id_cancha, hora, fecha, id) {
  $.post("borrarTurno.php",
    {
      id: id_cancha,
      hora: hora,
      fecha: fecha

    },
    function (data, status) {
      if (data == 1) {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("Turno Eliminado", "warning", { position: 'left' });
        // agrege esto
        var stringid = "#" + id;
        $(stringid).remove();


      } else {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("Error al eliminar el turno", "success", { position: 'left' });
      }
    });
}
//---------------------VER TURNOS CONFIRMADOS-------------------------
$("#TurnosCorfirmados").click(function () {
  stopSetInterval(id_intervalo);
  $("#contenedor_canchasYfecha").hide();
  $("#titulo_Pendientes").html("Mis Turnos Aceptados").css("text-decoration", "underline");
  $("#titulo_Pendientes").show();
  $(".contenedor").empty();
  $.get("TurnosConfirmados.php", function (data, status) {
    if (data == -1) {
      alert("No tienes turnos en estado CONFIRMADO");

    } else {

      $(".contenedor").append(data);
    }

  });

});





//------------------------LIMITAR CALENDARIO--------------------------------

  function limitarFechaCalendario(){

      var fechaMIN = new Date();
    var fechaMAX = new Date();
    var weekInMilliseconds = 7 * 24 * 60 * 60 * 1000;
    fechaMAX.setTime(fechaMAX.getTime() + weekInMilliseconds);

      //------------dia minimo (fecha actual)---------------------
      var diaMIN = fechaMIN.getDate();
      var mesMIN = fechaMIN.getMonth();
      mesMIN++;
      var anioMIN = fechaMIN.getFullYear();
      if (diaMIN < 10) {
         diaMIN = '0' + diaMIN; //agrega cero si el menor de 10
      }
      if (mesMIN < 10) {
         mesMIN = '0' + mesMIN;
      }
      var fechaMinima = anioMIN + "-" + mesMIN + "-" + diaMIN;


      //------------dia maximo (una week despues)---------------
      var diaMAX = fechaMAX.getDate();
      var mesMAX = fechaMAX.getMonth();
      mesMAX++;
      var anioMAX = fechaMAX.getFullYear();
      if (diaMAX < 10) {
         diaMAX = '0' + diaMAX; //agrega cero si el menor de 10
      }
      if (mesMAX < 10) {
         mesMAX = '0' + mesMAX;
      }
      var fechaMaxima = anioMAX + "-" + mesMAX + "-" + diaMAX;

      //---------------------Agrega atributos min and max al input-----------
      $("#dias").attr({
       "max" : fechaMaxima,
       "min" : fechaMinima
    });
      
    }