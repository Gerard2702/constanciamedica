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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.constancias: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `constancias` DISABLE KEYS */;
INSERT INTO `constancias` (`id_constancia`, `tipo_constancia`) VALUES
	(1, 'Alta'),
	(2, 'Ingreso'),
	(3, 'Fallecimiento'),
	(4, 'Fallecimiento en casa');
/*!40000 ALTER TABLE `constancias` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.datos_complementarios
CREATE TABLE IF NOT EXISTS `datos_complementarios` (
  `id_datosc` int(11) NOT NULL AUTO_INCREMENT,
  `id_constancia` int(11) DEFAULT NULL,
  `id_datos` int(11) DEFAULT NULL,
  `fecha_consulta` date DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `diagnostico` varchar(3000) DEFAULT NULL,
  `nombre_solicitante` varchar(300) DEFAULT NULL,
  `parentesco` varchar(100) DEFAULT NULL,
  `destino` varchar(300) DEFAULT NULL,
  `fecha_extension` date DEFAULT NULL,
  `id_medico` int(11) DEFAULT NULL,
  `id_jefe` int(11) DEFAULT NULL,
  `id_jefesocial` int(11) DEFAULT NULL,
  `id_director` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT '0',
  PRIMARY KEY (`id_datosc`),
  KEY `FK_dcconstancia` (`id_constancia`),
  KEY `FK_dcdatos` (`id_datos`),
  KEY `Fk_dcservicio` (`id_servicio`),
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
  CONSTRAINT `Fk_dcservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_complementarios: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_complementarios` DISABLE KEYS */;
INSERT INTO `datos_complementarios` (`id_datosc`, `id_constancia`, `id_datos`, `fecha_consulta`, `id_servicio`, `diagnostico`, `nombre_solicitante`, `parentesco`, `destino`, `fecha_extension`, `id_medico`, `id_jefe`, `id_jefesocial`, `id_director`, `estado`) VALUES
	(1, 2, 7, '2018-01-04', 7, 'Síndrome Convulsivo más Diabetes Mellitus tipo 2, ingresando al Servicio de Medicina Tres el mismo día con igual diagnóstico', 'CARLOS RODOLFO REGALADO', 'hijo de paciente', 'UNITED AIRLINES', '2018-01-08', 1, 1, 1, 1, 1),
	(2, 2, 7, '2018-01-04', 7, 'Síndrome Convulsivo más Diabetes Mellitus tipo 2, ingresando al Servicio de Medicina Tres el mismo día con igual diagnóstico', 'Sra. REINA M. REGALADO ', 'nuera de paciente', 'FRAMINGHAM HIGH SCHOOL, BOSTON MASSACHUSETTS DE LOS ESTADOS UNIDOS DE AMERICA', '2018-01-08', 1, 1, 1, 1, 0),
	(3, 2, 7, '2018-01-04', 7, 'Síndrome Convulsivo más Diabetes Mellitus tipo 2, ingresando al Servicio de Medicina Tres el mismo día con igual diagnóstico', 'Sra. BRENDA REYES', 'nieta de paciente', 'TARGET, LOS ANGELES CALIFORNIA DE LOS ESTADOS UNIDOS DE AMERICA', '2018-01-08', 1, 1, 1, 1, 1),
	(4, 3, 8, '2017-12-23', 7, 'ingresando en el Servicio de Medicina Tres el mismo día con igual diagnóstico. Según expediente clínico paciente con antecedentes médicos conocidos de Diabetes Mellitus más Hipertensión Arterial desde hace aproximadamente 3 años', 'Sra. MARVIN AZUCENA TORREZ RIVAS', 'compañera de vida de paciente', 'AFP CONFIA', '2018-01-17', 1, 1, 1, 1, 0),
	(5, 3, 9, '2014-01-04', 7, 'Lumbociatica Bilateral, con historia de 4 meses de dolor en región escapular izquierda, además de treinta días de dificultad para deambular, el día de su ingreso sufre caída desde su propia altura con imposibilidad para incorporarse, ingresando al Servicio de Neurocirugía el mismo día con diagnostico de Síndrome Medular más Paraparesia, intervenido quirúrgicamente el día 10 de de enero de 2014 realizándose Laminectomìa Descompresiva T3-T4 más Toma de Biopsia de Tumor T3-T4. de Lesión Tumoral Paravertebral T3-T4 que reportó Metástasis de Adenocarcinoma a Vertebra T4, el 27 de enero de 2014 se le tomò TAC de Tórax que concluyó Masa Pulmonar que refuerza con el contraste en Vèrtice Izquierdo y según nota de medico tratante paciente con Càncer Primario de Pulmón y con Metàstasis  de Pulmón a Columna, el día 28 de enero de 2014 se le realizó Endoscopía Superior que diagnosticó Ulcera Gigante penetrada en Ante Gástrico más Ulcera en Bulbo Duodenal más Ulcera en Cuerpo Gástrico. El día 29 de enero de 2014 fue trasladado al Servicio de Medicina 3 con diagnóstico de Metastasis de Adenocarcinoma en columna Torácica más Sangrado del Tubo Digestivo Superior. Según expediente clínico paciente con antecedentes médicos conocidos de Infarto Agudo al Miocardio en 2011', 'Sra. ANA GLADIS CRUZ FIGUEROA C/P ANA GLADIS FIGUEROA ', 'compañera de vida de paciente', 'AFP CONFIA', '2018-01-12', 1, 1, 1, 1, 0),
	(7, 1, 10, '2017-12-18', 7, 'Miastenia Gravis, ingresando al Servicio de Medicina Tres el mismo día con igual diagnóstico', 'Sr. ESTEBAN PINEDA VALCACERES ', 'esposo de paciente', 'CORTE SUPREMA DE JUSTICIA', '2018-01-15', 1, 1, 1, 1, 0),
	(8, 2, 5, '2018-02-12', 6, 'asdasdasd', 'Juan Miguel', 'Padre', 'AFP CONFIA', '2018-02-13', NULL, NULL, NULL, NULL, 0);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_const_alta: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_const_alta` DISABLE KEYS */;
INSERT INTO `datos_const_alta` (`id_datosca`, `id_datosc`, `fecha_de_alta`, `diagnostico`) VALUES
	(1, 7, '2017-12-29', 'Síndrome de Guillan Barré');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_const_fallecimiento: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_const_fallecimiento` DISABLE KEYS */;
