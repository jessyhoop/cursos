-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 24-04-2020 a las 08:50:17
-- Versión del servidor: 5.7.23
-- Versión de PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cursos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

DROP TABLE IF EXISTS `alumno`;
CREATE TABLE IF NOT EXISTS `alumno` (
  `idalumno` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido_p` varchar(45) NOT NULL,
  `apellido_m` varchar(45) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `num_cuenta` char(9) DEFAULT NULL,
  `rfc` char(13) DEFAULT NULL,
  `usuario_idusuario` int(11) NOT NULL,
  PRIMARY KEY (`idalumno`),
  KEY `fk_alumno_usuario1_idx` (`usuario_idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`idalumno`, `nombre`, `apellido_p`, `apellido_m`, `status`, `num_cuenta`, `rfc`, `usuario_idusuario`) VALUES
(1, 'jes', 'jes', 'jjes', 1, '415078851', '1', 1),
(2, 's', 's', 's', 1, NULL, 's', 9),
(3, 'bhrisvian arelly ', 'hernandez', 'aguilar ', 1, '123456789', '1234567891011', 10),
(4, 'jessica', 'hernadez', 'aguilar', 1, 'qwertyuio', 'asdfghjkloiun', 11),
(5, 'jesssics', 'hernandez', 'agiñar', 1, '123896789', '1232567890987', 12),
(6, 'frederick', 'donaldo', 'valle', 1, 'asddrgrtd', 'qwedfghtyujik', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_curso`
--

DROP TABLE IF EXISTS `alumno_curso`;
CREATE TABLE IF NOT EXISTS `alumno_curso` (
  `id_alumno_curso` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_idalumno` int(11) NOT NULL,
  `curso_idcurso` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_alumno_curso`),
  KEY `fk_alumno_has_curso_curso1_idx` (`curso_idcurso`),
  KEY `fk_alumno_has_curso_alumno1_idx` (`alumno_idalumno`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `alumno_curso`
--

INSERT INTO `alumno_curso` (`id_alumno_curso`, `alumno_idalumno`, `curso_idcurso`, `status`) VALUES
(1, 1, 1, 0),
(2, 5, 2, 0),
(3, 5, 1, 0),
(4, 5, 1, 0),
(5, 5, 1, 0),
(6, 5, 1, 1),
(7, 5, 2, 0),
(8, 6, 1, 1),
(9, 6, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

DROP TABLE IF EXISTS `carrera`;
CREATE TABLE IF NOT EXISTS `carrera` (
  `idcarrera` int(11) NOT NULL AUTO_INCREMENT,
  `carrera` varchar(45) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idcarrera`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`idcarrera`, `carrera`, `status`) VALUES
