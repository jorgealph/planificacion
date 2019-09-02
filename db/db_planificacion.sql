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
/*Table structure for table `iplan_cuestionarios` */

DROP TABLE IF EXISTS `iplan_cuestionarios`;

CREATE TABLE `iplan_cuestionarios` (
  `iIdCuestionario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vCuestionario` varchar(150) NOT NULL,
  `vDescripcion` text,
  `iTipo` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1= Entidad federativa, 2 = Municipio',
  `iActivo` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`iIdCuestionario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `iplan_cuestionarios` */

insert  into `iplan_cuestionarios`(`iIdCuestionario`,`vCuestionario`,`vDescripcion`,`iTipo`,`iActivo`) values (1,'Cuestionario 1',NULL,1,0),(2,'Cuestionario 2','',2,0),(3,'','',1,1),(4,'Cuestionario 4','',2,1),(5,'','',1,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

/*Data for the table `iplan_opciones` */

insert  into `iplan_opciones`(`iIdOpcion`,`vOpcion`,`iOtro`,`iTipoR`,`iActivo`,`iIdPregunta`,`vValor`) values (1,'Si',0,1,0,0,0),(2,'No',0,1,0,0,0),(3,'R:',1,2,0,0,0),(4,'Primer lugar',0,0,0,0,0),(5,'Segundo lugar',0,0,0,0,0),(6,'Ninguna de las anteriores',0,0,0,0,0),(7,'a) Mujeres, niñas y niños',1,1,1,0,0),(8,'b) Población indígena',1,1,1,0,0),(9,'c) Personas con discapacidad',1,0,1,0,0),(10,'Sí',0,0,1,6,0),(11,'Opcion 2',0,0,0,6,1),(12,'Opcion 3',0,0,0,6,2),(13,'No',0,0,1,6,3),(14,'Esta es una opción',0,0,1,7,0),(15,'Opcion 2',0,0,1,7,1),(16,'Opcion 3',0,0,1,7,2),(17,'Opcion 4',0,0,1,7,3),(18,'Opcion 1',0,0,1,8,0),(19,'Opcion 2',0,0,1,8,1),(20,'Opcion 3',0,0,1,8,2),(21,'Opcion 4',0,0,1,8,3),(22,'Opcion 1',0,0,1,9,0),(23,'Opcion 2',0,0,1,9,1),(24,'Opcion 3',0,0,1,9,2),(25,'Opcion 4',0,0,1,9,3),(26,'Opcion 1',0,0,1,10,0),(27,'Opcion 2',0,0,1,10,1),(28,'Opcion 3',0,0,1,10,2),(29,'Opcion 4',0,0,1,10,3),(30,'Opcion 1',0,0,1,11,0),(31,'Opcion 2',0,0,1,11,1),(32,'Opcion 3',0,0,1,11,2),(33,'Opcion 4',0,0,1,11,3),(34,'Opcion 1',0,0,1,12,0),(35,'Opcion 2',0,0,1,12,1),(36,'Opcion 3',0,0,1,12,2),(37,'Opcion 4',0,0,1,12,3),(38,'Respuesta 1',0,0,1,13,0),(39,'Respuesta 2',0,0,1,13,1),(40,'Respuesta 3',0,0,1,13,2),(41,'Respuesta 4',0,0,1,13,3),(42,'Respuesta..',0,0,1,13,-1),(43,'Respuesta...',0,0,1,13,-1),(44,'Respuesta....',0,0,1,13,-1),(45,'Opcion a',0,0,1,14,0),(46,'Opcion b',0,0,1,14,1),(47,'Opcion c',0,0,1,14,2),(48,'Opcion d',0,0,1,14,3),(49,'Opcion 1',0,0,1,15,0),(50,'Opcion 2',0,0,1,15,1),(51,'Opcion 3',0,0,1,15,2),(52,'Opcion 4',0,0,1,15,3),(53,'Opcion 1',0,0,1,16,0),(54,'Opcion 2',0,0,1,16,1),(55,'Opcion 3',0,0,1,16,2),(56,'Opcion 4',0,0,1,16,3),(57,'Opcion 1',0,0,1,17,0),(58,'Opcion 2',0,0,1,17,1),(59,'Opcion 3',0,0,1,17,2),(60,'Opcion 4',0,0,1,17,3),(61,'Respuesta',0,0,1,17,-1),(62,'Opcion 1',0,0,1,18,0),(63,'Opcion 2',0,0,1,18,1),(64,'Opcion 3',0,0,1,18,2),(65,'Opcion 4',0,0,1,18,3),(66,'Opcion 1',0,0,0,19,0),(67,'Opcion 2',0,0,0,19,1),(68,'Opcion 3',0,0,0,19,2),(69,'Opcion 4',0,0,1,19,3);

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `iplan_preguntas` */

insert  into `iplan_preguntas`(`iIdPregunta`,`vPregunta`,`iPonderacion`,`iEvidencia`,`iTipoPregunta`,`iActivo`,`iIdCuestionario`,`iNumero`) values (1,'¿Está usted de acuerdo con esto?',10,0,1,0,1,0),(2,'Describa cuales considera que son sus fortalezas',15,0,2,0,1,0),(3,'¿Su municipio cuenta con un plan estatal de desarrollo?',12,1,1,0,1,0),(4,'¿En que posición cree usted que quedará?',23,0,0,0,1,0),(5,'En el proceso de elaboración del Plan Estatal de Desarrollo, ¿se tomaron en cuenta los derechos de los siguientes grupos? (señale cuáles y en caso afirmativo, justifique)',9,0,1,0,1,0),(6,'Pregunta 1',0,0,1,1,1,0),(7,'Pregunta 2',0,0,0,1,1,0),(8,'Pregunta 3',0,0,0,1,1,0),(9,'',0,0,0,1,1,0),(10,'',0,0,0,1,1,0),(11,'',0,0,0,1,1,0),(12,'',0,0,0,1,1,0),(13,'Última pregunta',0,0,3,1,1,0),(14,'Pregunta 1',0,0,0,1,1,0),(15,'',0,0,0,1,1,0),(16,'',0,0,0,1,1,0),(17,'',0,0,3,1,2,0),(18,'',0,0,0,1,5,0),(19,'',0,0,2,1,5,0);

/*Table structure for table `iplan_rangos` */

DROP TABLE IF EXISTS `iplan_rangos`;

CREATE TABLE `iplan_rangos` (
  `iIdPregunta` int(10) NOT NULL,
  `vValor` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `iLimiteMin` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `iLimiteMax` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`iIdPregunta`,`vValor`),
  CONSTRAINT `FK_rango_pregunta` FOREIGN KEY (`iIdPregunta`) REFERENCES `iplan_preguntas` (`iIdPregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `iplan_rangos` */

insert  into `iplan_rangos`(`iIdPregunta`,`vValor`,`iLimiteMin`,`iLimiteMax`) values (19,0,0,0),(19,1,0,0),(19,2,0,0),(19,3,0,0);

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `iplan_respuestas` */

insert  into `iplan_respuestas`(`iIdRespuesta`,`iIdPregunta`,`iIdOpcion`,`iActivo`) values (1,1,1,1),(2,1,2,1),(3,2,3,1),(4,3,1,1),(5,3,2,1),(6,4,4,1),(7,4,5,1),(8,4,6,1),(9,5,7,0),(10,5,8,0),(11,5,9,0),(12,5,7,0),(13,5,7,0),(14,5,7,1),(15,5,8,1);

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
