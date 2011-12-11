<?php
include('inc/top.php');

$date = date('Y-m-d H:i:s');
switch($_POST['table']){
	case'pages':break;
	case'news':
		$table = $_POST['table'];
		$field = '`page`,`caption`,`content`,`nick`,`date`';
		$values = "'".$_POST['pg']."','".$_POST['cpt']."','".$_POST['cnt']."','".$AUN."','".$date."'";
		$update = '`caption` = "'.$_POST['cpt'].'",'.
				  '`content` = "'.$_POST['cnt'].'",'.
				  '`date` = "'.$date.'"';
		$where = '`id` = "'.$_POST['id'].'"';
		break;
	case'cards':
		$table = $_POST['table'];
		$field = '`name`,`lname`,`nick`,`avatar`,`caption`,`content`';
		$values = "'".$_POST['nam']."','".$_POST['lnam']."','".$_POST['nick']."','".$_POST['ava']."','".$_POST['cpt']."','".$_POST['cnt']."'";
		$update = '`caption` = "'.$_POST['cpt'].'",'.
				  '`content` = "'.$_POST['cnt'].'"';
		$where = '`id` = "'.$_POST['id'].'"';
		break;
	case'members':
		$table = $_POST['table'];
		$field = '`name`,`lname`,`nick`,`avatar`,`rank`,`phone`,`fests`,`birthday`,`succdate`,`learnwork`,`people`';
		$values = "'".$_POST['nam']."','".$_POST['lnam']."','".$_POST['nick']."','".$_POST['ava']."','".$_POST['rnk']."','".$_POST['phn']."','".$_POST['fst']."','".$_POST['bdate']."','".$_POST['sdate']."','".$_POST['lrn']."','".$_POST['ppl']."'";
		$update = '`name` = "'.$_POST['nam'].'",'.
				  '`lname` = "'.$_POST['lnam'].'",'.
				  '`nick` = "'.$_POST['nick'].'",'.
				  '`avatar` = "'.$_POST['ava'].'",'.
				  '`rank` = "'.$_POST['rnk'].'",'.
				  '`phone` = "'.$_POST['phn'].'",'.
				  '`fests` = "'.$_POST['fst'].'",'.
				  '`birthday` = "'.$_POST['bdate'].'",'.
				  '`learnwork` = "'.$_POST['lrn'].'",'.
				  '`people` = "'.$_POST['ppl'].'"';
		$where = '`id` = "'.$_POST['id'].'"';
		break;
	case'':break;
	case'':break;
}

switch ($_POST['edit']){
	case 'insert':
		// Запрос создания новой строки
		db_insert($table,$field,$values);
		$data_query = db_select($table,'max(`id`) as `id`','no');
		while($arr_data = mysql_fetch_array($data_query,MYSQL_ASSOC)){
			foreach($arr_data as $key => $value){
				$data[$key] = $value;
			}
		}
		break;
	case 'update':
		// Запрос обновления строки
		db_update($table,$update,$where);
		$data['id'] = $_POST['id'];
		break;
	case 'delete':
		// Запрос удаления строки
		db_delete($table,$where);
		break;
}

echo "{resp:'Операция завершена!',del:'Запись удалена!',id:'".$data['id']."'}";

include('inc/bottom.php');
?>