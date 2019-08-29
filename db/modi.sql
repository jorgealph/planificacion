CREATE TABLE `db_planificacion`.`iplan_cuestionario`(  
  `iIdCuestionario` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vCuestionario` VARCHAR(150) NOT NULL,
  `vDescripcion` TEXT,
  `iTipo` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1= Entidad federativa, 2 = Municipio',
  `iActivo` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`iIdCuestionario`)
) ENGINE=INNODB CHARSET=utf8;

insert into `db_planificacion`.`iplan_cuestionario` (`vCuestionario`) values ('Cuestionario 1');

ALTER TABLE `db_planificacion`.`iplan_preguntas`   
  CHANGE `iTipoPregunta` `iTipoPregunta` TINYINT(1) DEFAULT 1  NOT NULL  COMMENT '0=Opción múliple, 1=Dicotómica (si,no),  2=Pregunta abierta, 3=Selección multiple (checkbox)';

ALTER TABLE `db_planificacion`.`iplan_preguntas`
	CHANGE `iPonderacion` `iPonderacion` INT(10) DEFAULT 0  NOT NULL,
  ADD COLUMN `iIdCuestionario` INT(10) UNSIGNED DEFAULT 1  NOT NULL AFTER `iActivo`,
  ADD CONSTRAINT `FK_pregunta_cuestionario` FOREIGN KEY (`iIdCuestionario`) REFERENCES `db_planificacion`.`iplan_cuestionario`(`iIdCuestionario`) ON UPDATE RESTRICT ON DELETE RESTRICT;

CREATE TABLE `db_planificacion`.`iplan_rangos`(  
  `iIdPregunta` INT(10) NOT NULL,
  `vValor` TINYINT(2) UNSIGNED NOT NULL DEFAULT 0,
  `iLimiteMin` TINYINT(2) UNSIGNED NOT NULL DEFAULT 0,
  `iLimiteMax` TINYINT(2) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`iIdPregunta`, `vValor`),
  CONSTRAINT `FK_rango_pregunta` FOREIGN KEY (`iIdPregunta`) REFERENCES `db_planificacion`.`iplan_preguntas`(`iIdPregunta`) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=INNODB CHARSET=utf8;
