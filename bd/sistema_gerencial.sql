-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-09-2021 a las 12:40:46
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_gerencial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id_area` int(11) NOT NULL,
  `nombre_area` varchar(30) NOT NULL,
  `responsable` varchar(30) NOT NULL,
  `cantidad_personal` int(3) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estado_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id_area`, `nombre_area`, `responsable`, `cantidad_personal`, `id_usuario`, `estado_area`) VALUES
(1, 'Gerencia Comercial', 'Juan Jimenez', 25, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descripcion_area`
--

CREATE TABLE `descripcion_area` (
  `id_descripcion` int(11) NOT NULL,
  `titulo` varchar(40) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `imagen_area` varchar(100) NOT NULL,
  `estado_descripcion` int(2) NOT NULL,
  `id_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejecucion`
--

CREATE TABLE `ejecucion` (
  `id_ejecucion` int(11) NOT NULL,
  `fecha_actual` date NOT NULL,
  `cantidad_ejecutado` varchar(45) NOT NULL,
  `porcentaje_completo` varchar(45) NOT NULL,
  `estado_ejecucion` int(2) NOT NULL,
  `id_meta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meta`
--

CREATE TABLE `meta` (
  `id_meta` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `unidad_medida` varchar(30) NOT NULL,
  `cantidad` varchar(50) NOT NULL,
  `gestion` varchar(4) NOT NULL,
  `periodo_meta` varchar(30) DEFAULT NULL,
  `estado_meta` int(2) DEFAULT NULL,
  `id_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `meta`
--

INSERT INTO `meta` (`id_meta`, `descripcion`, `unidad_medida`, `cantidad`, `gestion`, `periodo_meta`, `estado_meta`, `id_area`) VALUES
(1, 'Agua potable', 'lts', '500', '2021', 'Anual', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_user` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_user` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_user`, `usuario`, `password`, `tipo_user`) VALUES
(1, 'Administrador', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'Administrador'),
(2, 'Juan Jimenez', 'jjimenez', '827ccb0eea8a706c4c34a16891f84e7b', 'encargado'),
(4, 'Wilhem Pireola', 'Wilhem', '827ccb0eea8a706c4c34a16891f84e7b', 'Gerente General');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`),
  ADD KEY `areas_ibfk_1` (`id_usuario`);

--
-- Indices de la tabla `descripcion_area`
--
ALTER TABLE `descripcion_area`
  ADD PRIMARY KEY (`id_descripcion`);

--
-- Indices de la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  ADD PRIMARY KEY (`id_ejecucion`);

--
-- Indices de la tabla `meta`
--
ALTER TABLE `meta`
  ADD PRIMARY KEY (`id_meta`),
  ADD KEY `metass_ibfk_1` (`id_area`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `nombre_user` (`nombre_user`),
  ADD UNIQUE KEY `usuario_2` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `descripcion_area`
--
ALTER TABLE `descripcion_area`
  MODIFY `id_descripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  MODIFY `id_ejecucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `meta`
--
ALTER TABLE `meta`
  MODIFY `id_meta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `areas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `meta`
--
ALTER TABLE `meta`
  ADD CONSTRAINT `meta_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`),
  ADD CONSTRAINT `metass_ibfk_1` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
