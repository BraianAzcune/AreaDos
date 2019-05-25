
var id_intervalo=null;
 $(document).ready(function(){
  
  Actualizar_FechaActual_Input();


  id_intervalo=runSetInterval(Buscarturnos);
  
});

$("#ver_turnos").click(function () {
  stopSetInterval(id_intervalo);
  $(".contenedor").empty();
  $("#agregar_turno").show();
  id_intervalo=runSetInterval(Buscarturnos);
});

//----------------ENVIA LOS DATOS AL ARCHIVO PEDIRTURNO.PHP---------------------------------------
$("#cargarTurno").click(function () {
  var nombre = $("input[name='nombre']").val();
  var apellido = $("input[name='apellido']").val();
  var contacto = $("input[name='contacto']").val();
  var cancha = $("#cancha").val();
  var fecha = Obtener_Fecha_input();
  var horario = $("#horario").val();

  if(cancha=="Roja"){
    cancha=1;
  }else if(cancha="Verde"){
    cancha=2;
  }else{
    cancha=3;
  }

  $.post("pedirTurno.php",
    {
      nombre: nombre,
      apellido: apellido,
      contacto: contacto,
      cancha: cancha,
      fecha: fecha,
      horario: horario
    }, function (data) {
      if (data == 1) {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("Turno Cargado con Éxito", "success", { position: 'left' });
      } else {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("El turno ya Éxiste", "danger", { position: 'left' });
      }
    });
});
//---------------------------------Cargar Usuario----------------------------------------
$("#cargarUsuario").click(function () {
  var nombre = $("input[name='nombre_usuario']").val();
  var apellido = $("input[name='apellido_usuario']").val();
  var contacto = $("input[name='contacto_usuario']").val();
  var email = $("input[name='Email']").val();
  var contraseña = $("input[name='contraseña']").val();

  $.post("registrarUsuario.php",
    {
      nombre: nombre,
      apellido: apellido,
      contacto: contacto,
      email: email,
      contraseña: contraseña
    },
    function (data, status) {
      if (data == -1) {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("El Usuario ya Existe", "danger", { position: 'left' });
      } else {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("Usuario Cargado con Éxito", "success", { position: 'left' });
      }
    });
});

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
      } else if(data==1){
        //$.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        //$.notify("Contraseña modificada con Éxito", "success", { position: 'left' });
       
        //Si se cambio la contraseña se cierra la sesion
        $.getScript("/AreaDos/js/cerrarSesion.js", function (script, textStatus, jqXHR) {
              cerrarSesion();          
        });

      }
    });
});

//---------------------------archiVo php para obtener los turnos de la respectiva fecha--------------------------------
function Buscarturnos() {
  var fecha = Obtener_Fecha_input();
  $.post("levantarTurno.php",
    {
      fecha: fecha
    },
    function (data) {
      if (data == -1) {
        $(".contenedor").empty();
         $("#agregar_turno").show();
   
      }
      else {
        $(".contenedor").empty();
        $(".contenedor").append(data);
         $("#agregar_turno").show();
  
      }
    });
};

//---------------------------------------------Eliminar turno---------------------------------------------------------------
function eliminar_turno(id_cancha,hora,fecha) {
  $.post("borrarTurno.php",
    {
      id: id_cancha,
      hora:hora,
      fecha:fecha

    },
    function (data, status) {
      if (data == 1) {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("Turno Eliminado", "warning", { position: 'left' });
      } else {
        $.notify.defaults({ globalPosition: 'bottom right', autoHideDelay: 3000 });
        $.notify("Error al eliminar el turno", "success", { position: 'left' });
      }});
}
//FUNCION QUE OBTIENE EL PARAMETRO PARA FILTRAR A TRAVÉS DE UN CAMBIO EN EL INPUT

function seleccionarCancha() {
  var id_cancha;
  var filtrarPor = document.getElementById("filtrado").value;
  if (filtrarPor === 'Todos') {
    stopSetInterval(id_intervalo);
    id_intervalo=runSetInterval(Buscarturnos);

  } else if (filtrarPor === 'Cancha Roja') {

    id_cancha=1;
    stopSetInterval(id_intervalo);
    id_intervalo=runSetInterval(getTurnosPorCancha(id_cancha));


  } else if (filtrarPor === 'Cancha Verde') {

      id_cancha=2;
     stopSetInterval(id_intervalo);
    id_intervalo=runSetInterval(getTurnosPorCancha(id_cancha));

    getTurnosPorCancha(id_cancha);
  } else if (filtrarPor === 'Cancha Azul') {
    id_cancha=3;
    stopSetInterval(id_intervalo);
    id_intervalo=runSetInterval(getTurnosPorCancha(id_cancha));
  }
  return id_cancha;
};

function getTurnosPorCancha(id_cancha) {
  var fecha = Obtener_Fecha_input();
  $.post("levantarTurnoPorCancha.php",
    {
      fecha: fecha,
      cancha: id_cancha
    },function (data,nombre) {
      if (data == -1) {
        $(".contenedor").empty();
      } else {
        $(".contenedor").empty();
        $(".contenedor").append(data);
      }});
}


//_--------------------------------click a Estadisticas---------------------------------------//

$("#estadisticas").click(function(){
    stopSetInterval(id_intervalo);
    
    $("#agregar_turno").hide();

    $(".contenedor").empty();
});

//-----------------FUNCION QUE PARA LA ACTUALIZACION DE LA PAGINA---------------------
function stopSetInterval(id_intervalo) {
clearInterval(id_intervalo);
}

function runSetInterval(funcion) {
id=setInterval(funcion,1500);
return id;
}

//coloca la fecha actual al input
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
}

//--------------------Aca se obtiene la fecha del input-------------------------------------------------------------
function Obtener_Fecha_input() {
  var fecha = $("input[name='dias']").val();
  return fecha;
};

//-------------ACTUALIZAR EL MODAL CON HORARIOS Y CANCHAS DISPONIBLES------/
 function updateModal(){

  fecha = Obtener_Fecha_input();
  cancha_id = document.getElementById("cancha").value;
  if(cancha_id==='Roja')
  {
   cancha_id=1; 
  }else if(cancha_id==='Verde')
  {
    cancha_id=2;
  }else if(cancha_id==='Azul')
  {
    cancha_id=3;
}

 $.post("buscarHorasDisponibles.php",
    {
      fecha: fecha,
      id_cancha: cancha_id
    },
    function (data) {
      if (data == -1) {
        alert("-1");
   
      }
      else {
        
     var horas = JSON.parse(data); 

            for (var j = 17; j<=23; j++) {
              if(horas[i]!==j)
              {
                $("#horario").append("<option>"+j+"</option>");
              }

            }

      }
    });

}

$("#agregar_turno").click(function(){

    updateModal();

});

//-----------------------SOLICITUDES-----------------------------

$("#solicitudes").click(function(){
  
  stopSetInterval(id_intervalo);

  //borramos lo que tiene el contenedor compartido.
  $(".contenedor").empty();

  //Ocultar cosas del boton ver turnos
  $("#agregar_turno").hide();
  
  
  //ejecutar ajax para refrescar solicitudes nuevas
  id_intervalo=runSetInterval(actualizarSolicitudes);
});

function actualizarSolicitudes(){
  var fecha = Obtener_Fecha_input();
  $.post("levantarSolicitudes.php",
  {
    fecha: fecha
  },
    function (data) {
  
      $(".contenedor").empty();
      $(".contenedor").append(data);
      
    });

}