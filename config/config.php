<?php
/*Конфигурационный файл*/
$server = array('local'=>'localhost','host'=>'idb2.majordomo.ru');
$login = array('local'=>'jf','host'=>'u134474');
$password = array('local'=>'test','host'=>'CP4awWNd6G');
$database = array('local'=>'jf','host'=>'b134474_jf');

// Отладка
$_SESSION['debug_mode'] = 'off';

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