INSERT INTO `datos_const_fallecimiento` (`id_datoscf`, `id_datosc`, `fecha_defuncion`, `diagnostico`) VALUES
	(1, 4, '2017-12-27', 'Infarto Agudo de Miocardio más Hipertensión Arterial  más Diabetes Mellitus Tipo 2 más Neumonía'),
	(2, 5, '2014-02-21', 'Sangrado de Tubo Digestivo Superior más Ulcera Duodenal más Cáncer de Pulmón');
/*!40000 ALTER TABLE `datos_const_fallecimiento` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.datos_const_fallecimiento_casa
CREATE TABLE IF NOT EXISTS `datos_const_fallecimiento_casa` (
  `id_datoscfc` int(11) NOT NULL AUTO_INCREMENT,
  `id_datosc` int(11) DEFAULT NULL,
  `fecha_de_alta` date DEFAULT NULL,
  `fecha_defun_ext` date DEFAULT NULL,
  `lugar_de_extension` varchar(3000) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_const_ingreso: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_const_ingreso` DISABLE KEYS */;
INSERT INTO `datos_const_ingreso` (`id_datosci`, `id_datosc`, `diagnostico`) VALUES
	(1, 1, 'Estatus Convulsivo + Neumonía Aspirativa en Ventilación Mecánica'),
	(2, 2, 'Estatus Convulsivo + Neumonía Aspirativa en Ventilación Mecánica'),
	(3, 3, 'Estatus Convulsivo + Neumonía Aspirativa en Ventilación Mecánica'),
	(4, 8, 'asdasdasd');
