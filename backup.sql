-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-02-2018 a las 03:57:27
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `constancias`
--

DROP TABLE IF EXISTS `constancias`;
CREATE TABLE `constancias` (
  `id_constancia` int(11) NOT NULL,
  `tipo_constancia` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `constancias`
--

INSERT INTO `constancias` (`id_constancia`, `tipo_constancia`) VALUES
(1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_complementarios`
--

DROP TABLE IF EXISTS `datos_complementarios`;
CREATE TABLE `datos_complementarios` (
  `id_datosc` int(11) NOT NULL,
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
  `id_director` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_const_alta`
--

DROP TABLE IF EXISTS `datos_const_alta`;
CREATE TABLE `datos_const_alta` (
  `id_datosca` int(11) NOT NULL,
  `id_datosc` int(11) DEFAULT NULL,
  `fecha_de_alta` date DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_const_fallecimiento`
--

DROP TABLE IF EXISTS `datos_const_fallecimiento`;
CREATE TABLE `datos_const_fallecimiento` (
  `id_datoscf` int(11) NOT NULL,
  `id_datosc` int(11) DEFAULT NULL,
  `fecha_defuncion` date DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_const_fallecimiento_casa`
--

DROP TABLE IF EXISTS `datos_const_fallecimiento_casa`;
CREATE TABLE `datos_const_fallecimiento_casa` (
  `id_datoscfc` int(11) NOT NULL,
  `id_datosc` int(11) DEFAULT NULL,
  `fecha_de_alta` date DEFAULT NULL,
  `fecha_defun_ext` date DEFAULT NULL,
  `lugar_de_extencion` varchar(3000) DEFAULT NULL,
  `fecha_fallecimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_const_ingreso`
--

DROP TABLE IF EXISTS `datos_const_ingreso`;
CREATE TABLE `datos_const_ingreso` (
  `id_datosci` int(11) NOT NULL,
  `id_datosc` int(11) DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_iniciales`
--

DROP TABLE IF EXISTS `datos_iniciales`;
CREATE TABLE `datos_iniciales` (
  `id_datos` int(11) NOT NULL,
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
  `id_estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `director`
--

DROP TABLE IF EXISTS `director`;
CREATE TABLE `director` (
  `id_director` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(50) DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jefe_servicio`
--

DROP TABLE IF EXISTS `jefe_servicio`;
CREATE TABLE `jefe_servicio` (
  `id_jefe` int(11) NOT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jefe_trabajo_social`
--

DROP TABLE IF EXISTS `jefe_trabajo_social`;
CREATE TABLE `jefe_trabajo_social` (
  `id_jefesocial` int(11) NOT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico_tratante`
--

DROP TABLE IF EXISTS `medico_tratante`;
CREATE TABLE `medico_tratante` (
  `id_medico` int(11) NOT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `medico_tratante`
--

INSERT INTO `medico_tratante` (`id_medico`, `nombre`, `id_status`, `id_servicio`) VALUES
(1, 'juan', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio_constancias`
--

DROP TABLE IF EXISTS `precio_constancias`;
CREATE TABLE `precio_constancias` (
  `id_precio` int(11) NOT NULL,
  `precio` float(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `precio_constancias`
--

INSERT INTO `precio_constancias` (`id_precio`, `precio`) VALUES
(1, 2.75);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

DROP TABLE IF EXISTS `servicios`;
CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `nombre_servicio` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`) VALUES
(1, 'na');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `nombre_status` varchar(50) DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE `tipo_usuario` (
  `id_tipousuario` int(11) NOT NULL,
  `nombre_tipo` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_user` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `id_tipousuario` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_user`, `name`, `user`, `id_status`, `password`, `id_tipousuario`, `id_servicio`) VALUES
(1, 'Garrido Irene', 'secre', 1, 'fbc71ce36cc20790f2eeed2197898e71', 1, 1),
(2, 'Perez Nathalia', 'trabajador', 1, '202cb962ac59075b964b07152d234b70', 2, 1),
(3, 'Alonso Jose', 'admin', 1, '202cb962ac59075b964b07152d234b70', 3, 1),
(4, 'Gerardo Magaña López', 'Ger27', 1, 'e10adc3949ba59abbe56e057f20f883e', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `constancias`
--
ALTER TABLE `constancias`
  ADD PRIMARY KEY (`id_constancia`);

--
-- Indices de la tabla `datos_complementarios`
--
ALTER TABLE `datos_complementarios`
  ADD PRIMARY KEY (`id_datosc`),
  ADD KEY `FK_dcconstancia` (`id_constancia`),
  ADD KEY `FK_dcdatos` (`id_datos`),
  ADD KEY `Fk_dcservicio` (`id_servicio`),
  ADD KEY `FK_dcuser` (`id_user`),
  ADD KEY `FK_dcmedico` (`id_medico`),
  ADD KEY `FK_dcjefe` (`id_jefe`),
  ADD KEY `FK_dcjefesocial` (`id_jefesocial`),
  ADD KEY `FK_dcdirector` (`id_director`);

--
-- Indices de la tabla `datos_const_alta`
--
ALTER TABLE `datos_const_alta`
  ADD PRIMARY KEY (`id_datosca`),
  ADD KEY `FK_dcadatosc` (`id_datosc`);

--
-- Indices de la tabla `datos_const_fallecimiento`
--
ALTER TABLE `datos_const_fallecimiento`
  ADD PRIMARY KEY (`id_datoscf`),
  ADD KEY `FK_dcfdatosc` (`id_datosc`);

--
-- Indices de la tabla `datos_const_fallecimiento_casa`
--
ALTER TABLE `datos_const_fallecimiento_casa`
  ADD PRIMARY KEY (`id_datoscfc`),
  ADD KEY `FK_dcfcdatosc` (`id_datosc`);

--
-- Indices de la tabla `datos_const_ingreso`
--
ALTER TABLE `datos_const_ingreso`
  ADD PRIMARY KEY (`id_datosci`),
  ADD KEY `FK_dcidatosc` (`id_datosc`);

--
-- Indices de la tabla `datos_iniciales`
--
ALTER TABLE `datos_iniciales`
  ADD PRIMARY KEY (`id_datos`),
  ADD KEY `FK_diservicio` (`id_servicio`),
  ADD KEY `FK_diestado` (`id_estado`);

--
-- Indices de la tabla `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`id_director`),
  ADD KEY `FK_dservicio` (`id_servicio`),
  ADD KEY `FK_dstatus` (`id_status`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `jefe_servicio`
--
ALTER TABLE `jefe_servicio`
  ADD PRIMARY KEY (`id_jefe`),
  ADD KEY `FK_jsservicio` (`id_servicio`),
  ADD KEY `FK_sstatus` (`id_status`);

--
-- Indices de la tabla `jefe_trabajo_social`
--
ALTER TABLE `jefe_trabajo_social`
  ADD PRIMARY KEY (`id_jefesocial`),
  ADD KEY `FK_jtsservicio` (`id_servicio`),
  ADD KEY `FK_jtsstatus` (`id_status`);

--
-- Indices de la tabla `medico_tratante`
--
ALTER TABLE `medico_tratante`
  ADD PRIMARY KEY (`id_medico`),
  ADD KEY `FK_mtservicio` (`id_servicio`),
  ADD KEY `FK_mtstatus` (`id_status`);

--
-- Indices de la tabla `precio_constancias`
--
ALTER TABLE `precio_constancias`
  ADD PRIMARY KEY (`id_precio`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipousuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `FK_uservicio` (`id_servicio`),
  ADD KEY `FK_utipousuario` (`id_tipousuario`),
  ADD KEY `FK_ustatus` (`id_status`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `constancias`
--
ALTER TABLE `constancias`
  MODIFY `id_constancia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `datos_complementarios`
--
ALTER TABLE `datos_complementarios`
  MODIFY `id_datosc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datos_const_alta`
--
ALTER TABLE `datos_const_alta`
  MODIFY `id_datosca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datos_const_fallecimiento`
--
ALTER TABLE `datos_const_fallecimiento`
  MODIFY `id_datoscf` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datos_const_fallecimiento_casa`
--
ALTER TABLE `datos_const_fallecimiento_casa`
  MODIFY `id_datoscfc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datos_const_ingreso`
--
ALTER TABLE `datos_const_ingreso`
  MODIFY `id_datosci` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datos_iniciales`
--
ALTER TABLE `datos_iniciales`
  MODIFY `id_datos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `director`
--
ALTER TABLE `director`
  MODIFY `id_director` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jefe_servicio`
--
ALTER TABLE `jefe_servicio`
  MODIFY `id_jefe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jefe_trabajo_social`
--
ALTER TABLE `jefe_trabajo_social`
  MODIFY `id_jefesocial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medico_tratante`
--
ALTER TABLE `medico_tratante`
  MODIFY `id_medico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `precio_constancias`
--
ALTER TABLE `precio_constancias`
  MODIFY `id_precio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipousuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
