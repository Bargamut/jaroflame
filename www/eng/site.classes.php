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
// Проверяем, где находимся
$postfix = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) ? '_localhost' : '';
$db_section = 'database_site' . $postfix;

include_once('/eng/api/api.config.php');         // Общий конфиг

include_once('/eng/lang/ru/default.php');        // Общий языковой файл RU
include_once('/eng/lang/ru/registration.php');   // Языковой файл для регистрации RU
include_once('/eng/lang/ru/auth.php');           // Языковой файл для авторизации RU

include_once('/eng/api/api.site.php');           // API Общий
include_once('/eng/api/api.database.php');       // API Базы Данных
include_once('/eng/api/api.users.php');          // API Пользователей
include_once('/eng/api/api.debug.php');          // API Пользователей
include_once('/eng/api/api.smarty.php');         // API Шаблонизатора

$CONF   = JF_Config::getInstance();         // Создаём объект Конфига
$DEBUG  = new JF_Debug();
$DB     = new JF_Database($CONF->get('dbhost', $db_section),
                          $CONF->get('dbuser', $db_section),
                          $CONF->get('dbpass', $db_section));
$SITE   = new JF_Site();
$USER   = new JF_Users();
$SMARTY = new JF_Smarty();