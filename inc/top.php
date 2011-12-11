<?php session_start();
include('config/config.php');
// Подключение к MySQL и запись ID соединения
$dbconnectID = $c_dbase->getConnect($server,$login,$password);
$c_dbase->getDB($database); // Выбор БД
mysql_query("set names 'utf8'");
?>