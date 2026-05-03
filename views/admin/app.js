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



// Falta arreglar we
function cargarServicios() {
  fetch("../controller/servicio.php?op=listar")
    .then(res => res.json())
    .then(data => {

      const contenedor = document.getElementById("servicios");

      contenedor.innerHTML = "";

      data.forEach(servicio => {
        
        const card = document.createElement("div");
        card.classList.add("card-servicio");

        card.innerHTML = `
          <h3>${servicio.ser_nom}</h3>
          <p>Duración promedio: ${servicio.ser_dur_prom} min</p>
          <button>Sacar turno</button>
        `;

        // click para generar turno
        card.querySelector("button").addEventListener("click", () => {
          generarTurno(servicio.ser_id);
        });

        contenedor.appendChild(card);
      });

    })
    .catch(err => console.error(err));
}
