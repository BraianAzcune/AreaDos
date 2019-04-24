/*
autor=Braian Azcune
Descripcion=
Este codigo verifica que el usuario puede entrar a admin o usuario .html segun corresponda.
En caso que no sea asi lo redirecciona a ingresar.

Argumento Opcional=
Se acepta como argumento opcional una funcion, que se ejecutara
antes de realizar el redireccionamiento.

A TENER EN CUENTA=
si el usuario quiere entrar a una pagina, distinta de usuario.html, admin o ingresar. Lo redireccionara
a alguna de esas paginas segun corresponda.
POSIBLE SOLUCION=
poner los .html, en carpetas, y que se realice una comprobacion de si puede entrar a esa carpeta segun corresponda
a usuario, admin.
*/
         
        

function comprobarUsuarioLogeado(callback,manual=false,mostrarModal){

   


    if (localStorage.getItem("recordar") || manual) {
            


            var datos = {
                "email": localStorage.getItem("email"),
                "pass": localStorage.getItem("pass")
            };

            $.ajax({
                
                type: "POST",  
                url: direccionIp()+"AreaDosV1.3/VerificarUsuario.php",
                dataType: "text",
                data: datos, 
                success: function(rta){  
                   if (callback instanceof Function){
                        callback();
                   }

                    rta=rta.replace(/\s/g, "");
                
                    redireccionar(rta);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                }       
            });
            
        

    }else{
    removerDatos();
    }
}

function redireccionar(rta) {
   
    

    if(window.location.href==rta){
        if(mostrarModal instanceof Function){
            mostrarModal();
        }
        removerDatos(); 
    }else{
       
        window.location.href=rta;
    }
        
}



//Deberia ser incluido en un .js aparte, para ser llamado por otro.
function direccionIp(){
    return "http://localhost/"
}


function removerDatos(){
        localStorage.removeItem("email");
        localStorage.removeItem("pass");
        localStorage.removeItem("recordar");
}