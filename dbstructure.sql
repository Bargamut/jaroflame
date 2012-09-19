-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 19 2012 г., 05:02
-- Версия сервера: 5.5.27-log
-- Версия PHP: 5.4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `b134474_jf`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`u134474`@`` PROCEDURE `create_user`(
                IN m VARCHAR(255),
                IN p VARCHAR(255),
                IN s integer(3),
                IN d VARCHAR(255),
                IN v VARCHAR(255),
                IN u VARCHAR(255),
                IN n VARCHAR(255),
                IN ln VARCHAR(255),
                IN fn VARCHAR(255)
            )
    SQL SECURITY INVOKER
BEGIN
                INSERT INTO users_site (`email`, `password`, `salt`, `date_reg`, `date_lastvisit`, `uid`) VALUES (m, p, s, d, v, u);
                INSERT INTO users_bio (`firstname`, `lastname`, `fathername`) VALUES (n, ln, fn);
                INSERT INTO users_doc () VALUES ();
                INSERT INTO users_club () VALUES ();
            END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_bio`
--

CREATE TABLE IF NOT EXISTS `users_bio` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID элемента',
  `firstname` varchar(255) NOT NULL COMMENT 'Имя',
  `lastname` varchar(255) NOT NULL COMMENT 'Фамилия',
  `fathername` varchar(255) NOT NULL COMMENT 'Отчество',
  `birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT 'День рождения',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Био членов Клуба' AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_club`
--

CREATE TABLE IF NOT EXISTS `users_club` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID пользователя',
  `rank` varchar(100) NOT NULL DEFAULT 'Трелл' COMMENT 'Звание',
  `borndate` date NOT NULL COMMENT 'Дата прихода в Клуб',
  `wards` text NOT NULL COMMENT 'Подопечные',
  `fests` text NOT NULL COMMENT 'Фестивали',
  `awards` text NOT NULL COMMENT 'Награды',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Инфо по Клубу' AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_doc`
--

CREATE TABLE IF NOT EXISTS `users_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID пользователя',
  `p_seria` int(4) NOT NULL COMMENT 'Серия паспорта',
  `p_number` int(6) NOT NULL COMMENT 'Номер паспорта',
  `p_issuance` text NOT NULL COMMENT 'Кем выдан',
  `p_date` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Когда выдан',
  `studies` varchar(255) NOT NULL COMMENT 'Место учёбы',
  `work` varchar(255) NOT NULL COMMENT 'Место работы',
  `medicine` text NOT NULL COMMENT 'Медицинские ограничения',
  `reg_address` text NOT NULL COMMENT 'Адрес прописки',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Документы по членам Клуба' AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_lvl`
--

CREATE TABLE IF NOT EXISTS `users_lvl` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID уровня',
  `lvl` char(2) NOT NULL COMMENT 'Буквенное обозначение',
  `lvlname` char(30) NOT NULL COMMENT 'Буквенное обозначение',
  `rights` varchar(100) NOT NULL COMMENT 'Наименование уровня',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Уровни полномочий пользователей' AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_site`
--

CREATE TABLE IF NOT EXISTS `users_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID пользователя',
  `nickname` varchar(80) NOT NULL COMMENT 'Никнейм пользователя',
  `email` varchar(50) NOT NULL COMMENT 'E-mail - логин пользователя',
  `password` varchar(255) NOT NULL COMMENT 'Пароль',
  `salt` varchar(15) NOT NULL COMMENT '"Соль" для пароля',
  `date_reg` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Дата регистрации',
  `date_lastvisit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Дата последней авторизации пользователя',
  `uid` varchar(32) NOT NULL COMMENT 'UID пользователя',
  `level` char(20) NOT NULL DEFAULT 'U' COMMENT 'Уровень полномочий пользователя',
  `block` int(1) NOT NULL DEFAULT '0' COMMENT 'Флаг блокировки пользователя',
  `block_reason` varchar(255) NOT NULL COMMENT 'Причина блокировки',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица логин-пароль пользователей' AUTO_INCREMENT=12 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
