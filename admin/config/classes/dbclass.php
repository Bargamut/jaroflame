<?php
// Класс работы с Базой Данных
class dbclass {
	var $server;
	var $login;
	var $password;
	var $db;
	// Возвращаемый идентификатор подключения
	var $link;
	// Подключение
	function getConnect($server,$login,$password){
		$link = @mysql_connect($server['host'],$login['host'],$password['host']) or $link = @mysql_connect($server['local'],$login['local'],$password['local']) or die(ERR_CONNECT_DB . mysql_error());
		//echo 'Успешно подключено: '.$link.'<br>';
		return $link;
	}
	// Выбор БД
	function getDB($db){
		mysql_select_db($db['host']) or mysql_select_db($db['local']) or die(ERR_SELECT_DB . mysql_error());
		//echo 'База Данных: '.$db.'<br>';
	}
	// Отключение
	function closeConnect($link){
		mysql_close($link) or die(ERR_CLOSE_CONNECT_DB . mysql_error());
		//echo 'Идентификатор подключения к базе данных: '.$link.'<br>';
	}
}
?>