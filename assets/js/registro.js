console.log("El archivo se lee correctamente");
/*
$(document).ready(function () {
  // Capturamos el evento click en el botón
  $("#registro").on("click", function () {
    // Obtener los valores de los campos del formulario
    var usuario = $("#idUsuario").val();
    var correoUsuario = $("#idEmail").val();
    var contrasenaUsuario = $("#passUsuario").val();

    // Realizar una solicitud AJAX al archivo PHP
    $.ajax({
      url: "../../../AHORCADO/models/juego.php", // Ruta al archivo PHP
      method: "POST", // Enviar como POST
      data: {
        registroUsuario: usuario,
        correo: correoUsuario,
        pass: contrasenaUsuario,
      },
      dataType: "json",
      success: function (response) {
        console.log(response);
        // Mostrar el mensaje recibido del servidor en el div resultado
        $("#resultado").html("<p>" + response.mensaje + "</p>");
      },
      error: function (xhr, error, status) {
        console.log("Error: " + error); // Para obtener detalles sobre el error
        console.log(xhr.responseText); // Ver la respuesta completa en caso de error
        // En caso de error, mostrar un mensaje en el div
        // En caso de error, mostrar un mensaje en el div
        $("#resultado").html(
          "<p>Ocurrió un error al verificar el usuario.</p>" + error
        );
      },
    });
  });
});*/

//Petición AJAX que trae los datos de las empresas según los filtros ingresados.
$(document).ready(function () {
  $("#registro").on("click", function () {
    // Obtener los valores de los campos del formulario
    var usuario = $("#idUsuario").val();
    var correoUsuario = $("#idEmail").val();
    var contrasenaUsuario = $("#passUsuario").val();

    var parametros =
      "name=" +
      encodeURIComponent(usuario) +
      "&correouser=" +
      encodeURIComponent(correoUsuario) +
      "&contra=" +
      encodeURIComponent(contrasenaUsuario);

    console.log(parametros);

    var peticion = new XMLHttpRequest();

    peticion.open("POST", "../../../AHORCADO/models/juego.php", true);
    peticion.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
    );
    peticion.onreadystatechange = function () {
      if (peticion.readyState == 4 && peticion.status == 200) {
        var myObj = peticion.responseText;
        console.log(myObj);
        var resultado = document.querySelector("#resultado");
        if (myObj.length > 0) {
          resultado.innerHTML = "El usuario existe ";
        } else {
          resultado.innerHTML = "El usuario no existe";
        }
      }
    };
    peticion.send(parametros);
  });
});
