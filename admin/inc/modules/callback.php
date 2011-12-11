<?php
// Читаем настройки config
@require_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
@require_once($_SERVER['DOCUMENT_ROOT'].'/config/classes/classes.php'); // Подключение списка классов
@require_once($_SERVER['DOCUMENT_ROOT'].'/config/objects/objects.php'); // Создание объектов классов
@require_once($_SERVER['DOCUMENT_ROOT'].'/functions/dbfunctions.php'); // Функции работы с БД

// Подключение к MySQL и запись ID соединения
$dbconnectID = $c_dbase->getConnect($server,$login,$password);
$c_dbase->getDB($database); // Выбор БД
mysql_query("set names 'utf8'");

// Подключаем класс FreakMailer
require_once($_SERVER['DOCUMENT_ROOT'].'/config/classes/mailclass.php');

// Запрос адреса отсылки писем
$email_query = db_select($_POST['table'],'`id`,`address`,`Caption`');
while($arr_email = mysql_fetch_array($email_query,MYSQL_ASSOC)){
	foreach($arr_email as $key => $value){
		$emails[$arr_email['id']] = array('email' => $arr_email['address'],
					   					  'name' => $arr_email['Caption']);
	}
}
foreach($emails as $ekey => $evalue){
	$email = $evalue['email'];
	$name = $evalue['name'];
}

// инициализируем класс
$mailer = new FreakMailer();

//$mailer->IsHTML(true);
$mailer->CharSet="utf-8";
//$mailer->AddCustomHeader('Content-Type: text/html; charset="utf-8"');

// Имя и Адрес отправителя
$mailer->FromName = $_POST['name'];
$mailer->From = $_POST['email'];

// Устанавливаем тему письма
$mailer->Subject = 'Обратная связь: '.$_POST['subject'];

// Задаем тело письма
$mailer->Body = $_POST['message'].'
Телефон: '.$_POST['phone'];

// получаем список адресов пользователей
$sql = db_select('callback','`address`,`Caption`');

$result = array('success' => 0, 'error' => 0);
$send_result = 0;
while($row = mysql_fetch_object($sql)){
	$mailer->AddAddress(htmlspecialchars_decode($row->address), htmlspecialchars_decode($row->Caption));
	
	if(isset($_POST['attach']) && $_POST['attach'] != ''){
		$file_name = explode('/',$_POST['attach']);
	
		// настройка класса для отправки почты
		$mailer->AddAttachment($_SERVER['DOCUMENT_ROOT'].$_POST['attach'], $file_name[count($file_name)-1]);
	}
	
	if(!$mailer->Send()){
		$result['error']++;
	}else{
		$result['success']++;
		//echo htmlspecialchars_decode($row->Caption).' - Письмо отослано!';
	}
	$mailer->ClearAddresses();
	$mailer->ClearAttachments();
}

echo json_encode($result);

// Из соображений безопасности, мы удаляем все загруженные файлы
@unlink($_SERVER['DOCUMENT_ROOT'].$_POST['attach']);

$c_dbase->closeConnect($dbconnectID); // Закрытие соединения с Базой Данных
?>