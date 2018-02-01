-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-02-2018 a las 05:00:01
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ts2`
--
CREATE DATABASE IF NOT EXISTS `ts2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ts2`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `constancias`
--

CREATE TABLE IF NOT EXISTS `constancias` (
  `id_constancia` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_constancia` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_constancia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_complementarios`
--

CREATE TABLE IF NOT EXISTS `datos_complementarios` (
  `id_datosc` int(11) NOT NULL AUTO_INCREMENT,
  `id_constancia` int(11) DEFAULT NULL,
  `id_datos` int(11) DEFAULT NULL,
  `fecha_consulta` date DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nombre_solicitante` varchar(300) DEFAULT NULL,
  `parentesco` varchar(100) DEFAULT NULL,
  `destino` varchar(300) DEFAULT NULL,
  `fecha_extencion` date DEFAULT NULL,
  `id_medico` int(11) DEFAULT NULL,
  `id_jefe` int(11) DEFAULT NULL,
  `id_jefesocial` int(11) DEFAULT NULL,
  `id_director` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_datosc`),
  KEY `FK_dcconstancia` (`id_constancia`),
  KEY `FK_dcdatos` (`id_datos`),
  KEY `Fk_dcservicio` (`id_servicio`),
  KEY `FK_dcuser` (`id_user`),
  KEY `FK_dcmedico` (`id_medico`),
  KEY `FK_dcjefe` (`id_jefe`),
  KEY `FK_dcjefesocial` (`id_jefesocial`),
  KEY `FK_dcdirector` (`id_director`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_const_alta`
--

