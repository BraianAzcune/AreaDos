function connect() {
    //Creamos el web socket especificando cual es la direccion a la que se debe conectar
    var ws = new WebSocket("ws://localhost:8080");
    //Cuando se habre la conexion se envia el email que tenemos, para que lo registre el servidor.
    ws.onopen = () => {
      console.log("Conectado");
      // Tomamos el email que se consigue desde user.php
      var emailAdmin = document.getElementById("scriptuserwebsocket").getAttribute("data-email");
      //Con este comando, hacemos que se registre nuestra conexion con el email correspondiente, para despues, el servidor nos pueda localizar por email
      var dato = { comando: "registrarEmail", msg: emailAdmin };
      dato = JSON.stringify(dato);
      ws.send(dato);
    };
  
    //que hacer cuando llega un mensaje
    ws.onmessage = e => {
      console.log("Mensaje entrante: ");
      console.log(e);
      console.log("Mensaje entrante (formateado para json): ");
      var mensaje = JSON.parse(e.data);
      
      console.log(mensaje);
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
  