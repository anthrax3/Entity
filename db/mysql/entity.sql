-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suburb_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL DEFAULT 'NULL' COMMENT 'Tipo de endereço (comercial e residencial)',
  `street` varchar(255) NOT NULL DEFAULT 'NULL',
  `zonecode` varchar(50) NOT NULL DEFAULT 'NULL',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `suburb_id` (`suburb_id`),
  KEY `city_id` (`city_id`),
  KEY `zone_id` (`zone_id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `address_ibfk_1` FOREIGN KEY (`suburb_id`) REFERENCES `suburb` (`id`),
  CONSTRAINT `address_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `address_ibfk_3` FOREIGN KEY (`zone_id`) REFERENCES `zone` (`id`),
  CONSTRAINT `address_ibfk_4` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de endereços';


DROP TABLE IF EXISTS `address_complement`;
CREATE TABLE `address_complement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `complement` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `address_id` (`address_id`),
  CONSTRAINT `address_complement_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de complementos do endereço';


DROP TABLE IF EXISTS `address_number`;
CREATE TABLE `address_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `address_id` (`address_id`),
  CONSTRAINT `address_number_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de numeros do endereço';


DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zone_id` (`zone_id`),
  CONSTRAINT `city_ibfk_1` FOREIGN KEY (`zone_id`) REFERENCES `zone` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de cidades';


DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de países';


DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL COMMENT 'Código para uso interno',
  `token` varchar(50) NOT NULL COMMENT 'chave de acesso/identificação unica',
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `blocked_reason` mediumtext,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `observation` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Dados do cliente';


DROP TABLE IF EXISTS `customer_address`;
CREATE TABLE `customer_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `address_number_id` int(11) DEFAULT NULL,
  `address_complement_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `address_id` (`address_id`),
  CONSTRAINT `customer_address_ibfk_4` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_address_ibfk_5` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relação do cliente e endereço';


DROP TABLE IF EXISTS `customer_email`;
CREATE TABLE `customer_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `email_id` (`email_id`),
  CONSTRAINT `customer_email_ibfk_5` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_email_ibfk_6` FOREIGN KEY (`email_id`) REFERENCES `email` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relação do cliente e emails';


DROP TABLE IF EXISTS `customer_field`;
CREATE TABLE `customer_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_field_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Campos personalizados';


DROP TABLE IF EXISTS `customer_filed_value`;
CREATE TABLE `customer_filed_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_field_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_field_id` (`customer_field_id`),
  CONSTRAINT `customer_filed_value_ibfk_2` FOREIGN KEY (`customer_field_id`) REFERENCES `customer_field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Valores dos campos personalizados do cliente';


DROP TABLE IF EXISTS `customer_person`;
CREATE TABLE `customer_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_person_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relação do cliente com entidade pessoa';


DROP TABLE IF EXISTS `customer_person_juridical`;
CREATE TABLE `customer_person_juridical` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_person_id` int(11) NOT NULL,
  `corporate_name` varchar(255) NOT NULL COMMENT 'razao social',
  `trading_name` varchar(255) NOT NULL DEFAULT 'NULL' COMMENT 'nome fantasia',
  `registration_corporate_taxpayers` varchar(50) NOT NULL DEFAULT ' ' COMMENT 'cnpj',
  `state_registration` varchar(50) DEFAULT NULL COMMENT 'inscricao estadual',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_person_id` (`customer_person_id`),
  CONSTRAINT `customer_person_juridical_ibfk_2` FOREIGN KEY (`customer_person_id`) REFERENCES `customer_person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cliente pessoa jurídica';


DROP TABLE IF EXISTS `customer_person_natural`;
CREATE TABLE `customer_person_natural` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_person_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `individual_taxpayer_registration` varchar(25) NOT NULL COMMENT 'cpf',
  `identity_document` varchar(25) DEFAULT NULL COMMENT 'rg',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_person_id` (`customer_person_id`),
  CONSTRAINT `customer_person_natural_ibfk_2` FOREIGN KEY (`customer_person_id`) REFERENCES `customer_person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cliente pessoa física';


DROP TABLE IF EXISTS `customer_telephone`;
CREATE TABLE `customer_telephone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `telephone_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `telephone_id` (`telephone_id`),
  CONSTRAINT `customer_telephone_ibfk_2` FOREIGN KEY (`telephone_id`) REFERENCES `telephone` (`id`),
  CONSTRAINT `customer_telephone_ibfk_5` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relação do cliente e telefones';


DROP TABLE IF EXISTS `customer_user`;
CREATE TABLE `customer_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `customer_user_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_user_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `tsac_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Relação do cliente com usuário ';


DROP TABLE IF EXISTS `email`;
CREATE TABLE `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de emails';


DROP TABLE IF EXISTS `suburb`;
CREATE TABLE `suburb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `suburb_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de bairros';


DROP TABLE IF EXISTS `telephone`;
CREATE TABLE `telephone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `number` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cadastro de telefones';


DROP VIEW IF EXISTS `vcustomer`;
CREATE TABLE `vcustomer` (`id` int(11), `code` varchar(255), `token` varchar(50), `blocked` tinyint(1), `blocked_reason` mediumtext, `status` tinyint(1), `observation` mediumtext, `created_at` timestamp, `updated_at` timestamp, `deleted_at` timestamp, `firstName` varchar(255), `lastName` varchar(255), `primaryDoc` varchar(50), `secundaryDoc` varchar(50), `emailType` varchar(10), `emailAddress` varchar(255), `telephoneType` varchar(10), `telephoneNumber` varchar(50), `addressType` varchar(200), `street` varchar(255), `addressNumberType` varchar(255), `number` varchar(255), `addressComplementType` varchar(255), `complement` varchar(255), `zoneCode` varchar(50), `suburb` varchar(255), `city` varchar(255), `zone` varchar(10), `country` varchar(255));


DROP TABLE IF EXISTS `zone`;
CREATE TABLE `zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `zone_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `vcustomer`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vcustomer` AS select `c`.`id` AS `id`,`c`.`code` AS `code`,`c`.`token` AS `token`,`c`.`blocked` AS `blocked`,`c`.`blocked_reason` AS `blocked_reason`,`c`.`status` AS `status`,`c`.`observation` AS `observation`,`c`.`created_at` AS `created_at`,`c`.`updated_at` AS `updated_at`,`c`.`deleted_at` AS `deleted_at`,if(`cpj`.`id`,`cpj`.`corporate_name`,`cpn`.`firstname`) AS `firstName`,if(`cpj`.`id`,`cpj`.`trading_name`,`cpn`.`lastname`) AS `lastName`,if(`cpj`.`id`,`cpj`.`registration_corporate_taxpayers`,`cpn`.`individual_taxpayer_registration`) AS `primaryDoc`,if(`cpj`.`id`,`cpj`.`state_registration`,`cpn`.`identity_document`) AS `secundaryDoc`,`e`.`type` AS `emailType`,`e`.`address` AS `emailAddress`,`t`.`type` AS `telephoneType`,`t`.`number` AS `telephoneNumber`,`a`.`type` AS `addressType`,`a`.`street` AS `street`,`an`.`type` AS `addressNumberType`,`an`.`number` AS `number`,`ac`.`type` AS `addressComplementType`,`ac`.`complement` AS `complement`,`a`.`zonecode` AS `zoneCode`,`s`.`name` AS `suburb`,`city`.`name` AS `city`,`zone`.`code` AS `zone`,`country`.`name` AS `country` from (((((((((((((((`customer` `c` join `customer_person` `cp` on((`cp`.`customer_id` = `c`.`id`))) left join `customer_person_juridical` `cpj` on((`cpj`.`customer_person_id` = `cp`.`id`))) left join `customer_person_natural` `cpn` on((`cpn`.`customer_person_id` = `cp`.`id`))) left join `customer_email` `ce` on((`ce`.`customer_id` = `c`.`id`))) left join `email` `e` on((`e`.`id` = `ce`.`email_id`))) left join `customer_telephone` `ct` on((`ct`.`customer_id` = `c`.`id`))) left join `telephone` `t` on((`t`.`id` = `ct`.`telephone_id`))) left join `customer_address` `ca` on((`ca`.`customer_id` = `c`.`id`))) left join `address` `a` on((`a`.`id` = `ca`.`address_id`))) left join `address_number` `an` on((`an`.`id` = `ca`.`address_number_id`))) left join `address_complement` `ac` on((`an`.`id` = `ca`.`address_complement_id`))) left join `suburb` `s` on((`s`.`id` = `a`.`suburb_id`))) left join `city` on((`city`.`id` = `a`.`city_id`))) left join `zone` on((`zone`.`id` = `a`.`zone_id`))) left join `country` on((`country`.`id` = `a`.`country_id`)));

-- 2016-05-03 21:53:43
