console.log("el archivo se vinculo correctamente");

$(document).ready(function () {
  $("#adivinar").click(function () {
    let letra = $("#letra").val().trim();
    if (letra === "") {
      alert("Por favor, ingresa una letra.");
      return;
    }

    // Enviar la letra al servidor
    $.ajax({
      url: "../../AHORCADO/models/juego.php",
      method: "POST",
      data: { letra: letra },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          // Actualiza los elementos del juego
          $("#palabra").text("Palabra para descubrir: "+response.palabra);
          $("#aciertos").text("Aciertos en la adivinanza: " + response.aciertos);
          $("#pistas").text("Pistas descubiertas: " + response.pistas);
          $("#mensaje").text(response.mensaje);
          // Después de 3 segundos, ocultar el mensaje y continuar el juego
          /*
          setTimeout(function () {
            $("#mensaje").text(""); // Ocultar mensaje
          }, 2000); // 2000 ms = 2 segundos*/
          // Si el juego termina, deshabilitar entrada
          if (response.terminado) {
            $("#letra").prop("disabled", true);
            $("#adivinar").prop("disabled", true);
          }
        } else {
          alert(response.error);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
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
