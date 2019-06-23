function connect() {
  //Creamos el web socket especificando cual es la direccion a la que se debe conectar
  var ws = new WebSocket("ws://localhost:8080");
  //Cuando se habre la conexion se envia el email que tenemos, para que lo registre el servidor.
  ws.onopen = () => {
    console.log("Conectado");
    // Tomamos el email que se consigue desde admin.php
    var emailAdmin = document.getElementById("scriptadminwebsocket").getAttribute("data-email");
    //Con este comando, hacemos que se registre nuestra conexion con el email correspondiente, para despues, el servidor nos pueda localizar por email
    var dato = { comando: "registrarEmail", msg: emailAdmin };
    dato = JSON.stringify(dato);
    ws.send(dato);
  };

  //que hacer cuando llega un mensaje
  ws.onmessage = e => {
    
    var mensaje = JSON.parse(e.data);
      
    //Dado el comando, realizamos alguna accion
    switch(mensaje.comando){
      case "notificarNuevaSolicitud":

        notificarNuevaSolicitud();
        break;
      case "notificarCancelacionDeTurno":
          notificarCancelacionDeTurno(mensaje.msg);
        break;
      default:
        alert("LLego un comando no identificado: "+mensaje.comando);
      }
  };

  //si se cierra la conexion, intentamos reconectar.
  ws.onclose = function(e) {
    console.log(
      "Se cerro la conexion con socket, reintentando conexion en 1 segundo.--",
      e.reason
    );
    setTimeout(function() {
      connect();
    }, 1000);
  };

  //si ocurre un error, se cierra la conexion, y ocurre el evento ws.onclose
  ws.onerror = function(err) {
    console.error("Error en socket: ", err.message, "--Cerrando socket");
    ws.close();
  };
}

//Ejecutamos la funcion declarada arriba.
connect();


/**
 * notificarNuevaSolicitud
 * cuando llega una notificacion de que hay una nueva solicitud pendiente de revisar.
 * se envia una notificacion y aparece una campanita en la seccion "Solicitudes"
 * 
 */
function notificarNuevaSolicitud(){
  //Mostramos Un cartel avisando que llego una solicitud
  $.notify.defaults({
    globalPosition: "bottom right",
    autoHideDelay: 8000
  });
  $.notify("Hay una nueva solicitud.\nVaya a 'Solicitudes' para mas informacion", "success", { position: "left" });
  //Hacemos aparecer la campana de notificaciones en la seccion 'Mis turnos'
  $("#campanaSolicitudes").show();
  $("#campanaSolicitudes").addClass("animate-flicker");

}


/**
 * notificarCancelacionDeTurno
 * Muestra un mensaje de alerta en la esquina superior izquierda que un jugador cancelo un turno aprobado
 * y se queda ahi hasta que se haga click
 * 
 * @param string mensaje 
 */
function notificarCancelacionDeTurno(mensaje){
  //Mostramos Un cartel avisando que se cancelo un turno
  $.notify.defaults({
    globalPosition: "left top",
    autoHide: false
  });
  $.notify(mensaje, "Warn", { position: "left" });
  
}