CREATE TABLE IF NOT EXISTS `datos_const_alta` (
  `id_datosca` int(11) NOT NULL AUTO_INCREMENT,
  `id_datosc` int(11) DEFAULT NULL,
  `fecha_de_alta` date DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`id_datosca`),
  KEY `FK_dcadatosc` (`id_datosc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_const_fallecimiento`
--

CREATE TABLE IF NOT EXISTS `datos_const_fallecimiento` (
  `id_datoscf` int(11) NOT NULL AUTO_INCREMENT,
  `id_datosc` int(11) DEFAULT NULL,
  `fecha_defuncion` date DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`id_datoscf`),
  KEY `FK_dcfdatosc` (`id_datosc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_const_fallecimiento_casa`
--

CREATE TABLE IF NOT EXISTS `datos_const_fallecimiento_casa` (
  `id_datoscfc` int(11) NOT NULL AUTO_INCREMENT,
  `id_datosc` int(11) DEFAULT NULL,
  `fecha_de_alta` date DEFAULT NULL,
  `fecha_defun_ext` date DEFAULT NULL,
  `lugar_de_extencion` varchar(3000) DEFAULT NULL,
  `fecha_fallecimiento` date DEFAULT NULL,
  PRIMARY KEY (`id_datoscfc`),
  KEY `FK_dcfcdatosc` (`id_datosc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_const_ingreso`
--

CREATE TABLE IF NOT EXISTS `datos_const_ingreso` (
  `id_datosci` int(11) NOT NULL AUTO_INCREMENT,
  `id_datosc` int(11) DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`id_datosci`),
  KEY `FK_dcidatosc` (`id_datosc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_iniciales`
--

CREATE TABLE IF NOT EXISTS `datos_iniciales` (
  `id_datos` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `numero_recibo` int(11) DEFAULT NULL,
  `nombre_paciente` varchar(300) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha_presentado` date DEFAULT NULL,
  `fecha_cancelado` date DEFAULT NULL,
  `destinos` varchar(2000) DEFAULT NULL,
  `afiliacion_dui` varchar(30) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_datos`),
  KEY `FK_diservicio` (`id_servicio`),
  KEY `FK_diestado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `director`
--

CREATE TABLE IF NOT EXISTS `director` (
  `id_director` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_director`),
  KEY `FK_dservicio` (`id_servicio`),
  KEY `FK_dstatus` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `director`
--

INSERT INTO `director` (`id_director`, `nombre`, `id_status`, `id_servicio`) VALUES
(1, 'Rodrigo Menjivar', 1, 1),
(2, 'Jose Alejandrino', 1, 2),
(3, 'Ernesto Landaverde', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jefe_servicio`
--

CREATE TABLE IF NOT EXISTS `jefe_servicio` (
  `id_jefe` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jefe`),
  KEY `FK_jsservicio` (`id_servicio`),
  KEY `FK_sstatus` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jefe_servicio`
--

INSERT INTO `jefe_servicio` (`id_jefe`, `nombre`, `id_status`, `id_servicio`) VALUES
(1, 'Jose ', 1, 2),
(2, 'Jose Ernesto PeÃ±a AndranÃ©', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jefe_trabajo_social`
--

CREATE TABLE IF NOT EXISTS `jefe_trabajo_social` (
  `id_jefesocial` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jefesocial`),
  KEY `FK_jtsservicio` (`id_servicio`),
  KEY `FK_jtsstatus` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jefe_trabajo_social`
--

INSERT INTO `jefe_trabajo_social` (`id_jefesocial`, `nombre`, `id_status`, `id_servicio`) VALUES
(1, 'Alejandra Estrada Hernandez Hernanes', 1, 2),
(2, 'Raziel Mentiras Locas', 1, 1),
(3, 'Ã‘oÃ±o', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico_tratante`
--

CREATE TABLE IF NOT EXISTS `medico_tratante` (
  `id_medico` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_medico`),
  KEY `FK_mtservicio` (`id_servicio`),
  KEY `FK_mtstatus` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `medico_tratante`
--

INSERT INTO `medico_tratante` (`id_medico`, `nombre`, `id_status`, `id_servicio`) VALUES
(1, 'Antonio Mejia Estrada Soza', 1, 1),
(2, 'Alexis PeÃ±a', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio_constancias`
--

CREATE TABLE IF NOT EXISTS `precio_constancias` (
  `id_precio` int(11) NOT NULL AUTO_INCREMENT,
  `precio` float DEFAULT NULL,
  PRIMARY KEY (`id_precio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE IF NOT EXISTS `servicios` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`) VALUES
(1, 'na'),
(2, 'po');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_status` varchar(50) DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id_status`, `nombre_status`, `descripcion`) VALUES
(1, 'Activo', 'usuario activo en sus funciones'),
(2, 'Inactivo', 'usuario inhabilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id_tipousuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_tipousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipousuario`, `nombre_tipo`) VALUES
(1, 'secretaria'),
(2, 'trabajador'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `id_tipousuario` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `FK_uservicio` (`id_servicio`),
  KEY `FK_utipousuario` (`id_tipousuario`),
  KEY `FK_ustatus` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_user`, `name`, `user`, `id_status`, `password`, `id_tipousuario`, `id_servicio`) VALUES
(1, 'Irene', 'secre', 1, '202cb962ac59075b964b07152d234b70', 1, 1),
(2, 'Perez Nathalia', 'trabajador', 1, '202cb962ac59075b964b07152d234b70', 2, 1),
(3, 'Alonso Jose', 'admin', 1, '202cb962ac59075b964b07152d234b70', 3, 2),
(4, 'Alexis Medrano', 'Soroko', 1, '202cb962ac59075b964b07152d234b70', 1, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datos_complementarios`
--
ALTER TABLE `datos_complementarios`
  ADD CONSTRAINT `FK_dcconstancia` FOREIGN KEY (`id_constancia`) REFERENCES `constancias` (`id_constancia`),
  ADD CONSTRAINT `FK_dcdatos` FOREIGN KEY (`id_datos`) REFERENCES `datos_iniciales` (`id_datos`),
  ADD CONSTRAINT `FK_dcdirector` FOREIGN KEY (`id_director`) REFERENCES `director` (`id_director`),
  ADD CONSTRAINT `FK_dcjefe` FOREIGN KEY (`id_jefe`) REFERENCES `jefe_servicio` (`id_jefe`),
  ADD CONSTRAINT `FK_dcjefesocial` FOREIGN KEY (`id_jefesocial`) REFERENCES `jefe_trabajo_social` (`id_jefesocial`),
  ADD CONSTRAINT `FK_dcmedico` FOREIGN KEY (`id_medico`) REFERENCES `medico_tratante` (`id_medico`),
  ADD CONSTRAINT `FK_dcuser` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`),
  ADD CONSTRAINT `Fk_dcservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`);

--
-- Filtros para la tabla `datos_const_alta`
--
ALTER TABLE `datos_const_alta`
  ADD CONSTRAINT `FK_dcadatosc` FOREIGN KEY (`id_datosc`) REFERENCES `datos_complementarios` (`id_datosc`);

--
-- Filtros para la tabla `datos_const_fallecimiento`
--
ALTER TABLE `datos_const_fallecimiento`
  ADD CONSTRAINT `FK_dcfdatosc` FOREIGN KEY (`id_datosc`) REFERENCES `datos_complementarios` (`id_datosc`);

--
-- Filtros para la tabla `datos_const_fallecimiento_casa`
--
ALTER TABLE `datos_const_fallecimiento_casa`
  ADD CONSTRAINT `FK_dcfcdatosc` FOREIGN KEY (`id_datosc`) REFERENCES `datos_complementarios` (`id_datosc`);

--
-- Filtros para la tabla `datos_const_ingreso`
--
ALTER TABLE `datos_const_ingreso`
  ADD CONSTRAINT `FK_dcidatosc` FOREIGN KEY (`id_datosc`) REFERENCES `datos_complementarios` (`id_datosc`);

--
-- Filtros para la tabla `datos_iniciales`
--
ALTER TABLE `datos_iniciales`
  ADD CONSTRAINT `FK_diestado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `FK_diservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`);

--
-- Filtros para la tabla `director`
--
ALTER TABLE `director`
  ADD CONSTRAINT `FK_dservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  ADD CONSTRAINT `FK_dstatus` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`);

--
-- Filtros para la tabla `jefe_servicio`
--
ALTER TABLE `jefe_servicio`
  ADD CONSTRAINT `FK_jsservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  ADD CONSTRAINT `FK_sstatus` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`);

--
-- Filtros para la tabla `jefe_trabajo_social`
--
ALTER TABLE `jefe_trabajo_social`
  ADD CONSTRAINT `FK_jtsservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  ADD CONSTRAINT `FK_jtsstatus` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`);

--
-- Filtros para la tabla `medico_tratante`
--
ALTER TABLE `medico_tratante`
  ADD CONSTRAINT `FK_mtservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  ADD CONSTRAINT `FK_mtstatus` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_uservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  ADD CONSTRAINT `FK_ustatus` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`),
  ADD CONSTRAINT `FK_utipousuario` FOREIGN KEY (`id_tipousuario`) REFERENCES `tipo_usuario` (`id_tipousuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
