function CargarVista(ruta){
    fetch(ruta)
    .then(res => res.text())
    .then(html =>{
        const cont = document.querySelector(".content");
        cont.innerHTML = html;

        if (ruta.includes("reservar_turno")){
            cargarServicios();
            console.log("se carga servicios we")
        }
    })
}

// Que lo primero que se recargue sea inicio
document.addEventListener("DOMContentLoaded", () =>{
    CargarVista("../inicio.html")
})

// Boton de inicio
document.getElementById("btn-inicio").addEventListener("click", async function(e){
  e.preventDefault;
  CargarVista("../inicio.html")
})


// Boton de desloguearse
document.getElementById("btn-logout").addEventListener("click", async function(e){
    e.preventDefault();
    const response = await fetch("/banco_sistema_atc/auth/logout", {
        method: "POST"
    });

    const data = await response.json();

    if (data.status === "success"){
        window.location.href = "/banco_sistema_atc/views/login/inicio_sesion.html";
    }
});


// Listar servicios
document.getElementById("btn-reservar-turno").addEventListener("click", async function(e){
  e.preventDefault();

        const response = await fetch("/banco_sistema_atc/auth/get_servicios", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });

        // Se verifica el tipo de respuesta
        const ContentType = response.headers.get("content-type");

        if(!ContentType || !ContentType.includes("application/json")){
            const text = await response.text();
            console.error("Respuesta inesperada", text)
            alert("El servidor respondió de forma inesperada")
            return;
        }

        const data = await response.json();


})