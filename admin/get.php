<?php
include('inc/top.php');

$table = '';
$field = '';
$where = '';

switch($_POST['table']){
	case'pages':break;
	case'news':
		$table = $_POST['table'];
		$field = '`page`,`caption`,`content`,`nick`,`date`';
		$where = '`id` = "'.$_POST['id'].'"';
		break;
	case'cards':
		$table = $_POST['table'];
		$field = '`name`,`lname`,`nick`,`avatar`,`caption`,`content`';
		$where = '`id` = "'.$_POST['id'].'"';
		break;
	case'members':
		$table = $_POST['table'];
		$field = '`name`,`lname`,`nick`,`avatar`,`rank`,`phone`,`fests`,`birthday`,`succdate`,`learnwork`,`people`';
		$where = '`id` = "'.$_POST['id'].'"';
		break;
	case'':break;
	case'':break;
	case'':break;
}

$data_query = db_select($table,$field,$where); // Запрос содержимого

while($arr_data = mysql_fetch_array($data_query,MYSQL_ASSOC)){
	foreach($arr_data as $key => $value){
		$data_val[$key] = $value;
	}
}

echo json_encode($data_val);

include('inc/bottom.php');
?>