-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.30-MariaDB - mariadb.org binary distribution
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

-- Volcando estructura para tabla ts2.comentarios
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id_comentario` int(11) NOT NULL AUTO_INCREMENT,
  `id_datos` int(11) NOT NULL,
  `comentario` varchar(3000) NOT NULL,
  PRIMARY KEY (`id_comentario`),
  KEY `FK_comentarios_datos_iniciales` (`id_datos`),
  CONSTRAINT `FK_comentarios_datos_iniciales` FOREIGN KEY (`id_datos`) REFERENCES `datos_iniciales` (`id_datos`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.comentarios: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` (`id_comentario`, `id_datos`, `comentario`) VALUES
	(4, 2, 'hola'),
	(5, 1, 'hola 2'),
	(6, 1, 'Esta mal el nombre del solicitante, falta agregar el medico tratante. '),
	(7, 4, 'Solo tenia que crear 2 constancias, elimine la constancia 2'),
	(8, 4, 'Agrege otra constancia ');
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;

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

-- Volcando datos para la tabla ts2.datos_complementarios: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_complementarios` DISABLE KEYS */;
INSERT INTO `datos_complementarios` (`id_datosc`, `id_constancia`, `id_datos`, `fecha_consulta`, `id_servicio`, `diagnostico`, `nombre_solicitante`, `parentesco`, `destino`, `fecha_extension`, `id_medico`, `id_jefe`, `id_jefesocial`, `id_director`, `estado`) VALUES
	(1, 1, 1, '2017-12-18', 7, 'Miastenia Gravis, ingresando al Servicio de Medicina Tres el mismo día con igual diagnóstico', 'SR. ESTEBAN PINEDA VALCACERES', 'esposo de paciente', 'CORTE SUPREMA DE JUSTICIA', '2018-01-15', 3, 2, 3, 3, 1),
	(2, 1, 2, '2017-12-18', 7, 'Angina Inestable, ingresando al Servicio de Medicina Tres el mismo día con igual diagnóstico', 'SR. ROBERTO DE JESUS GUTIERREZ BALDIZON', 'hijo', 'BANCO CITI', '2018-01-05', 4, 2, 3, 3, 0),
	(3, 3, 3, '2018-01-04', 7, 'Lumbociatica Bilateral, con historia de 4 meses de dolor en región escapular izquierda, además de treinta días de dificultad para deambular, el día de su ingreso sufre caída desde su propia altura con imposibilidad para incorporarse, ingresando al Servicio de Neurocirugía el mismo día con diagnòstico de Síndrome Medular más Paraparesia, intervenido quirúrgicamente el día 10 de de enero de 2014 realizándose Laminectomìa Descompresiva T3-T4 más Toma de Biopsia de Tumor T3-T4. de Lesión Tumoral Paravertebral T3-T4 que reportó Metástasis de Adenocarcinoma a Vertebra T4, el 27 de enero de 2014 se le tomò TAC de Tórax que concluyó Masa Pulmonar que refuerza con el contraste en Vèrtice Izquierdo y según nota de medico tratante paciente con Càncer Primario de Pulmón y con Metàstasis  de Pulmón a Columna, el día 28 de enero de 2014 se le realizó Endoscopía Superior que diagnosticó Ulcera Gigante penetrada en Ante Gástrico más Ulcera en Bulbo Duodenal más Ulcera en Cuerpo Gástrico. El día 29 de enero de 2014 fue trasladado al Servicio de Medicina 3 con diagnóstico de Metastasis de Adenocarcinoma en columna Torácica más Sangrado del Tubo Digestivo Superior. Según expediente clínico paciente con antecedentes médicos conocidos de Infarto Agudo al Miocardio en 2011', 'Sra. ANA GLADIS CRUZ FIGUEROA C/P ANA GLADIS FIGUEROA ', 'compañera de vida de paciente', 'AFP CONFIA', '2018-01-12', 5, 2, 3, 3, 0),
	(4, 3, 4, '2017-12-15', 7, 'Bronconeumonía más Diabetes Mellitus Insulinodependiente con Complicaciones Renales, ingresando en el Servicio de Medicina Tres el mismo día con diagnóstico Insuficiencia Renal Crónica. Según expediente clínico paciente con antecedentes medicos conocidos de Diabetes Mellitus desde 1995 más Hipertensión Arterial con periodo de evolución desconocido', 'SRA. CINTHIA TALIA VARELA DE CARBALLO ', 'esposa de paciente', 'FONDO SOCIAL PARA LA VIVIENDA', '2018-01-15', 4, 2, 3, 3, 0),
	(5, 3, 4, '2017-12-15', 7, 'Bronconeumonía más Diabetes Mellitus Insulinodependiente con Complicaciones Renales, ingresando en el Servicio de Medicina Tres el mismo día con diagnóstico Insuficiencia Renal Crónica. Según expediente clínico paciente con antecedentes medicos conocidos de Diabetes Mellitus desde 1995 màs Hipertensión Arterial con periodo de evolución desconocido', 'SRA. CINTHIA TALIA VARELA DE CARBALLO ', 'esposa de paciente', 'AFP CRECER', '2018-01-15', 4, 2, 3, 3, 0),
	(6, 3, 4, '2018-01-15', 7, 'Bronconeumonía más Diabetes Mellitus Insulinodependiente con Complicaciones Renales, ingresando en el Servicio de Medicina Tres el mismo día con diagnóstico Insuficiencia Renal Crónica. Según expediente clínico paciente con antecedentes medicos conocidos de Diabetes Mellitus desde 1995 màs Hipertensión Arterial con periodo de evolución desconocido', 'SRA. SANDRA ISABEL CARBALLO DE BARRIOS ', 'hermana de paciente', 'ASESUISA', '2018-01-15', 4, 2, 3, 3, 0),
	(7, 2, 5, '2017-12-14', 7, 'Hemorragia Gastrointestinal, ingresando al Servicio de Medicina Tres el mismo día con igual diagnóstico', 'Sr. LUIS JAVIER GUTIERREZ RUIZ ', 'hijo de paciente', 'REGISTRO NACIONAL DE PERSONAS NATURALES', '2018-01-05', 3, 2, 3, 3, 0),
	(8, 1, 8, '2018-02-27', 7, 'Falso Positivo 2 ', 'ANA VILMA DE ESCOBAR', 'Madre de paciente', 'AFP', '2018-02-27', 3, 2, 3, 3, 0);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_const_alta: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_const_alta` DISABLE KEYS */;
