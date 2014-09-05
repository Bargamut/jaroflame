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
$postfix    = (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) ? '_localhost' : '';
$db_section = 'database_site' . $postfix;

include_once(SITE_ROOT . '/eng/api/api.config.php');         // Общий конфиг

include_once(SITE_ROOT . '/eng/lang/ru/default.php');        // Общий языковой файл RU
include_once(SITE_ROOT . '/eng/lang/ru/registration.php');   // Языковой файл для регистрации RU
include_once(SITE_ROOT . '/eng/lang/ru/auth.php');           // Языковой файл для авторизации RU

include_once(SITE_ROOT . '/eng/api/api.site.php');           // API Общий
include_once(SITE_ROOT . '/eng/api/database/api.mysql.php'); // API Базы Данных
include_once(SITE_ROOT . '/eng/api/api.users.php');          // API Пользователей
include_once(SITE_ROOT . '/eng/api/api.debug.php');          // API Отладки
include_once(SITE_ROOT . '/eng/api/api.smarty.php');         // API Шаблонизатора

$CONF   = JF_Config::getInstance();         // Создаём объект Конфига
$SITE   = new JF_Site();
$DEBUG  = new JF_Debug();
$DB     = new JF_Database($CONF->get('dbhost', $db_section),
                          $CONF->get('dbuser', $db_section),
                          $CONF->get('dbpass', $db_section));
$USER   = new JF_Users();
$SMARTY = new JF_Smarty();