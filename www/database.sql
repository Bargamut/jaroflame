-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.35-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              8.1.0.4545
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных b134474_jf
DROP DATABASE IF EXISTS `b134474_jf`;
CREATE DATABASE IF NOT EXISTS `b134474_jf` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `b134474_jf`;


-- Дамп структуры для таблица b134474_jf.users_accounting
DROP TABLE IF EXISTS `users_accounting`;
CREATE TABLE IF NOT EXISTS `users_accounting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'id пользователя',
  `tuberculous` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `narcological` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `psychiatrical` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `police` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Учёт в диспансерах и милиции';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_awards
DROP TABLE IF EXISTS `users_awards`;
CREATE TABLE IF NOT EXISTS `users_awards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'id пользователя',
  `awards` char(50) NOT NULL COMMENT 'Награды',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_bio
DROP TABLE IF EXISTS `users_bio`;
CREATE TABLE IF NOT EXISTS `users_bio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `firstname` char(20) NOT NULL COMMENT 'Имя',
  `lastname` char(20) NOT NULL COMMENT 'Фамилия',
  `patronymic` char(20) NOT NULL COMMENT 'Отчество',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Дата рождения',
  `photo` char(20) NOT NULL COMMENT 'Фото',
  `sport` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Занятия спортом',
  `clubs` char(50) NOT NULL DEFAULT '' COMMENT 'Названия клубов',
  `hobby` char(50) NOT NULL DEFAULT '' COMMENT 'Хобби',
  `staff` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Участие в Клубе',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Пользователи';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_club
DROP TABLE IF EXISTS `users_club`;
CREATE TABLE IF NOT EXISTS `users_club` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'id пользователя',
  `borndate` date NOT NULL COMMENT 'Дата прихода в Клуб',
  `rank` varchar(100) NOT NULL DEFAULT 'Трелл' COMMENT 'Звание',
  `expectation` char(50) NOT NULL DEFAULT '' COMMENT 'Ожидания',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Клубные данные';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_contacts
DROP TABLE IF EXISTS `users_contacts`;
CREATE TABLE IF NOT EXISTS `users_contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL COMMENT 'id пользователя',
  `type` int(10) unsigned NOT NULL COMMENT 'Тип контакта',
  `value` char(255) NOT NULL COMMENT 'Содержание',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Контакты порльзователей';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_docs
DROP TABLE IF EXISTS `users_docs`;
CREATE TABLE IF NOT EXISTS `users_docs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'id пользователя',
  `passport_serial` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Серия',
  `passport_number` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'Номер',
  `passport_issuance` text NOT NULL COMMENT 'Кем выдан',
  `passport_date` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Дата выдачи',
  `passport_code` char(50) NOT NULL COMMENT 'Код подразделения',
  `reg_address` varchar(150) NOT NULL COMMENT 'Адрес прописки',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Документы пользователей';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_education
DROP TABLE IF EXISTS `users_education`;
CREATE TABLE IF NOT EXISTS `users_education` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'id пользователя',
  `institution` char(50) NOT NULL COMMENT 'Школа/ВУЗ',
  `grade` char(20) NOT NULL COMMENT 'Класс/курс',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Род занятий пользователей';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_fests
DROP TABLE IF EXISTS `users_fests`;
CREATE TABLE IF NOT EXISTS `users_fests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `fests` char(50) NOT NULL COMMENT 'Фестивали',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Посещённые фестивали';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_medicine
DROP TABLE IF EXISTS `users_medicine`;
CREATE TABLE IF NOT EXISTS `users_medicine` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'id пользователя',
  `bloodtype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Группа крови',
  `rhesus` char(1) NOT NULL DEFAULT '' COMMENT 'Резус-фактор',
  `insurance_code` bigint(15) unsigned NOT NULL DEFAULT '0' COMMENT 'Номер мед.страховки',
  `fluorography` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Флюорография текущего года',
  `description` char(255) NOT NULL DEFAULT '' COMMENT 'Общая информация',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Медицинские записи пользователей';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_medicine_contraindications
DROP TABLE IF EXISTS `users_medicine_contraindications`;
CREATE TABLE IF NOT EXISTS `users_medicine_contraindications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'id пользователя',
  `contraindications` char(255) NOT NULL DEFAULT '' COMMENT 'Противопоказания',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='Медицинские противопоказания';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_medicine_diseases
DROP TABLE IF EXISTS `users_medicine_diseases`;
CREATE TABLE IF NOT EXISTS `users_medicine_diseases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'id пользователя',
  `diseases` char(255) NOT NULL DEFAULT '' COMMENT 'Заболевания',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='Медицинские заболевания';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_ways
DROP TABLE IF EXISTS `users_ways`;
CREATE TABLE IF NOT EXISTS `users_ways` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'id пользователя',
  `way` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Направление развития',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Направление развития пользователей';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица b134474_jf.users_work
DROP TABLE IF EXISTS `users_work`;
CREATE TABLE IF NOT EXISTS `users_work` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id записи',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'id пользователя',
  `company` char(50) NOT NULL COMMENT 'Компания',
  `post` char(50) NOT NULL COMMENT 'Должность',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='Род занятий пользователей';

-- Экспортируемые данные не выделены.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
