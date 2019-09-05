/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.7.26 : Database - db_planificacion
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `iplan_calif` */

DROP TABLE IF EXISTS `iplan_calif`;

CREATE TABLE `iplan_calif` (
  `iIdUsuario` int(10) NOT NULL,
  `iIdPregunta` int(10) NOT NULL,
  `vCalificacion` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iIdUsuario`,`iIdPregunta`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `iplan_calif` */

/*Table structure for table `iplan_cuestionarios` */

DROP TABLE IF EXISTS `iplan_cuestionarios`;

CREATE TABLE `iplan_cuestionarios` (
  `iIdCuestionario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vCuestionario` varchar(150) NOT NULL,
  `vDescripcion` text,
  `iTipo` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1= Entidad federativa, 2 = Municipio',
  `iActivo` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`iIdCuestionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `iplan_cuestionarios` */

/*Table structure for table `iplan_opciones` */

DROP TABLE IF EXISTS `iplan_opciones`;

CREATE TABLE `iplan_opciones` (
  `iIdOpcion` int(10) NOT NULL AUTO_INCREMENT,
  `vOpcion` varchar(400) CHARACTER SET latin1 NOT NULL,
  `iOtro` tinyint(1) NOT NULL DEFAULT '0',
  `iTipoR` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0= Opción múltiple, 1=Dicotómica, 2=Pregunta abierta',
  `iActivo` tinyint(1) DEFAULT '1',
  `iIdPregunta` int(10) NOT NULL DEFAULT '0',
  `vValor` int(2) NOT NULL DEFAULT '0' COMMENT 'Máximo 3 pts',
  PRIMARY KEY (`iIdOpcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `iplan_opciones` */

/*Table structure for table `iplan_preguntas` */

DROP TABLE IF EXISTS `iplan_preguntas`;

CREATE TABLE `iplan_preguntas` (
  `iIdPregunta` int(10) NOT NULL AUTO_INCREMENT,
  `vPregunta` varchar(400) CHARACTER SET latin1 NOT NULL,
  `iPonderacion` int(10) NOT NULL DEFAULT '0',
  `iEvidencia` tinyint(1) NOT NULL DEFAULT '0',
  `iTipoPregunta` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=Opción múliple, 1=Dicotómica (si,no),  2=Pregunta abierta, 3=Selección multiple (checkbox)',
  `iActivo` tinyint(1) DEFAULT '1',
  `iIdCuestionario` int(10) unsigned NOT NULL DEFAULT '1',
  `iNumero` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`iIdPregunta`),
  KEY `FK_pregunta_cuestionario` (`iIdCuestionario`),
  CONSTRAINT `FK_pregunta_cuestionario` FOREIGN KEY (`iIdCuestionario`) REFERENCES `iplan_cuestionarios` (`iIdCuestionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `iplan_preguntas` */

/*Table structure for table `iplan_rangos` */

DROP TABLE IF EXISTS `iplan_rangos`;

CREATE TABLE `iplan_rangos` (
  `iIdPregunta` int(10) NOT NULL,
  `vValor` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `iLimiteMin` varchar(50) NOT NULL DEFAULT '0',
  `iLimiteMax` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`iIdPregunta`,`vValor`),
  CONSTRAINT `FK_rango_pregunta` FOREIGN KEY (`iIdPregunta`) REFERENCES `iplan_preguntas` (`iIdPregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `iplan_rangos` */

/*Table structure for table `iplan_resp_usuario` */

DROP TABLE IF EXISTS `iplan_resp_usuario`;

CREATE TABLE `iplan_resp_usuario` (
  `iIdRespuesta` int(10) NOT NULL,
  `vRespuesta` varchar(500) NOT NULL,
  `iIdUsuario` int(10) NOT NULL,
  `iRevisado` tinyint(1) NOT NULL DEFAULT '0',
  `iCalificacion` int(10) NOT NULL DEFAULT '0',
  `vArchivo` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iplan_resp_usuario` */

/*Table structure for table `iplan_respuestas` */

DROP TABLE IF EXISTS `iplan_respuestas`;

CREATE TABLE `iplan_respuestas` (
  `iIdRespuesta` int(10) NOT NULL AUTO_INCREMENT,
  `iIdPregunta` int(10) NOT NULL,
  `iIdOpcion` int(10) NOT NULL,
  `iActivo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iIdRespuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `iplan_respuestas` */

/*Table structure for table `iplan_usuarios` */

DROP TABLE IF EXISTS `iplan_usuarios`;

CREATE TABLE `iplan_usuarios` (
  `iIdUsuario` int(10) NOT NULL AUTO_INCREMENT,
  `vNombreUsuario` varchar(200) NOT NULL,
  `vContrasenia` varchar(50) NOT NULL,
  `vCorreo` varchar(100) NOT NULL,
  `iTipoUsuario` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=Admin, 2=Moderador, 3=Usuario',
  `iTipo` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1= Entidad federativa, 2 = Municipio',
  `vEntidad` varchar(70) DEFAULT NULL,
  `vMunicipio` varchar(70) DEFAULT NULL,
  `iActivo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iIdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `iplan_usuarios` */

insert  into `iplan_usuarios`(`iIdUsuario`,`vNombreUsuario`,`vContrasenia`,`vCorreo`,`iTipoUsuario`,`iTipo`,`vEntidad`,`vMunicipio`,`iActivo`) values (1,'victor.barbosa','e3ba63df7985c6e9ab0d157ee0271183f89c02a7','vg.barbosa89@gmail.com',1,1,'Yucatán',NULL,1),(2,'ayuntam.merida','40bd001563085fc35165329ea1ff5c5ecbdbbeef','ayuntamiento.merida@hotmail.com',3,2,'','Mérida',1),(3,'ayunta.izamal','40bd001563085fc35165329ea1ff5c5ecbdbbeef','',3,2,NULL,'Izamal',1),(4,'ayunta.valladolid','40bd001563085fc35165329ea1ff5c5ecbdbbeef','',3,2,NULL,'Valladolid',1),(5,'durango','40bd001563085fc35165329ea1ff5c5ecbdbbeef','',3,1,'Durango',NULL,0),(6,'jorge.estrella','40bd001563085fc35165329ea1ff5c5ecbdbbeef','',2,1,NULL,NULL,1),(7,'juan.perez','40bd001563085fc35165329ea1ff5c5ecbdbbeef','',2,2,NULL,NULL,0),(8,'geovanni.barbosa','e3ba63df7985c6e9ab0d157ee0271183f89c02a7','',1,2,NULL,NULL,0),(9,'g.barbosa','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','geo_barbosa89@hotmail.com',2,2,NULL,NULL,1),(10,'juan.tun','a01b6fa5e51214933ba5d4fdf50e47292523f352','juan@hotmail.com',2,1,NULL,NULL,1),(11,'juan.tun','a01b6fa5e51214933ba5d4fdf50e47292523f352','juan.tun@gmail.com',3,1,NULL,NULL,0),(12,'juan.tun','8cb2237d0679ca88db6464eac60da96345513964','geo_barbosa89@hotmail.com',2,1,'Yucatán','',0),(13,'ayunta.bernal','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','bernal@queretaro.gob.mx',1,2,'','Bernal',1),(14,'ayunta.tequis','40bd001563085fc35165329ea1ff5c5ecbdbbeef','tequis@gmail.com',3,2,'','Tequisquiapan',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
