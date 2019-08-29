/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 10.1.13-MariaDB : Database - db_planificacion
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_planificacion` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_planificacion`;

/*Table structure for table `opciones` */

DROP TABLE IF EXISTS `opciones`;

CREATE TABLE `opciones` (
  `iIdOpcion` int(10) NOT NULL AUTO_INCREMENT,
  `vOpcion` varchar(400) NOT NULL,
  `iOtro` tinyint(1) NOT NULL DEFAULT '0',
  `iTipoR` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0= Opción múltiple, 1=Dicotómica, 2=Pregunta abierta',
  `iActivo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`iIdOpcion`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `opciones` */

insert  into `opciones`(`iIdOpcion`,`vOpcion`,`iOtro`,`iTipoR`,`iActivo`) values (1,'Si',0,1,1),(2,'No',0,1,1),(3,'R:',1,2,1),(4,'Primer lugar',0,0,1),(5,'Segundo lugar',0,0,1),(6,'Ninguna de las anteriores',0,0,1);

/*Table structure for table `preguntas` */

DROP TABLE IF EXISTS `preguntas`;

CREATE TABLE `preguntas` (
  `iIdPregunta` int(10) NOT NULL AUTO_INCREMENT,
  `vPregunta` varchar(400) NOT NULL,
  `iPonderacion` int(10) NOT NULL,
  `iEvidencia` tinyint(1) NOT NULL DEFAULT '0',
  `iTipoPregunta` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=Opción múliple, 1=Dicotómica (si,no),  2=Pregunta abierta',
  `iActivo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`iIdPregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `preguntas` */

insert  into `preguntas`(`iIdPregunta`,`vPregunta`,`iPonderacion`,`iEvidencia`,`iTipoPregunta`,`iActivo`) values (1,'¿Está usted de acuerdo con esto?',10,0,1,1),(2,'Describa cuales considera que son sus fortalezas',15,0,2,1),(3,'¿Su municipio cuenta con un plan estatal de desarrollo?',12,1,1,1),(4,'¿En que posición cree usted que quedará?',23,0,0,1);

/*Table structure for table `resp_usuario` */

DROP TABLE IF EXISTS `resp_usuario`;

CREATE TABLE `resp_usuario` (
  `iIdRespuesta` int(10) NOT NULL,
  `vRespuesta` varchar(500) NOT NULL,
  `iIdUsuario` int(10) NOT NULL,
  `iRevisado` tinyint(1) NOT NULL DEFAULT '0',
  `iCalificacion` int(10) NOT NULL DEFAULT '0',
  `vArchivo` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `resp_usuario` */

insert  into `resp_usuario`(`iIdRespuesta`,`vRespuesta`,`iIdUsuario`,`iRevisado`,`iCalificacion`,`vArchivo`) values (1,'',2,0,12,''),(3,'Soy la mera v....',2,0,2,''),(4,'',2,0,4,'Evidencia_3_2.pdf');

/*Table structure for table `respuestas` */

DROP TABLE IF EXISTS `respuestas`;

CREATE TABLE `respuestas` (
  `iIdRespuesta` int(10) NOT NULL AUTO_INCREMENT,
  `iIdPregunta` int(10) NOT NULL,
  `iIdOpcion` int(10) NOT NULL,
  `iActivo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iIdRespuesta`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `respuestas` */

insert  into `respuestas`(`iIdRespuesta`,`iIdPregunta`,`iIdOpcion`,`iActivo`) values (1,1,1,1),(2,1,2,1),(3,2,3,1),(4,3,1,1),(5,3,2,1),(6,4,4,1),(7,4,5,1),(8,4,6,1);

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
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

/*Data for the table `usuarios` */

insert  into `usuarios`(`iIdUsuario`,`vNombreUsuario`,`vContrasenia`,`vCorreo`,`iTipoUsuario`,`iTipo`,`vEntidad`,`vMunicipio`,`iActivo`) values (1,'victor.barbosa','e3ba63df7985c6e9ab0d157ee0271183f89c02a7','vg.barbosa89@gmail.com',1,1,'Yucatán',NULL,1),(2,'ayuntam.merida','40bd001563085fc35165329ea1ff5c5ecbdbbeef','ayuntamiento.merida@hotmail.com',3,2,'','Mérida',1),(3,'ayunta.izamal','40bd001563085fc35165329ea1ff5c5ecbdbbeef','',3,2,NULL,'Izamal',1),(4,'ayunta.valladolid','40bd001563085fc35165329ea1ff5c5ecbdbbeef','',3,2,NULL,'Valladolid',1),(5,'durango','40bd001563085fc35165329ea1ff5c5ecbdbbeef','',3,1,'Durango',NULL,0),(6,'jorge.estrella','40bd001563085fc35165329ea1ff5c5ecbdbbeef','',2,1,NULL,NULL,1),(7,'juan.perez','40bd001563085fc35165329ea1ff5c5ecbdbbeef','',2,2,NULL,NULL,0),(8,'geovanni.barbosa','e3ba63df7985c6e9ab0d157ee0271183f89c02a7','',1,2,NULL,NULL,0),(9,'g.barbosa','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','geo_barbosa89@hotmail.com',2,2,NULL,NULL,1),(10,'juan.tun','a01b6fa5e51214933ba5d4fdf50e47292523f352','juan@hotmail.com',2,1,NULL,NULL,1),(11,'juan.tun','a01b6fa5e51214933ba5d4fdf50e47292523f352','juan.tun@gmail.com',3,1,NULL,NULL,0),(12,'juan.tun','8cb2237d0679ca88db6464eac60da96345513964','geo_barbosa89@hotmail.com',2,1,'Yucatán','',0),(13,'ayunta.bernal','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','bernal@queretaro.gob.mx',1,2,'','Bernal',1),(14,'ayunta.tequis','40bd001563085fc35165329ea1ff5c5ecbdbbeef','tequis@gmail.com',3,2,'','Tequisquiapan',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
