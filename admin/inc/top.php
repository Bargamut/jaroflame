<?php session_start();
include('config/config.php');

$objPage = new Pages(); // Объект API работы со страницами
$objFile = new Files(); // Объект API работы с файлами
$objImage = new Images(); // Объект API работы с изображениями
$objWatermark = new Watermark(); // Объект API работы с водяным знаком

// Подключение к MySQL и запись ID соединения
$dbconnectID = $c_dbase->getConnect($server,$login,$password);
$c_dbase->getDB($database); // Выбор БД
mysql_query("set names 'utf8'");
?>