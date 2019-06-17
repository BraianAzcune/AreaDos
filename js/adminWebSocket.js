//Creamos el web socket especificando cual es la direccion a la que se debe conectar
var ws= new WebSocket("ws://localhost:8080");

//que hacer cuando se habre la conexion
ws.onopen=()=>{
    console.log("Conectado");

    var dato={"data":"Hola soy un cliente"};
    dato=JSON.stringify(dato);
    ws.send(dato);
    
};

//que hacer cuando se cierra
ws.onclose= e =>{
    console.log("Se cerro la conexion");
    console.log(e);
};

//que hacer cuando ocurre error
ws.onerror=e=>{
    console.log(e);
};

//que hacer cuando llega un mensaje
ws.onmessage=e=>{
    
    console.log(e);
    var mensaje= JSON.parse(e.data);
    console.log(mensaje);
};




