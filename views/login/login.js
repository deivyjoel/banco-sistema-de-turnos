$(document).on("click", "#btnIngresar", function(event){ // Agregué 'event' aquí
    event.preventDefault(); 

    var email = $('#email').val();
    var password = $('#password').val();

    if(email == '' || password == ''){
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Ingrese todos los campos',
            showConfirmButton: false,
            timer: 1500
        });
    } else {
        $.post("../../controller/usuarioController.php?op=login", {email : email, password : password}, function(data){
            
            if (data.success === false) { 
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: data.message, 
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                window.location.href = "../inicio/index.php";
            }
            
        }, "json"); // Importante: indicamos que esperamos un JSON
    }
}); // Cierre correcto