
function cerrarSesion(){

    

    localStorage.removeItem("email");
    localStorage.removeItem("pass");
    localStorage.removeItem("recordar");
    
    $.ajax({
        type: 'GET',
        url: '/AreaDos/cerrarSesion.php',
        success: function (response) {
            
            window.location.href=response;    
        }
       
    });

   
};



