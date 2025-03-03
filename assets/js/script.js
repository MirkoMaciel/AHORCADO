console.log("el archivo se vinculo correctamente");

//Petición AJAX que permite realizar la evaluación de la letra digitada por el usuario

$(document).ready(function () {
  $("#adivinar").click(function () {
    let letra = $("#letra").val().trim();
    if (letra === "") {
      alert("Por favor, ingresa una letra.");
      return;
    }

    // Enviar la letra al servidor
    $.ajax({
      url: "../../AHORCADO/models/juego.php", //Archivo que procesa la información
      method: "POST",
      data: { letra: letra }, //Dato enviado
      dataType: "json", //Tipo de dato FORMATO JSON
      success: function (response) {  //rESPUESTA del servidor
        if (response.success) { //Si la respuesta es valida
          // Actualiza los elementos del juego
          $("#palabra").text("Palabra para descubrir: " + response.palabra); 
          $("#aciertos").text(
            "Aciertos en la adivinanza: " + response.aciertos
          );
          $("#pistas").text("Pistas descubiertas: " + response.pistas);
          $("#letrasProbadas").text(
            "Letras probadas: " + response.letrasIntentadas
          );
          $("#mensaje").text(response.mensaje);
          // Después de 3 segundos, ocultar el mensaje y continuar el juego (FUNCION NO IMPLEMENTADA)
          /*
          setTimeout(function () {
            $("#mensaje").text(""); // Ocultar mensaje
          }, 2000); // 2000 ms = 2 segundos*/

          // Si el juego termina, deshabilitar entrada
          if (response.terminado) { //Si terminado = true
            $("#letra").prop("disabled", true);
            $("#adivinar").prop("disabled", true);
            $("#adivinar").css("background-color", "grey"); // Cambia el color del texto a gris// Cambia el color del texto a gris
            $("#btnNueva").prop("disabled", true);
            $("#btnNueva").css("background-color", "grey"); // Cambia el color del texto a gris

            // habilitar el botón
            $("#btnPartidaNueva").css("display", "block");
            abrirPopup();
          }
        } else {
          alert(response.error);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) { //Definición de errores 
        console.error("Error al procesar la solicitud:");
        console.error("Estado:", textStatus);
        console.error("Error:", errorThrown);
        console.error("Respuesta del servidor:", jqXHR.responseText);
        alert(
          "Hubo un problema al procesar tu solicitud. Revisa la consola para más detalles."
        );
      },
    });

    $("#letra").val(""); // Limpia el input
  });
});

function abrirPopup() { //Funcion para desplegar la ventana POP UP
  $.ajax({
    url: "../../../AHORCADO/public/vistaTablaJugadores.php", // Ruta al archivo HTML
    type: "GET", // Método HTTP
    success: function (data) {
      // Dimensiones del popup
      const width = 1200;
      const height = 980;
      // Calcular posición para centrar
      const left = screen.width / 2 - width / 2; 
      const top = screen.height / 2 - height / 2;
      // Abrir ventana popup
      const popupWindow = window.open(
        "", // Deja vacío para no redirigir
        "Ventana Popup",
        `width=${width},height=${height},left=${left},top=${top},scrollbars=yes`
      );

      // Bloquear el foco en la ventana popup
      popupWindow.focus();

      // Escribir el contenido del archivo en la ventana popup
      popupWindow.document.write(data);
    },
    error: function (error) {
      console.error("Error al cargar el archivo HTML:", error);
      alert("No se pudo cargar el contenido del popup.");
    },
  });
}

//////////////////////////////////ACCIONES DE LOS BOTONES EN PANTALLA ////////////////////////////////
let btnRendirse = document.querySelector("#btnRendirse");
let btnCancelar = document.querySelector("#btnCancelar");
let btnCancelar2 = document.querySelector("#btnCancelar2");
let btnNueva = document.querySelector("#btnNueva");
let mensajeFin = document.querySelector("#mensajeFin");
let mensajeNueva = document.querySelector("#mensajeNueva");

btnRendirse.addEventListener("click", () => {
  mensajeFin.show();
  mensajeFin.focus(); // Pone el foco en el cuadro de diálogo
});

btnCancelar.addEventListener("click", () => {
  mensajeFin.close();
});

btnCancelar2.addEventListener("click", () => {
  mensajeNueva.close();
});

btnNueva.addEventListener("click", () => {
  mensajeNueva.show();
  //window.location.href = "http://localhost/AHORCADO/public/vistaConfigJuego.php";
});


//FUNCION QUE IMPIDE QUE SE INGRESE CUALQUIER OTRO CARACTER QUE NO SEA UNA LETRA ()
const input = document.getElementById("letra");

//impide que el usuario intente escribir números o caracteres no permitidos.

input.addEventListener("keypress", function (e) {
    const regex = /^[a-zA-Z]+$/; // Solo letras
    const key = String.fromCharCode(e.keyCode || e.which);
    if (!regex.test(key)) {
        e.preventDefault(); // Bloquea el ingreso del carácter
    }
});