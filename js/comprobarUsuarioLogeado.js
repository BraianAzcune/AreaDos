

         
        

function comprobarUsuarioLogeado(callback,manual=false,mostrarModal){

   


    if (localStorage.getItem("recordar") || manual) {
            


            var datos = {
                "email": localStorage.getItem("email"),
                "pass": localStorage.getItem("pass")
            };

            $.ajax({
                
                type: "POST",  
                url:"VerificarUsuario.php",
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
    var finalDireccionRelativa=window.location.pathname.split("/").pop();
    
    if(rta=="index.php"){

        if(mostrarModal instanceof Function){
            mostrarModal();
        }
        removerDatos(); 
    }else{
       
        window.location.href=rta;
    }
        
}





function removerDatos(){
        localStorage.removeItem("email");
        localStorage.removeItem("pass");
        localStorage.removeItem("recordar");
}