-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.29-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para ts2
CREATE DATABASE IF NOT EXISTS `ts2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ts2`;

-- Volcando estructura para tabla ts2.constancias
CREATE TABLE IF NOT EXISTS `constancias` (
  `id_constancia` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_constancia` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_constancia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.constancias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `constancias` DISABLE KEYS */;
/*!40000 ALTER TABLE `constancias` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.datos_complementarios
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
  KEY `FK_dcdirector` (`id_director`),
  CONSTRAINT `FK_dcconstancia` FOREIGN KEY (`id_constancia`) REFERENCES `constancias` (`id_constancia`),
  CONSTRAINT `FK_dcdatos` FOREIGN KEY (`id_datos`) REFERENCES `datos_iniciales` (`id_datos`),
  CONSTRAINT `FK_dcdirector` FOREIGN KEY (`id_director`) REFERENCES `director` (`id_director`),
  CONSTRAINT `FK_dcjefe` FOREIGN KEY (`id_jefe`) REFERENCES `jefe_servicio` (`id_jefe`),
  CONSTRAINT `FK_dcjefesocial` FOREIGN KEY (`id_jefesocial`) REFERENCES `jefe_trabajo_social` (`id_jefesocial`),
  CONSTRAINT `FK_dcmedico` FOREIGN KEY (`id_medico`) REFERENCES `medico_tratante` (`id_medico`),
  CONSTRAINT `FK_dcuser` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`),
  CONSTRAINT `Fk_dcservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_complementarios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_complementarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `datos_complementarios` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.datos_const_alta
CREATE TABLE IF NOT EXISTS `datos_const_alta` (
  `id_datosca` int(11) NOT NULL AUTO_INCREMENT,
  `id_datosc` int(11) DEFAULT NULL,
  `fecha_de_alta` date DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`id_datosca`),
  KEY `FK_dcadatosc` (`id_datosc`),
  CONSTRAINT `FK_dcadatosc` FOREIGN KEY (`id_datosc`) REFERENCES `datos_complementarios` (`id_datosc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_const_alta: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_const_alta` DISABLE KEYS */;
/*!40000 ALTER TABLE `datos_const_alta` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.datos_const_fallecimiento
CREATE TABLE IF NOT EXISTS `datos_const_fallecimiento` (
  `id_datoscf` int(11) NOT NULL AUTO_INCREMENT,
  `id_datosc` int(11) DEFAULT NULL,
  `fecha_defuncion` date DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`id_datoscf`),
  KEY `FK_dcfdatosc` (`id_datosc`),
  CONSTRAINT `FK_dcfdatosc` FOREIGN KEY (`id_datosc`) REFERENCES `datos_complementarios` (`id_datosc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_const_fallecimiento: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_const_fallecimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `datos_const_fallecimiento` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.datos_const_fallecimiento_casa
CREATE TABLE IF NOT EXISTS `datos_const_fallecimiento_casa` (
  `id_datoscfc` int(11) NOT NULL AUTO_INCREMENT,
  `id_datosc` int(11) DEFAULT NULL,
  `fecha_de_alta` date DEFAULT NULL,
  `fecha_defun_ext` date DEFAULT NULL,
  `lugar_de_extencion` varchar(3000) DEFAULT NULL,
  `fecha_fallecimiento` date DEFAULT NULL,
  PRIMARY KEY (`id_datoscfc`),
  KEY `FK_dcfcdatosc` (`id_datosc`),
  CONSTRAINT `FK_dcfcdatosc` FOREIGN KEY (`id_datosc`) REFERENCES `datos_complementarios` (`id_datosc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_const_fallecimiento_casa: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_const_fallecimiento_casa` DISABLE KEYS */;
/*!40000 ALTER TABLE `datos_const_fallecimiento_casa` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.datos_const_ingreso
CREATE TABLE IF NOT EXISTS `datos_const_ingreso` (
  `id_datosci` int(11) NOT NULL AUTO_INCREMENT,
  `id_datosc` int(11) DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL,
  PRIMARY KEY (`id_datosci`),
  KEY `FK_dcidatosc` (`id_datosc`),
  CONSTRAINT `FK_dcidatosc` FOREIGN KEY (`id_datosc`) REFERENCES `datos_complementarios` (`id_datosc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_const_ingreso: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_const_ingreso` DISABLE KEYS */;
/*!40000 ALTER TABLE `datos_const_ingreso` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.datos_iniciales
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
  KEY `FK_diestado` (`id_estado`),
  CONSTRAINT `FK_diestado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `FK_diservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_iniciales: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_iniciales` DISABLE KEYS */;
/*!40000 ALTER TABLE `datos_iniciales` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.director
CREATE TABLE IF NOT EXISTS `director` (
  `id_director` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_director`),
  KEY `FK_dservicio` (`id_servicio`),
  CONSTRAINT `FK_dservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.director: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `director` DISABLE KEYS */;
/*!40000 ALTER TABLE `director` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.estado
CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.estado: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.jefe_servicio
CREATE TABLE IF NOT EXISTS `jefe_servicio` (
  `id_jefe` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jefe`),
  KEY `FK_jsservicio` (`id_servicio`),
  CONSTRAINT `FK_jsservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.jefe_servicio: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `jefe_servicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `jefe_servicio` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.jefe_trabajo_social
CREATE TABLE IF NOT EXISTS `jefe_trabajo_social` (
  `id_jefesocial` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jefesocial`),
  KEY `FK_jtsservicio` (`id_servicio`),
  CONSTRAINT `FK_jtsservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.jefe_trabajo_social: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `jefe_trabajo_social` DISABLE KEYS */;
/*!40000 ALTER TABLE `jefe_trabajo_social` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.medico_tratante
CREATE TABLE IF NOT EXISTS `medico_tratante` (
  `id_medico` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_medico`),
  KEY `FK_mtservicio` (`id_servicio`),
  CONSTRAINT `FK_mtservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.medico_tratante: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `medico_tratante` DISABLE KEYS */;
/*!40000 ALTER TABLE `medico_tratante` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.precio_constancias
CREATE TABLE IF NOT EXISTS `precio_constancias` (
  `id_precio` int(11) NOT NULL AUTO_INCREMENT,
  `precio` float DEFAULT NULL,
  PRIMARY KEY (`id_precio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.precio_constancias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `precio_constancias` DISABLE KEYS */;
/*!40000 ALTER TABLE `precio_constancias` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.servicios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`) VALUES
	(1, 'na');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.tipo_usuario
CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id_tipousuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_tipousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.tipo_usuario: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` (`id_tipousuario`, `nombre_tipo`) VALUES
	(1, 'secretaria'),
	(2, 'trabajador'),
	(3, 'admin');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `id_tipousuario` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `FK_uservicio` (`id_servicio`),
  KEY `FK_utipousuario` (`id_tipousuario`),
  CONSTRAINT `FK_uservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  CONSTRAINT `FK_utipousuario` FOREIGN KEY (`id_tipousuario`) REFERENCES `tipo_usuario` (`id_tipousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.usuario: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id_user`, `user`, `password`, `id_tipousuario`, `id_servicio`) VALUES
	(1, 'secre', '202cb962ac59075b964b07152d234b70', 1, 1),
	(2, 'trabajador', '202cb962ac59075b964b07152d234b70', 2, NULL),
	(3, 'admin', '202cb962ac59075b964b07152d234b70', 3, NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
