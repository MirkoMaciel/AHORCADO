-- Base de datos Mirko Maciel
-- TABLA USUARIOS

CREATE TABLE `usuario` (
    `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
    `nombreUsuario` varchar(50) NOT NULL UNIQUE,
    `correo` varchar(50) NOT NULL,
    `contraseña` varchar(50) NOT NULL,
    PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `usuario` (`idUsuario`, `nombreUsuario`, `correo`, `contraseña`) VALUES
(1, 'mirkoMirko', 'mirko0903@hotmail.com', '123456789');

ALTER TABLE usuario ADD CONSTRAINT unique_nombreUsuario UNIQUE (nombreUsuario);

-- TABLA PUNTAJES

CREATE TABLE `puntajes` (
    `idPuntaje` int(11) NOT NULL AUTO_INCREMENT,
    `idUsuario` int(11) NOT NULL,
    `puntaje` int(11) NOT NULL,
    `cantidadPartidas` int(11) NOT NULL,  -- Corregido: NOT NULL
    PRIMARY KEY (`idPuntaje`),  -- Corregido: Usar backticks, no comillas simples
    FOREIGN KEY (`idUsuario`) REFERENCES `usuario`(`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;    

INSERT INTO  `puntajes` (`idUsuario`,`puntaje`,`cantidadPartidas`) VALUES
(1, 5000, 23);

CREATE TABLE `palabras` (
    `idPalabra` INT(11) NOT NULL AUTO_INCREMENT,
    `palabra` VARCHAR(20) NOT NULL UNIQUE,
    `idCategoria` INT,
    CONSTRAINT chk_valor CHECK (idCategoria IN (1, 2, 3)),
    PRIMARY KEY (`idPalabra`)
);



CREATE TABLE `categoria` (
    `idCategoria` INT(11) NOT NULL AUTO_INCREMENT,  -- Usamos INT en lugar de ENUM
    `dificultad` VARCHAR(10) NOT NULL UNIQUE,
    PRIMARY KEY (`idCategoria`)
);

INSERT INTO `categoria` (`idCategoria`,`dificultad`) VALUES (1, 'Baja');
INSERT INTO `categoria` (`idCategoria`,`dificultad`) VALUES (2, 'Media');
INSERT INTO `categoria` (`idCategoria`,`dificultad`) VALUES (3, 'Alta');

--Palabras categoria 1 "Dificultad BAJA"
INSERT INTO `palabras` (`palabra`,`idCategoria`) VALUES
('Casa' , '1'),
('Gato' , '1'),
('Perro', '1'),
('Mano', '1'),
('Silla', '1'),
('Mesa', '1'),
('Flor', '1'),
('Bote', '1'),
('Niño', '1'),
('Madre', '1'),
('Padre', '1'),
('Sopa', '1'),
('Sol', '1'),
('Luna', '1'),
('Teja', '1'),
('Lago', '1'),
('Vino', '1'),
('Llave', '1'),
('Plazo', '1'),
('Cielo', '1'),
('Mar', '1'),
('Fruta', '1'),
('Rojo', '1'),
('Juez', '1');

-- Palabras categoria 2 "Dificultad Media"
INSERT INTO `palabras` (`palabra`, `idCategoria`) VALUES
('Guitarra' , '2'),
('Cultura', '2'),
('Llamado', '2'),
('Tortilla', '2'),
('Venezolano', '2'),
('Cervecero', '2'),
('Tequila', '2'),
('Marmota', '2'),
('Piñata', '2'),
('Tamarindo', '2'),
('Chileno', '2'),
('Sincero', '2'),
('Caballo', '2'),
('Aventura', '2'),
('Cumbia', '2'),
('Comedia', '2'),
('Jalisco', '2'),
('Futbolero', '2'),
('Cafetera', '2'),
('Colonia', '2'),
('Cerrado', '2'),
('Pimiento', '2'),
('Juguete', '2'),
('Plenitud', '2'),
('Montaña', '2');

--Palabras categoria 3 "Dificultad Alta"
INSERT INTO  `palabras` (`palabra`, `idCategoria`) VALUES
('Camaradería' , '3'),
('Independencia', '3'),
('Aventurero', '3'),
('Felicidad', '3'),
('Maravillosa', '3'),
('Tradición', '3'),
('Conquistador', '3'),
('Revolución', '3'),
('Compromiso', '3'),
('Comunidad', '3'),
('Camarón', '3'),
('Mestizaje', '3'),
('Guerrillero', '3'),
('Luchadora', '3'),
('Generosidad', '3'),
('Estampida', '3'),
('Resistencia', '3'),
('Inmortal', '3'),
('Iniciativa', '3'),
('Superación', '3'),
('Desarrollo', '3'),
('Recuerdo', '3'),
('Reciclaje', '3'),
('Camarismo', '3'),
('Confianza', '3')