/*!40000 ALTER TABLE `datos_const_ingreso` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.datos_iniciales
CREATE TABLE IF NOT EXISTS `datos_iniciales` (
  `id_datos` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `numero_recibo` int(11) DEFAULT NULL,
  `afiliacion_dui` varchar(30) DEFAULT NULL,
  `nombre_paciente` varchar(300) DEFAULT NULL,
  `destinos` varchar(2000) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha_presentado` date DEFAULT NULL,
  `fecha_cancelado` date DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_trabajador` int(11) DEFAULT NULL,
  `fecha_recibido_revision` date DEFAULT NULL,
  `fecha_autorizacion_direccion` date DEFAULT NULL,
  PRIMARY KEY (`id_datos`),
  KEY `FK_diservicio` (`id_servicio`),
  KEY `FK_diestado` (`id_estado`),
  KEY `FK_datos_iniciales_usuario` (`id_trabajador`),
  CONSTRAINT `FK_datos_iniciales_usuario` FOREIGN KEY (`id_trabajador`) REFERENCES `usuario` (`id_user`),
  CONSTRAINT `FK_diestado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  CONSTRAINT `FK_diservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_iniciales: ~25 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_iniciales` DISABLE KEYS */;
INSERT INTO `datos_iniciales` (`id_datos`, `fecha`, `numero_recibo`, `afiliacion_dui`, `nombre_paciente`, `destinos`, `id_servicio`, `cantidad`, `fecha_presentado`, `fecha_cancelado`, `precio`, `id_estado`, `id_trabajador`, `fecha_recibido_revision`, `fecha_autorizacion_direccion`) VALUES
	(1, '2018-02-04', 122, '15457845', 'Gerardo Lopez Melara Melara', 'AFP', 6, 1, '2018-02-04', '2018-02-04', 2.6, 1, 2, NULL, NULL),
	(2, '2018-02-04', 4545, '1212544', 'Maria Lopez Perez ', 'Banco Agricola', 5, 5, '2018-02-04', '2018-02-04', 2.6, 2, 2, NULL, NULL),
	(3, '2018-02-04', 563214, '85478965', 'Douglas Mendoza Ponce', 'Banco de America Central', 6, 2, '2018-02-04', '2018-02-04', 2.6, 3, 2, NULL, NULL),
	(4, '2018-02-04', 48545, '87888', 'Jose Jose Cervantes ', 'Banco agropecuario', 8, 1, '2018-02-04', '2018-02-04', 2.6, 3, 2, NULL, NULL),
	(5, '2018-02-05', 1212, '7878', 'Maria Mariela Mendez Morales', 'AFP CONFIA', 6, 1, '2018-02-05', '2018-02-05', 2.6, 3, 2, NULL, NULL),
	(6, '2018-02-11', 555, '12124578', 'Isabel Caceres Romero', 'Hospital General', 7, 1, '2018-02-11', '2018-02-11', 2.6, 3, 4, '0000-00-00', '0000-00-00'),
	(7, '2018-02-11', 11111, '089280204', 'RUBENIA REGALADO DE CALLES', 'UNITED AIRLINES,FRAMINGHAM HIGH SCHOOL, BOSTON MASSACHUSETTS DE LOS ESTADOS UNIDOS DE AMERICA', 7, 3, '2018-02-11', '2018-02-11', 2.6, 4, 4, NULL, NULL),
	(8, '2018-02-11', 22222, '175 54 3525', 'RAMON ARTURO FLORES JOVEL', 'AFP CONFIA', 7, 2, '2018-02-11', '2018-02-11', 2.6, 3, 4, NULL, NULL),
	(9, '2018-02-11', 33333, '165 45 1120', 'CARLOS ARTURO MENENDEZ C/P CARLOS ARTURO MELHADO MENENDEZ', 'AFP CONFIA', 7, 1, '2018-02-11', '2018-02-11', 2.6, 3, 4, NULL, NULL),
	(10, '2018-02-11', 44444, '982 63 1081', 'ALMA VIRGINIA AVELAR DE PINEDA', 'CORTE SUPREMA DE JUSTICIA', 7, 1, '2018-02-11', '2018-02-11', 2.6, 3, 4, NULL, NULL),
	(11, '2018-02-12', NULL, '45874521', 'Gerardo Adolfo Orellana Perez', 'AFP', 5, 1, '2018-02-12', NULL, NULL, NULL, NULL, NULL, NULL),
	(12, '2018-02-12', 666666, '124578451', 'Gerardo Adolfo Orellana Perez', 'AFP', 5, 1, '2018-02-12', '2018-02-12', NULL, NULL, NULL, NULL, NULL),
	(13, '2018-02-13', 77777, '21212', 'Gerardo Adolfo Orellana Perez', 'AFP', 6, 2, '2018-02-12', '2018-02-13', NULL, NULL, NULL, NULL, NULL),
	(14, '2018-02-12', 888, '4545', 'Gerardo Adolfo Orellana Perez', 'AFP', 8, 10, '2018-02-27', '2018-02-22', 13.75, 2, 1, NULL, NULL),
	(15, '2018-02-12', 4545454, '4545', 'Gerardo Adolfo Orellana Perez', 'AFP', 7, 121212, '2018-02-13', '2018-02-13', 2.75, 2, 1, NULL, NULL),
	(16, '2018-02-12', 1111, '78454521', 'Gerardo Adolfo Orellana Perez', 'AFP CONFIA', 3, 1, '2018-02-22', '2018-02-14', 2.75, 2, NULL, NULL, NULL),
	(17, '2018-02-12', 123123, '2233114455', 'Alfonso Castro', 'BANCO AGRICOLA SA', 8, 1, '2018-02-12', '2018-02-28', 2.75, 2, 1, NULL, NULL),
	(18, '2018-02-12', 99999, '145236569', 'Maria del Carmen', 'ASESUISA', 5, 1, '2018-02-12', '2018-02-12', 2.75, 2, 1, NULL, NULL),
	(19, '2018-02-12', 101010, '5555555555', 'Maria dolores', 'ASESUISA SA DE SV', 7, 3, '2018-02-12', '2018-02-12', 2.75, 2, 1, NULL, NULL),
	(20, '2018-02-12', 454545, '4545', 'Gerardo Adolfo Orellana Perez', '4545', 7, 4, '2018-02-28', '2018-02-07', 2.75, 2, 1, NULL, NULL),
	(21, '2018-02-12', 4545, '5454', 'Gerardo Adolfo Orellana Perez', '4545', 7, 454545, '2018-02-12', '2018-02-13', 2.75, 2, 1, NULL, NULL),
	(22, '2018-02-01', 4545, '4545', '4545', '44545', 6, 444, '2018-02-13', '2018-02-13', 2.75, 2, 1, NULL, NULL),
	(23, '2018-02-12', 1231231, '1231231', 'Gerardo Adolfo Orellana Perez', '123123', 7, 1, '2018-02-12', '2018-02-12', 2.75, 2, 1, NULL, NULL),
	(24, '2018-02-12', 1123123, '1231231', 'Alfonso Castro', '4545', 3, 1, '2018-02-12', '2018-02-12', 2.75, 2, 1, NULL, NULL),
	(25, '2018-02-12', 123123123, '123123', 'Gerardo Adolfo Orellana Perez', 'AFP', 6, 1, '2018-02-13', '2018-02-13', 2.75, 1, 1, NULL, NULL);
