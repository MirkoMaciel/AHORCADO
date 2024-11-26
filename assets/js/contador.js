///CONTADOR DE TIEMPO


let fecha = new Date("11/25/2025");
let fechaPost = new Date().getTime() + (5 * 60 * 1000); // 5 minutos en milisegundos



//INPUT

let radios = document.getElementsByName("tiempo");
//let radioSinTiempo = document.querySelector("input[value='0']");
let parrafoMinutos = document.querySelector("#contMinutos");
let parrafoSegundos = document.querySelector("#contSegundos");



//Logica del contador
/*
setInterval (() =>{

    let hoy = new Date().getTime(); // Fecha actual
    let distancia = fechaPost - hoy; // Distancia entre la fecha de fin y la fecha actual

    // Convertimos la distancia en minutos y segundos
    let minutos = Math.floor((distancia % (1000 * 60 * 60)) / (1000 * 60)); // Obtener los minutos
    let segundos = Math.floor((distancia % (1000 * 60)) / 1000); // Obtener los segundos

    // Actualizamos el contenido del contador
    document.getElementById('contMinutos').innerHTML = minutos.toString().padStart(2, '0'); // Mostrar minutos
    document.getElementById('contSegundos').innerHTML = segundos.toString().padStart(2, '0'); // Mostrar segundos

    // Si el tiempo ha terminado, mostramos un mensaje o detenemos el contador
    if (distancia < 0) {
        clearInterval(); // Detenemos el intervalo
        document.getElementById('contMinutos').innerHTML = "00"; // Mostrar 00 minutos
        document.getElementById('contSegundos').innerHTML = "00"; // Mostrar 00 segundos
        alert("¡El tiempo ha terminado!");
    }

}, 1000);*/
