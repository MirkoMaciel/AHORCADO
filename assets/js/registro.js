console.log("El archivo se lee correctamente");


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

    peticion.open("POST", "../../../AHORCADO/models/procesarUsuario.php", true);
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
