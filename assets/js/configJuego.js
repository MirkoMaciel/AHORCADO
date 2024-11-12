document
  .getElementById("gameForm")
  .addEventListener("submit", function (event) {
    //event.preventDefault(); // Evitar el envío del formulario

    // Obtener los valores del formulario
    var dificultad = document.getElementById("dificultad").value;
    var tiempo = document.querySelector('input[name="tiempo"]:checked').value;

    // Determinar el rango de letras según la dificultad
    var rango;
    if (dificultad === "baja") {
      rango = "3,5";
    } else if (dificultad === "medio") {
      rango = "6,8";
    } else if (dificultad === "alta") {
      rango = "9,20"; // Rango alto, puedes ajustarlo según lo necesites
    }

    // Simular la selección aleatoria de palabra (esto sería reemplazado con una consulta a la base de datos)
    // Aquí solo se selecciona una palabra aleatoria basada en el rango de letras
    fetchWordFromDatabase(rango).then(function (word) {
      document.getElementById("result").innerHTML = `
            <p>Palabra seleccionada: <strong>${word}</strong></p>
            <p>Tipo de partida: ${
              tiempo === "withtiempo" ? "Con tiempo" : "Sin tiempo"
            }</p>
        `;
    });
  });

// Función para simular la obtención de una palabra de la base de datos
function fetchWordFromDatabase(rango) {
  return new Promise(function (resolve, reject) {
    // Simulamos las palabras en función del rango de letras
    var words = {
      "3,5": ["Casa", "Gato", "Perro", "Silla", "Mesa", "Flor", "Bote", "Niño"],
      "6,8": [
        "Camarón",
        "Luchador",
        "Frutero",
        "Mestizo",
        "Lucha",
        "Historia",
        "Misterio",
      ],
      "9,20": [
        "Aventurero",
        "Camaradería",
        "Inmortal",
        "Independencia",
        "Revolucionario",
      ],
    };

    // Filtrar las palabras según el rango de letras
    var wordList = words[rango];

    // Seleccionar una palabra aleatoria
    var randomWord = wordList[Math.floor(Math.random() * wordList.length)];

    resolve(randomWord);
  });
}

function changeWindow(){
    window.location.href = "vistaJuego.php";
}