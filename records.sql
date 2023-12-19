-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-12-2023 a las 10:46:01
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
-- Base de datos: `records`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `nombre` varchar(32) NOT NULL,
  `apellidos` varchar(32) NOT NULL,
  `nivel` varchar(32) NOT NULL,
  `tiempo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`nombre`, `apellidos`, `nivel`, `tiempo`) VALUES
('Alex', 'Fernandez', 'Facil', 14.911),
('Iyana', 'Gonzalez', 'Facil', 15.698),
('Iyana', 'Gonzalez', 'Facil', 19.853),
('Iyana', 'Gonzalez', 'Facil', 19.853),
('Jaime', 'Sanchez', 'Facil', 22.233),
('Daniel', 'Uría', 'Facil', 21.336),
('Daniel', 'Uría', 'Facil', 21.336),
('Álex', 'Fernández', 'Medio', 56.189),
('Álex', 'Fernández', 'Dificil', 33.979),
('Daniel', 'Fernandez', 'Dificil', 37.089),
('Daniel', 'Fernandez', 'Dificil', 37.089),
('Jaime', 'Fernández', 'Facil', 23.33),
('Jaime', 'Fernández', 'Facil', 23.33),
('Jaime', 'Fernández', 'Facil', 23.33),
('Jaime', 'Fernández', 'Facil', 23.33),
('Jaime', 'Fernández', 'Facil', 23.33),
('Jaime', 'Fernández', 'Facil', 23.33),
('Jaime', 'Fernández', 'Facil', 23.33),
('Jaime', 'Fernández', 'Facil', 23.33),
('Jaime', 'Fernández', 'Facil', 23.33),
('Jaime', 'Fernández', 'Facil', 23.33),
('Daniel', 'Gonzalez', 'Facil', 24.269),
('Daniel', 'Gonzalez', 'Facil', 24.269),
('Manuel', 'Alonso', 'Facil', 13.038),
('Manuel', 'Alonso', 'Facil', 13.038),
('Jaime', 'Alonso', 'Facil', 18.846),
('Jaime', 'Alonso', 'Facil', 18.846),
('Jaime', 'Alonso', 'Facil', 18.846),
('Jaime', 'Alonso', 'Facil', 18.846),
('Jaime', 'Alonso', 'Facil', 18.846),
('Jaime', 'Alonso', 'Facil', 18.846),
('Jaime', 'Alonso', 'Facil', 18.846);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
