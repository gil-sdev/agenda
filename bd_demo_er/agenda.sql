-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2019 a las 18:54:15
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agenda`
--
CREATE DATABASE IF NOT EXISTS `agenda_colaborativo` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `agenda_colaborativo`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `iddepartamento` int(11) NOT NULL,
  `nombredepartamento` varchar(45) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `title` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `body` text COLLATE utf8_spanish_ci NOT NULL,
  `url` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `class` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'event-important',
  `start` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `end` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `inicio_normal` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `final_normal` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `usuarios_idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos_has_departamentos`
--

CREATE TABLE `eventos_has_departamentos` (
  `evento_id` int(11) NOT NULL,
  `departmaneto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `evtsharedep`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `evtsharedep` (
`id` int(11)
,`title` varchar(150)
,`body` text
,`url` varchar(150)
,`class` varchar(45)
,`start` varchar(15)
,`end` varchar(15)
,`inicio_normal` varchar(50)
,`final_normal` varchar(50)
,`usuarios_idUsuario` int(11)
,`departmaneto_id` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuarios` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 NOT NULL,
  `primer_apellido` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `segundo_apellido` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `usuario` varchar(45) CHARACTER SET utf8 NOT NULL,
  `contraseña` varchar(45) CHARACTER SET utf8 NOT NULL,
  `cargo` varchar(45) CHARACTER SET utf8 NOT NULL,
  `tipo_usuario` int(1) NOT NULL,
  `estado` int(1) NOT NULL,
  `departamento_iddepartamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vbuscador`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vbuscador` (
`idusuarios` int(11)
,`nombre` varchar(45)
,`primer_apellido` varchar(45)
,`segundo_apellido` varchar(45)
,`usuario` varchar(45)
,`contraseña` varchar(45)
,`cargo` varchar(45)
,`tipo_usuario` int(1)
,`estado` int(1)
,`departamento_iddepartamento` int(11)
,`nombredepartamento` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `evtsharedep`
--
DROP TABLE IF EXISTS `evtsharedep`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `evtsharedep`  AS  select `eventos`.`id` AS `id`,`eventos`.`title` AS `title`,`eventos`.`body` AS `body`,`eventos`.`url` AS `url`,`eventos`.`class` AS `class`,`eventos`.`start` AS `start`,`eventos`.`end` AS `end`,`eventos`.`inicio_normal` AS `inicio_normal`,`eventos`.`final_normal` AS `final_normal`,`eventos`.`usuarios_idUsuario` AS `usuarios_idUsuario`,`eventos_has_departamentos`.`departmaneto_id` AS `departmaneto_id` from (`eventos_has_departamentos` join `eventos`) where (`eventos_has_departamentos`.`evento_id` = `eventos`.`id`) order by `eventos_has_departamentos`.`departmaneto_id` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vbuscador`
--
DROP TABLE IF EXISTS `vbuscador`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vbuscador`  AS  select `usuarios`.`idusuarios` AS `idusuarios`,`usuarios`.`nombre` AS `nombre`,`usuarios`.`primer_apellido` AS `primer_apellido`,`usuarios`.`segundo_apellido` AS `segundo_apellido`,`usuarios`.`usuario` AS `usuario`,`usuarios`.`contraseña` AS `contraseña`,`usuarios`.`cargo` AS `cargo`,`usuarios`.`tipo_usuario` AS `tipo_usuario`,`usuarios`.`estado` AS `estado`,`usuarios`.`departamento_iddepartamento` AS `departamento_iddepartamento`,`departamento`.`nombredepartamento` AS `nombredepartamento` from (`usuarios` join `departamento`) where (`departamento`.`iddepartamento` = `usuarios`.`departamento_iddepartamento`) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`iddepartamento`),
  ADD UNIQUE KEY `nombredepartamento` (`nombredepartamento`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_idUsuario` (`usuarios_idUsuario`);

--
-- Indices de la tabla `eventos_has_departamentos`
--
ALTER TABLE `eventos_has_departamentos`
  ADD KEY `departmaneto_id` (`departmaneto_id`),
  ADD KEY `evento_id` (`evento_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuarios`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  ADD KEY `fk_usuarios_departamento_idx` (`departamento_iddepartamento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `iddepartamento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuarios` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos_has_departamentos`
--
ALTER TABLE `eventos_has_departamentos`
  ADD CONSTRAINT `eventos_has_departamentos_ibfk_2` FOREIGN KEY (`departmaneto_id`) REFERENCES `departamento` (`iddepartamento`),
  ADD CONSTRAINT `eventos_has_departamentos_ibfk_3` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_departamento` FOREIGN KEY (`departamento_iddepartamento`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

--volcado de datos prededinos para el sistema
INSERT INTO `departamento` (`iddepartamento`, `nombredepartamento`) VALUES (NULL, 'root');
INSERT INTO `usuarios` (`idusuarios`, `nombre`, `primer_apellido`, `segundo_apellido`, `usuario`, `contraseña`, `cargo`, `tipo_usuario`, `estado`, `departamento_iddepartamento`) VALUES (NULL, 'root', 'root', 'root', 'root', 'root', 'root', '1', '1', '0');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
