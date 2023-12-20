-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-12-2023 a las 19:47:36
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `flagfootball`
--

-- --------------------------------------------------------
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS flagfootball;
USE flagfootball;

-- Eliminar tablas si existen
DROP TABLE IF EXISTS estadisticas;
DROP TABLE IF EXISTS partido;
DROP TABLE IF EXISTS jugador;
DROP TABLE IF EXISTS equipo;
DROP TABLE IF EXISTS liga;

--
-- Estructura de tabla para la tabla `liga`
--

CREATE TABLE `liga` (
  `ID_Liga` int(11) NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Localidad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `liga`
--

INSERT INTO `liga` (`ID_Liga`, `Nombre`, `Localidad`) VALUES
(1, 'Liga Asturiana', 'Asturias'),
(2, 'Liga Vasca', 'País Vasco'),
(3, 'Liga Gallega', 'Galicia'),
(4, 'Liga Cántabra', 'Cantabria');

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `ID_Equipo` int(11) NOT NULL,
  `Ciudad` varchar(255) DEFAULT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `ID_Liga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`ID_Equipo`, `Ciudad`, `Nombre`, `ID_Liga`) VALUES
(1, 'Oviedo', 'Oviedo Madbulls', 1),
(2, 'Gijón', 'Gijón Norteños', 1),
(3, 'Gijón', 'Gijón Mariners', 1),
(4, 'Gijón', 'Gijón Foxes', 1),
(5, 'Oviedo', 'Oviedo Phoenix', 1),
(6, 'Llanera', 'LLanera Vipers', 1),
(7, 'Cambre', 'Towers', 3),
(8, 'Cantabria', 'Cantabria Bisons', 4),
(9, 'Santander', 'Penguins', 4),
(10, 'Cabezón de la Sal', 'Cavaliers', 4),
(11, 'Santillana del Mar', 'Chiefs', 4),
(12, 'Santurtzi', 'Coyotes', 2),
(13, 'Santiago', 'Black Ravens', 3),
(14, 'Bilbao', 'Guards', 2),
(15, 'San Sebastian', 'Seahawks', 2);

--
-- Estructura de tabla para la tabla `partido`
--

CREATE TABLE `partido` (
  `ID_Partido` int(11) NOT NULL,
  `ID_Liga` int(11) DEFAULT NULL,
  `ID_Equipo_Local` int(11) DEFAULT NULL,
  `ID_Equipo_Visitante` int(11) DEFAULT NULL,
  `Resultado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partido`
--

INSERT INTO `partido` (`ID_Partido`, `ID_Liga`, `ID_Equipo_Local`, `ID_Equipo_Visitante`, `Resultado`) VALUES
(1, 1, 4, 3, '45-60'),
(2, 4, 10, 8, '0-3'),
(3, 3, 7, 13, '60-2'),
(4, 1, 1, 6, '43-4');

--
-- Estructura de tabla para la tabla `jugador`
--

CREATE TABLE `jugador` (
  `ID_Jugador` int(11) NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Apellido` varchar(255) DEFAULT NULL,
  `Numero` int(11) DEFAULT NULL,
  `ID_Equipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jugador`
--

INSERT INTO `jugador` (`ID_Jugador`, `Nombre`, `Apellido`, `Numero`, `ID_Equipo`) VALUES
(1, 'Alex', 'Fernandez', 88, 1),
(2, 'Olmo', 'Tamargo', 73, 1),
(3, 'Tomas', 'Martinez', 29, 1),
(4, 'Jaime', 'Menendez', 46, 10),
(5, 'Luis', 'Vazquez', 83, 10),
(6, 'Manuel', 'Gonzalez', 10, 2),
(7, 'Fernando', 'Gomez', 70, 2),
(8, 'Luis', 'Gomez', 79, 3),
(9, 'David', 'Sanchez', 1, 3),
(10, 'Juan', 'Mier', 18, 4),
(11, 'Jose', 'Vazquez', 97, 4);

--
-- Estructura de tabla para la tabla `estadisticas`
--

CREATE TABLE `estadisticas` (
  `ID_Estadisticas` int(11) NOT NULL,
  `ID_Jugador` int(11) DEFAULT NULL,
  `Touchdowns` int(11) DEFAULT NULL,
  `ExtraPoints` int(11) DEFAULT NULL,
  `partidos_Jugados` int(11) DEFAULT NULL,
  `Puntos_Marcados` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadisticas`
--

INSERT INTO `estadisticas` (`ID_Estadisticas`, `ID_Jugador`, `Touchdowns`, `ExtraPoints`, `partidos_Jugados`, `Puntos_Marcados`) VALUES
(1, 1, 10, 4, 10, 68),
(2, 9, 4, 0, 2, 24),
(3, 7, 0, 5, 1, 5),
(4, 4, 2, 0, 4, 12),
(5, 11, 0, 0, 0, 0),
(6, 10, 8, 10, 5, 58),
(7, 5, 0, 4, 3, 8),
(8, 8, 2, 4, 5, 16);


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`ID_Equipo`),
  ADD KEY `ID_Liga` (`ID_Liga`);

--
-- Indices de la tabla `estadisticas`
--
ALTER TABLE `estadisticas`
  ADD PRIMARY KEY (`ID_Estadisticas`),
  ADD KEY `ID_Jugador` (`ID_Jugador`);

--
-- Indices de la tabla `jugador`
--
ALTER TABLE `jugador`
  ADD PRIMARY KEY (`ID_Jugador`),
  ADD KEY `ID_Equipo` (`ID_Equipo`);

--
-- Indices de la tabla `liga`
--
ALTER TABLE `liga`
  ADD PRIMARY KEY (`ID_Liga`);

--
-- Indices de la tabla `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`ID_Partido`),
  ADD KEY `ID_Liga` (`ID_Liga`),
  ADD KEY `ID_Equipo_Local` (`ID_Equipo_Local`),
  ADD KEY `ID_Equipo_Visitante` (`ID_Equipo_Visitante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `ID_Equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `estadisticas`
--
ALTER TABLE `estadisticas`
  MODIFY `ID_Estadisticas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `jugador`
--
ALTER TABLE `jugador`
  MODIFY `ID_Jugador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `liga`
--
ALTER TABLE `liga`
  MODIFY `ID_Liga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `partido`
--
ALTER TABLE `partido`
  MODIFY `ID_Partido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `equipo_ibfk_1` FOREIGN KEY (`ID_Liga`) REFERENCES `liga` (`ID_Liga`);

--
-- Filtros para la tabla `estadisticas`
--
ALTER TABLE `estadisticas`
  ADD CONSTRAINT `estadisticas_ibfk_1` FOREIGN KEY (`ID_Jugador`) REFERENCES `jugador` (`ID_Jugador`);

--
-- Filtros para la tabla `jugador`
--
ALTER TABLE `jugador`
  ADD CONSTRAINT `jugador_ibfk_1` FOREIGN KEY (`ID_Equipo`) REFERENCES `equipo` (`ID_Equipo`);

--
-- Filtros para la tabla `partido`
--
ALTER TABLE `partido`
  ADD CONSTRAINT `partido_ibfk_1` FOREIGN KEY (`ID_Liga`) REFERENCES `liga` (`ID_Liga`),
  ADD CONSTRAINT `partido_ibfk_2` FOREIGN KEY (`ID_Equipo_Local`) REFERENCES `equipo` (`ID_Equipo`),
  ADD CONSTRAINT `partido_ibfk_3` FOREIGN KEY (`ID_Equipo_Visitante`) REFERENCES `equipo` (`ID_Equipo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
