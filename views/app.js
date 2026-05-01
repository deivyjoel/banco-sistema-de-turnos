console.log("alo we?")
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

document.addEventListener("DOMContentLoaded", () =>{
    CargarVista("inicio.html")
})



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
