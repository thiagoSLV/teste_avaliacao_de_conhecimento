# HeidiSQL Dump 
#
# --------------------------------------------------------
# Host:                         127.0.0.1
# Database:                     teste_bludata_db
# Server version:               10.1.32-MariaDB
# Server OS:                    Win32
# Target compatibility:         HeidiSQL w/ MySQL Server 5.1
# Target max_allowed_packet:    1048576
# HeidiSQL version:             4.0
# Date/time:                    2018-10-15 04:02:56
# --------------------------------------------------------

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;*/


#
# Database structure for database 'teste_bludata_db'
#

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `teste_bludata_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `teste_bludata_db`;


#
# Table structure for table 'companies'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(30) NOT NULL,
  `company_state` varchar(30) NOT NULL,
  `company_cnpj` varchar(18) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;


#
# Table structure for table 'providers'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_name` varchar(30) NOT NULL,
  `provider_company` int(11) DEFAULT NULL,
  `provider_cpf` varchar(14) DEFAULT NULL,
  `provider_cnpj` varchar(18) DEFAULT NULL,
  `provider_register_date` datetime DEFAULT NULL,
  `provider_phone` varchar(4000) DEFAULT NULL,
  `provider_rg` varchar(7) DEFAULT NULL,
  `provider_birth_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_company` (`provider_company`),
  CONSTRAINT `providers_ibfk_1` FOREIGN KEY (`provider_company`) REFERENCES `companies` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=latin1;

