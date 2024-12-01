console.log("contador cargado");

//ARCHIVO JS QUE MANIPULA EL CONTADOR 

document.addEventListener('DOMContentLoaded', function () {
    const tiempoInicial = "<?php echo $tiempo == '1' ? 'true' : 'false'; ?>"; //Dependiendo el modo de juego
    const contenedorContador = document.getElementById('contenedorContador'); //Contenedor donde se muestra el contador
    const parrafoTiempo = document.getElementById('parrafoTiempo');
    let intervalo;
    let tiempoJuego = 120;
    console.log(tiempoInicial);

    if (tiempoInicial) {
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

    /* LOGICA PARA DEFINIR EL TIEMPO SEGUN UNA DIFICULTAD (NO COMPLETADA)
        const selectorDificultad = document.getElementById("dificultad"); //Obtengo el elemento por el ID 
    const options = selectorDificultad.options; //Le asigno el valor tomado por el selector
    
    if (options == 1){ //dificultad BAJA
        tiempoJuego= 120; //En segundos
    } else if(options == 2){
        tiempoJuego= 160; //En segundos
    } else if (options = 3){
        tiempoJuego= 200; //En segundos
    }
    */