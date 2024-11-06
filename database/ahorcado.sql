-- Base de datos Mirko Maciel
-- TABLA USUARIOS

CREATE TABLE `usuario` (
    `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
    `nombreUsuario` varchar(50) NOT NULL,
    `correo` varchar(50) NOT NULL,
    `contraseña` varchar(50) NOT NULL,
    PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `usuario` (`idUsuario`, `nombreUsuario`, `correo`, `contraseña`) VALUES
(1, 'mirkoMirko', 'mirko0903@hotmail.com', '123456789');


-- TABLA PUNTAJES

CREATE TABLE `puntajes` (
    `idPuntaje` int(11) NOT NULL AUTO_INCREMENT,
    `idUsuario` int(11) NOT NULL,
    `puntaje` int(11) NOT NULL,
    `cantidadPartidas` int(11) NOT_NULL,
    PRIMARY KEY ('idPuntaje'),
     FOREIGN KEY (`idUsuario`) REFERENCES `usuario`(`idUsuario`)
)   ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO  `puntajes` (`idPuntaje`,`idUsuario`,`puntaje`,`cantidadPartidas`) VALUES
(1,`mirkoMirko`, 5000, 23)


 