INSERT INTO `datos_const_alta` (`id_datosca`, `id_datosc`, `fecha_de_alta`, `diagnostico`) VALUES
	(1, 1, '2017-12-29', 'Síndrome de Guillan Barré'),
	(2, 2, '2018-03-04', 'Enfermedad del tronco coronario y múltiples vasos 3'),
	(3, 8, '2018-03-04', 'Falso Negativo 2');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_const_fallecimiento: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_const_fallecimiento` DISABLE KEYS */;
INSERT INTO `datos_const_fallecimiento` (`id_datoscf`, `id_datosc`, `fecha_defuncion`, `diagnostico`) VALUES
	(1, 3, '2018-02-21', 'Sangrado de Tubo Digestivo Superior más Ulcera Duodenal más Cáncer de Pulmón'),
	(2, 4, '2018-03-04', 'Neumonía Comunitaria más Enfermedad Renal Crónica mas Diabetes Mellitus 2'),
	(3, 5, '2017-12-15', 'Neumonía Comunitaria más Enfermedad Renal Crónica mas Diabetes Mellitus'),
	(4, 6, '2017-12-15', 'Neumonía Comunitaria más Enfermedad Renal Crónica mas Diabetes Mellitus');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_const_ingreso: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_const_ingreso` DISABLE KEYS */;
INSERT INTO `datos_const_ingreso` (`id_datosci`, `id_datosc`, `diagnostico`) VALUES
	(1, 7, '');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.datos_iniciales: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `datos_iniciales` DISABLE KEYS */;