/*!40000 ALTER TABLE `datos_iniciales` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.director
CREATE TABLE IF NOT EXISTS `director` (
  `id_director` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_director`),
  KEY `FK_dservicio` (`id_servicio`),
  KEY `FK_dstatus` (`id_status`),
  CONSTRAINT `FK_dservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  CONSTRAINT `FK_dstatus` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.director: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `director` DISABLE KEYS */;
INSERT INTO `director` (`id_director`, `nombre`, `id_status`, `id_servicio`) VALUES
	(1, 'Juan Lopez', 1, 8),
	(2, NULL, NULL, NULL);
/*!40000 ALTER TABLE `director` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.estado
CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.estado: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` (`id_estado`, `nombre_estado`, `descripcion`) VALUES
	(1, 'pendiente de envio', NULL),
	(2, 'enviada', NULL),
	(3, 'recibida', NULL),
	(4, 'revision', NULL),
	(5, 'modificacion', NULL),
	(6, 'finalizada', NULL);
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.jefe_servicio
CREATE TABLE IF NOT EXISTS `jefe_servicio` (
  `id_jefe` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jefe`),
  KEY `FK_jsservicio` (`id_servicio`),
  KEY `FK_sstatus` (`id_status`),
  CONSTRAINT `FK_jsservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  CONSTRAINT `FK_sstatus` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.jefe_servicio: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `jefe_servicio` DISABLE KEYS */;
