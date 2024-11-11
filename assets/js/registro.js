var baseURL = 'http://localhost/AHORCADO/';

console.log("El archivo se lee correctamente");

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formInicio");

  if (!form) {
      console.error("Formulario no encontrado. Revisa el ID del formulario o el archivo HTML.");
      return;
  }

  console.log("Formulario encontrado. Listo para enviar.");

  form.addEventListener("submit", function (event) {
      event.preventDefault(); // Evitar el envío predeterminado para depuración
      console.log("Evento de envío capturado.");
  });

     // Verificar si el formulario existe
     if (form) {
      form.addEventListener("submit", function(event) {
          event.preventDefault(); // Evitar que el formulario se envíe de manera tradicional

          // Crear un objeto FormData con los datos del formulario
          const formData = new FormData(form);

          //Contenedor
          resultadoDiv = document.querySelector("#resultado");

          // Realizar una solicitud AJAX usando Fetch
          fetch("../../../AHORCADO/models", {
              method: "POST", // Método de envío de los datos
              body: formData // Los datos del formulario
          })
          .then(response => response.json()) // Asumimos que el servidor devuelve una respuesta en formato JSON
          .then(data => {
              if (data.success) {
                  resultadoDiv.innerHTML = "<p>Registro exitoso</p>";
              } else {
                  resultadoDiv.innerHTML = `<p>Error: ${data.message}</p>`;
              }
          })
          .catch(error => {
              resultadoDiv.innerHTML = "<p>Hubo un error en la comunicación con el servidor.</p>";
              console.error("Error en la solicitud:", error);
          });
      });
  } else {
      console.error("Formulario no encontrado.");
  }
});

//Consulta AJAX para manejar el registro de un usuario
function enviarRegistro() {
  event.preventDefault(); //Permite que la pagina no se recarge

  //Tomo los valores del form
  var nombreUsuario = document.querySelector("#idUsuario").value;
  console.log(nombreUsuario);
  var correo = document.querySelector("#idEmail").value;
  console.log(correo);
  var pass = document.querySelector("#passUsuario").value;
  console.log(pass);

  //Defino el parametro
  var parametros = "registroUsuario="+ encodeURIComponent(nombreUsuario)+ "&correo="+ encodeURIComponent(correo) + "&pass="+pass;

  //Inicio la petición
  var peticion = new XMLHttpRequest();

  //Abro la petición
  peticion.open("POST", baseURL+"models/juego.php", true);

  peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  peticion.onreadystatechange = function (){
    if (peticion.readyState == 4 && peticion.status == 200){

        var objeto = JSON.parse(peticion.responseText);
        console.log(objeto);
        var respuesta = document.querySelector("#resultado")
        if (objeto.length > 0){
            respuesta.innerHTML = 'El usuario se registro con exito';
        }else{
            respuesta.innerHTML = 'El usuario ya existe en la BD';
        }
    }
  };
  peticion.send(parametros);
}

/*
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formInicio");

  form.addEventListener("submit", function (event) {
      event.preventDefault(); // Prevenir el envío normal del formulario

      // Obtener los valores del formulario
      const username = document.getElementById("idUsuario").value;
      const email = document.getElementById("idEmail").value;
      const password = document.getElementById("passUsuario").value;

      // Crear objeto para enviar al servidor
      const formData = new FormData();
      formData.append("registroUsuario", username);
      formData.append("correo", email);
      formData.append("pass", password);

      // Hacer la solicitud AJAX
      fetch("../models/juego.php", {
          method: "POST",
          body: formData,
      })
          .then((response) => response.json())
          .then((data) => {
            console.log(data);
              const resultado = document.getElementById("resultado");
              if (data.success) {
                  resultado.textContent = "Registro exitoso.";
                  resultado.style.color = "green";
              } else {
                  resultado.textContent = data.message; // Mensaje de error (p.ej., "El usuario ya existe")
                  resultado.style.color = "red";
              }
          })
          .catch((error) => {
              console.error("Error:", error);
          });
  });
});*/
