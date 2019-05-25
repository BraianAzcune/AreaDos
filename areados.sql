-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2019 a las 14:27:10
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `areados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancha`
--

CREATE TABLE `cancha` (
  `id_cancha` int(11) NOT NULL,
  `color` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cancha`
--

INSERT INTO `cancha` (`id_cancha`, `color`, `precio`) VALUES
(1, 'Roja', 12),
(2, 'Verde', 1222),
(3, 'Azul', 1222);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `email` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `contacto` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`email`, `nombre`, `apellido`, `contacto`, `password`, `tipo_usuario`) VALUES
('abram@hotmail.com', 'marcos', 'abram', '2302456789', 'asdf', 0),
('corazzal@hotmail.com', 'leonardo', 'corazza', '2302502668', '1234', 0),
('tano@hotmail.com', 'martin', 'tano', '2302502668', 'asd', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_x_cancha`
--

CREATE TABLE `usuario_x_cancha` (
  `usuario_email` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `cancha_id_cancha` int(11) NOT NULL,
  `hora` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_x_cancha`
--

INSERT INTO `usuario_x_cancha` (`usuario_email`, `cancha_id_cancha`, `hora`, `fecha`, `estado`) VALUES
('abram@hotmail.com', 1, 17, '2019-04-27', 0),
('abram@hotmail.com', 1, 17, '2019-05-23', 1),
('abram@hotmail.com', 1, 18, '2019-04-27', 0),
('abram@hotmail.com', 1, 18, '2019-05-23', 0),
('abram@hotmail.com', 1, 19, '2019-04-27', 1),
('abram@hotmail.com', 1, 19, '2019-05-23', 0),
('abram@hotmail.com', 3, 19, '2019-05-23', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cancha`
--
ALTER TABLE `cancha`
  ADD PRIMARY KEY (`id_cancha`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `usuario_x_cancha`
--
ALTER TABLE `usuario_x_cancha`
  ADD PRIMARY KEY (`usuario_email`,`cancha_id_cancha`,`hora`,`fecha`),
  ADD KEY `id_cancha` (`cancha_id_cancha`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario_x_cancha`
--
ALTER TABLE `usuario_x_cancha`
  ADD CONSTRAINT `email` FOREIGN KEY (`usuario_email`) REFERENCES `usuario` (`email`) ON UPDATE CASCADE,
  ADD CONSTRAINT `id_cancha` FOREIGN KEY (`cancha_id_cancha`) REFERENCES `cancha` (`id_cancha`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