INSERT INTO `jefe_servicio` (`id_jefe`, `nombre`, `id_status`, `id_servicio`) VALUES
	(1, 'Juan Valdez', 1, 1);
/*!40000 ALTER TABLE `jefe_servicio` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.jefe_trabajo_social
CREATE TABLE IF NOT EXISTS `jefe_trabajo_social` (
  `id_jefesocial` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jefesocial`),
  KEY `FK_jtsservicio` (`id_servicio`),
  KEY `FK_jtsstatus` (`id_status`),
  CONSTRAINT `FK_jtsservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  CONSTRAINT `FK_jtsstatus` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.jefe_trabajo_social: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `jefe_trabajo_social` DISABLE KEYS */;
INSERT INTO `jefe_trabajo_social` (`id_jefesocial`, `nombre`, `id_status`, `id_servicio`) VALUES
	(1, 'Gerardo Ponce', 1, 1),
	(2, 'Miguel Bonilla', 1, 7);
/*!40000 ALTER TABLE `jefe_trabajo_social` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.medico_tratante
CREATE TABLE IF NOT EXISTS `medico_tratante` (
  `id_medico` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_servicio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_medico`),
  KEY `FK_mtservicio` (`id_servicio`),
  KEY `FK_mtstatus` (`id_status`),
  CONSTRAINT `FK_mtservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  CONSTRAINT `FK_mtstatus` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.medico_tratante: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `medico_tratante` DISABLE KEYS */;
INSERT INTO `medico_tratante` (`id_medico`, `nombre`, `id_status`, `id_servicio`) VALUES
	(1, 'juan', 1, 1),
	(2, 'Rosa', 1, 7);
/*!40000 ALTER TABLE `medico_tratante` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.precio_constancias
CREATE TABLE IF NOT EXISTS `precio_constancias` (
  `id_precio` int(11) NOT NULL AUTO_INCREMENT,
  `precio` float DEFAULT NULL,
  PRIMARY KEY (`id_precio`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.precio_constancias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `precio_constancias` DISABLE KEYS */;
INSERT INTO `precio_constancias` (`id_precio`, `precio`) VALUES
	(1, 2.75);
/*!40000 ALTER TABLE `precio_constancias` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `id_servicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_servicio` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_servicio`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.servicios: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`) VALUES
	(1, 'na'),
	(2, 'Ortopedia'),
	(3, 'Neurocirugia'),
	(4, 'Medicina4'),
	(5, 'Medicina3'),
	(6, 'Jefatura'),
	(7, 'Emergencia'),
	(8, 'Cirugia');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.status
CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_status` varchar(50) DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.status: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`id_status`, `nombre_status`, `descripcion`) VALUES
	(1, 'Activo', 'usuario activo en sus funciones'),
	(2, 'Inactivo', 'usuario inhabilitado');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.tipo_usuario
CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id_tipousuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_tipousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.tipo_usuario: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` (`id_tipousuario`, `nombre_tipo`) VALUES
	(1, 'secretaria'),
	(2, 'trabajador'),
	(3, 'admin');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.usuario
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
  KEY `FK_ustatus` (`id_status`),
  CONSTRAINT `FK_uservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  CONSTRAINT `FK_ustatus` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`),
  CONSTRAINT `FK_utipousuario` FOREIGN KEY (`id_tipousuario`) REFERENCES `tipo_usuario` (`id_tipousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.usuario: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id_user`, `name`, `user`, `id_status`, `password`, `id_tipousuario`, `id_servicio`) VALUES
	(1, 'Garrido Irene', 'secre', 1, '202cb962ac59075b964b07152d234b70', 1, 1),
	(2, 'Perez Nathalia', 'trabajador', 1, '202cb962ac59075b964b07152d234b70', 2, 6),
	(3, 'Alonso Jose', 'admin', 1, '202cb962ac59075b964b07152d234b70', 3, 1),
	(4, 'Gerardo Magaña López', 'tra2', 1, '202cb962ac59075b964b07152d234b70', 2, 7);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
