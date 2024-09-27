-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-09-2024 a las 15:34:37
-- Versión del servidor: 10.11.9-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u315067549_BullTrack`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CreativosHoras`
--

CREATE TABLE `CreativosHoras` (
  `id` int(11) NOT NULL,
  `id_seguimiento_creativo` smallint(6) DEFAULT NULL,
  `usuario_id` smallint(6) DEFAULT NULL,
  `horasTrabajadas` int(10) NOT NULL,
  `horasExtras` int(10) NOT NULL,
  `rolCreativos` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `CreativosHoras`
--
ALTER TABLE `CreativosHoras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_id_SeguimientoCreativo` (`id_seguimiento_creativo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `CreativosHoras`
--
ALTER TABLE `CreativosHoras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `CreativosHoras`
--
ALTER TABLE `CreativosHoras`
  ADD CONSTRAINT `CreativosHoras_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `Usuarios` (`id`),
  ADD CONSTRAINT `fk_id_SeguimientoCreativo` FOREIGN KEY (`id_seguimiento_creativo`) REFERENCES `SeguimientoCreativo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
