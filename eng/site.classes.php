<?php
/**
 * User: Bargamut
 * Date: 29.06.12
 * Time: 4:07
 */
session_start();

// TODO: продолжить формирование конфига сайта
// TODO: формирование конфига админ-панели
// TODO: проектирование Регистрации / Входа / Выхода, Профиля пользователя

include_once('api/api.config.php');         // Общий конфиг

include_once('lang/ru/default.php');        // Общий языковой файл RU
include_once('lang/ru/registration.php');   // Языковой файл для регистрации RU
include_once('lang/ru/auth.php');           // Языковой файл для авторизации RU

include_once('api/api.site.php');           // API Общий
include_once('api/api.database.php');       // API Базы Данных
include_once('api/api.users.php');          // API Пользователей
include_once('api/api.debug.php');          // API Пользователей

// Проверяем, где находимся
$section = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) ? 'database_site_localhost' : 'database_site';

$CONF   = JF_Config::getInstance();           // Создаём объект Конфига
$DEBUG  = new JF_Debug();
$DB     = new JF_Database($CONF->get('dbhost', $section),
                          $CONF->get('dbuser', $section),
                          $CONF->get('dbpass', $section));
$SITE   = new Site();
$USER   = new Users();