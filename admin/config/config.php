<?php
/*Конфигурационный файл*/
$server = array('local'=>'localhost','host'=>'78.108.84.245');
$login = array('local'=>'jf','host'=>'u106771');
$password = array('local'=>'test','host'=>'ayuzesVF39');
$database = array('local'=>'jf','host'=>'b106771_jf');

// Отладка
$_SESSION['debug_mode'] = 'off';
$AUN = $GLOBALS['PHP_AUTH_USER'];

// Настройки Email
$site['from_name'] = 'мое имя'; // from (от) имя
$site['from_email'] = 'email@mywebsite.com'; // from (от) email адрес
// На всякий случай указываем настройки
// для дополнительного (внешнего) SMTP сервера.
$site['smtp_mode'] = 'disabled'; // enabled or disabled (включен или выключен)
$site['smtp_host'] = null;
$site['smtp_port'] = null;
$site['smtp_username'] = null;

include('lang/ru.php'); // DEFINE-лист
require_once($_SERVER['DOCUMENT_ROOT'].'/phpmailer/class.phpmailer.php'); // Класс PHPMailer
include('classes/classes.php'); // Подключение списка классов
include('objects/objects.php'); // Создание объектов классов
include('functions/dbfunctions.php'); // Функции работы с БД
include('functions/functions.php'); // Функции сайта
include('functions/api.pages.php'); // API ввод-вывод страниц
?>