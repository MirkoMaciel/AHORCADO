console.log("contador cargado");

document.addEventListener('DOMContentLoaded', function () {
    const tiempoInicial = "<?php echo $tiempo == '1' ? 'true' : 'false'; ?>";
    console.log(tiempoInicial);
    const contenedorContador = document.getElementById('contenedorContador');
    const parrafoTiempo = document.getElementById('parrafoTiempo');
    let intervalo;

    if (tiempoInicial) {
        let tiempoJuego= 60; //En segundos
        intervalo = setInterval(function () {
            let minutos = Math.floor(tiempoJuego / 60);
            let segundos = tiempoJuego % 60;
            segundos = segundos < 10 ? '0' + segundos : segundos;
            parrafoTiempo.textContent = `Tiempo restante: ${minutos}:${segundos}`;
            tiempoJuego--;

            if (tiempoInicial < 0) {
                clearInterval(intervalo); //Limpio el intervalo
                alert("¡El tiempo se ha acabado!");
            }
        }, 1000);
    }
});