(1, 'para todas las carreras', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
  `idcurso` int(11) NOT NULL AUTO_INCREMENT,
  `curso` varchar(45) NOT NULL,
  `turno` varchar(45) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `cupo` int(11) NOT NULL,
  `hora_fin` time NOT NULL,
  `hora_inicio` time NOT NULL,
  `carrera_idcarrera` int(11) NOT NULL,
  `profesor_idprofesor` int(11) NOT NULL,
  PRIMARY KEY (`idcurso`),
  KEY `fk_curso_carrera1_idx` (`carrera_idcarrera`),
  KEY `fk_curso_profesor1_idx` (`profesor_idprofesor`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`idcurso`, `curso`, `turno`, `fecha_inicio`, `fecha_fin`, `status`, `cupo`, `hora_fin`, `hora_inicio`, `carrera_idcarrera`, `profesor_idprofesor`) VALUES
(1, 'taller de artes', 'Vespertino', '2020-04-22', '2020-04-22', 1, 24, '21:29:02', '21:29:04', 1, 1),
(2, 'taller de plantas', 'VespertinoOnline', '2020-04-23', '2020-04-23', 1, 1, '12:00:00', '12:00:00', 1, 1),
(3, 'cursos nadams', 'VespertinoOnline', '2020-04-24', '2020-04-24', 0, 56, '04:00:00', '01:00:02', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion`
--

DROP TABLE IF EXISTS `evaluacion`;
CREATE TABLE IF NOT EXISTS `evaluacion` (
  `idevaluacion` int(11) NOT NULL AUTO_INCREMENT,
  `respuestas` varchar(45) DEFAULT NULL,
  `calificaciones` varchar(50) DEFAULT NULL,
  `fecha_evaluacion` datetime DEFAULT NULL,
  `comentarios` varchar(225) DEFAULT NULL,
  `respuesta_1` char(1) DEFAULT NULL,
  `respuesta_2` char(1) DEFAULT NULL,
  `respuesta_3` char(1) DEFAULT NULL,
  `respuesta_4` char(1) DEFAULT NULL,
  `respuesta_5` char(1) DEFAULT NULL,
  `respuesta_6` char(1) DEFAULT NULL,
  `respuesta_8` char(1) DEFAULT NULL,
  `respuesta_7` char(1) DEFAULT NULL,
  `respuesta_9` char(1) DEFAULT NULL,
  `respuesta_10` char(1) DEFAULT NULL,
  `respuesta_11` char(1) DEFAULT NULL,
  `respuesta_12` char(1) DEFAULT NULL,
  `respuesta_13` char(1) DEFAULT NULL,
  `respuesta_14` char(1) DEFAULT NULL,
  `respuesta_15` char(1) DEFAULT NULL,
  `respuesta_16` char(1) DEFAULT NULL,
  `respuesta_17` char(1) DEFAULT NULL,
  `curso_idcurso` int(11) NOT NULL,
  PRIMARY KEY (`idevaluacion`),
  KEY `fk_evaluacion_curso1_idx` (`curso_idcurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

DROP TABLE IF EXISTS `profesor`;
CREATE TABLE IF NOT EXISTS `profesor` (
  `idprofesor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido_p` varchar(45) NOT NULL,
  `apellido_m` varchar(45) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `num_cuenta` char(9) DEFAULT NULL,
  `rfc` char(13) DEFAULT NULL,
  `usuario_idusuario` int(11) NOT NULL,
  PRIMARY KEY (`idprofesor`),
  KEY `fk_profesor_usuario1_idx` (`usuario_idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`idprofesor`, `nombre`, `apellido_p`, `apellido_m`, `status`, `num_cuenta`, `rfc`, `usuario_idusuario`) VALUES
(1, 'jessica', 'HERNADEZ', 'AGUILAR', 1, '415078850', 'heaj95100626a', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `idrol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `correoelectronico` varchar(80) NOT NULL DEFAULT '',
  `passwd` varchar(75) NOT NULL,
  `fecha_registro` timestamp NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rol` tinyint(1) NOT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `correoelectronico`, `passwd`, `fecha_registro`, `status`, `rol`) VALUES
(1, 'lospder.jesy@aragon.unam.mx', '7c222fb2927d828af22f592134e8932480637c0d', '2020-04-23 02:01:16', 1, 2),
(2, 'jesy@aragon.unam.mx', '7c222fb2927d828af22f592134e8932480637c0d', '0000-00-00 00:00:00', 1, 2),
(3, 'losspsdesr.jesy@aragon.unam.mx', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '0000-00-00 00:00:00', 1, 2),
(4, 'julio.jesy@aragon.unam.mx', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '0000-00-00 00:00:00', 1, 2),
(5, 'julio.jeSsy@aragon.unam.mx', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '2020-04-23 17:20:46', 1, 2),
(6, 'losper@aragon.unam.mx', '99996b911567c83cce17cdf194f314975c57ddf1', '2020-04-23 17:23:48', 1, 2),
(7, 'lossper@aragon.unam.mx', '99996b911567c83cce17cdf194f314975c57ddf1', '2020-04-23 17:25:56', 1, 2),
(8, 'frederick@aragon.unam.mx', '99996b911567c83cce17cdf194f314975c57ddf1', '2020-04-23 17:28:23', 1, 2),
(9, 'kns.jesy@aragon.unam.mx', 'a0f1490a20d0211c997b44bc357e1972deab8ae3', '2020-04-24 03:20:21', 1, 2),
(10, 'bhrisvian_132@aragon.unam.mx', '78e638b5136e586e03a589f4408f90acf5236587', '2020-04-24 03:24:58', 1, 2),
(11, 'losper.jesy@aragon.unam.mx', '4cc19aaff82f60ac4097f935ab4a06ad4f0891cc', '2020-04-24 03:54:36', 1, 2),
(12, 'aguilar@aragon.unam.mx', '7c222fb2927d828af22f592134e8932480637c0d', '2020-04-24 04:25:23', 1, 3),
(13, 'fred@aragon.unam.mx', '7c222fb2927d828af22f592134e8932480637c0d', '2020-04-24 13:44:59', 1, 3);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `fk_alumno_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `alumno_curso`
--
ALTER TABLE `alumno_curso`
  ADD CONSTRAINT `fk_alumno_has_curso_alumno1` FOREIGN KEY (`alumno_idalumno`) REFERENCES `alumno` (`idalumno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_alumno_has_curso_curso1` FOREIGN KEY (`curso_idcurso`) REFERENCES `curso` (`idcurso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `fk_curso_carrera1` FOREIGN KEY (`carrera_idcarrera`) REFERENCES `carrera` (`idcarrera`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_curso_profesor1` FOREIGN KEY (`profesor_idprofesor`) REFERENCES `profesor` (`idprofesor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD CONSTRAINT `fk_evaluacion_curso1` FOREIGN KEY (`curso_idcurso`) REFERENCES `curso` (`idcurso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `fk_profesor_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