INSERT INTO `datos_iniciales` (`id_datos`, `fecha`, `numero_recibo`, `afiliacion_dui`, `nombre_paciente`, `destinos`, `id_servicio`, `cantidad`, `fecha_presentado`, `fecha_cancelado`, `precio`, `id_estado`, `id_trabajador`, `fecha_recibido_revision`, `fecha_autorizacion_direccion`) VALUES
	(1, '2018-02-25', 1111111111, '982631081', 'ALMA VIRGINIA AVELAR DE PINEDA', 'CORTE SUPREMA DE JUSTICIA', 7, 1, '2018-02-25', '2018-02-25', 2.75, 5, 2, NULL, NULL),
	(2, '2018-02-25', 2147483647, '378592877', 'ROBERTO DE JESUS GUTIERREZ BALDIZON', 'BANCO CITI', 7, 1, '2018-02-25', '2018-02-25', 2.75, 2, 1, NULL, NULL),
	(3, '2018-02-25', 2147483647, '165451120', 'CARLOS ARTURO MENENDEZ', 'AFP CONFIA', 7, 1, '2018-02-21', '2018-02-25', 2.75, 1, 1, NULL, NULL),
	(4, '2018-02-25', 2147483647, '198777768', 'FRANCISCO JAVIER CARBALLO MENA', 'ASESUISA, AFP CRECER, FONDO SOCIAL PARA LA VIVIENDA', 7, 3, '2018-02-25', '2018-02-25', 2.75, 4, 2, NULL, NULL),
	(5, '2018-02-25', 2147483647, '175562116', 'LUIS EDGARDO GUTIERREZ TOBAR', 'REGISTRO NACIONAL DE PERSONAS NATURALES', 7, 1, '2018-02-25', '2018-02-25', 2.75, 1, 1, NULL, NULL),
	(6, '2018-02-26', 1234564123, '123456789', 'ALFONSO CASTRO', 'AFP CONFIA', 7, 1, '2018-02-26', '2018-02-26', 2.75, 2, 1, NULL, NULL),
	(7, '2018-02-26', 2147483647, '123232323', 'MIGUEL LOPEZ', 'CORTE SUPREMA DE JUSTICIA', 7, 1, '2018-02-26', '2018-02-26', 2.75, 1, 1, NULL, NULL),
	(8, '2018-02-27', 1222122332, '111212212', 'Gerardo Adolfo Orellana Perez', 'AFP CONFIA', 7, 2, '2018-02-27', '2018-02-27', 2.75, 4, 2, NULL, NULL),
	(9, '2018-02-23', 1111323223, '121232323', 'GERARD', 'SSD', 5, 1, '2018-02-26', '2018-02-26', 2.75, 2, 1, NULL, NULL),
	(10, '2018-03-04', 1232121231, '111111111', 'GERARDO PARKER', 'LOMA LINDA', 3, 1, '2018-03-04', '2018-03-04', 2.75, 2, 1, NULL, NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.director: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `director` DISABLE KEYS */;
INSERT INTO `director` (`id_director`, `nombre`, `id_status`, `id_servicio`) VALUES
	(3, 'Dr. Manuel de Jesús Villalobos Parada', 1, 1);
/*!40000 ALTER TABLE `director` ENABLE KEYS */;

-- Volcando estructura para tabla ts2.estado
CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) DEFAULT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.estado: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` (`id_estado`, `nombre_estado`, `descripcion`) VALUES
	(1, 'pendiente de envio', NULL),
	(2, 'enviada', NULL),
	(3, 'recibida', NULL),
	(4, 'revision', NULL),
	(5, 'modificacion', NULL),
	(6, 'finalizada', NULL),
	(7, 'guardada', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.jefe_servicio: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `jefe_servicio` DISABLE KEYS */;
INSERT INTO `jefe_servicio` (`id_jefe`, `nombre`, `id_status`, `id_servicio`) VALUES
	(2, 'Dra. Yanira Bonilla de Avilés', 1, 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.jefe_trabajo_social: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `jefe_trabajo_social` DISABLE KEYS */;
INSERT INTO `jefe_trabajo_social` (`id_jefesocial`, `nombre`, `id_status`, `id_servicio`) VALUES
	(3, 'Lcda. Rina Villeda de Loucel', 1, 1);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla ts2.medico_tratante: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `medico_tratante` DISABLE KEYS */;
INSERT INTO `medico_tratante` (`id_medico`, `nombre`, `id_status`, `id_servicio`) VALUES
	(3, 'Dr. Guillermo Antonio Marroquín Aguilar', 1, 1),
	(4, 'Dra. Claudia Marcela Reyes Valencia', 1, 1),
	(5, 'Dr. Oscar Armando Rosales', 1, 1);
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

-- Volcando datos para la tabla ts2.servicios: ~8 rows (aproximadamente)
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
