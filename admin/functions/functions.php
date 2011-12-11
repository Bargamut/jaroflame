<?php
// Просмотр папки
function dir_show($dir){
	$files = array();
	$kd = 0;
	$kf = 0;
	$dir = $_SERVER['DOCUMENT_ROOT'].$dir;
	$odir = opendir($dir);
	while (($file = readdir($odir)) !== FALSE){
		if ($file == '_notes'){
			unlink($dir.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR.'dwsync.xml');
			rmdir($dir.DIRECTORY_SEPARATOR.$file);
		}elseif($file == 'Thumbs.db'){unlink($dir.DIRECTORY_SEPARATOR.$file);}
		if ($file =='.'||$file =='..'||$file == '.htaccess'||$file == '.htpasswd'||$file == 'default'){
			continue;
		}else{
			if (is_dir($dir.DIRECTORY_SEPARATOR.$file)){
				$files['dirs'][$kd] = $file;
				$kd++;
			}else{
				$files['files'][$kf] = $file;
				$kf++;
			}
		}
	}
	closedir($odir);
	return $files;
}

// Создание папки
function dir_create($dir){
	$dir = $_SERVER['DOCUMENT_ROOT'].$dir;
	if (!is_dir($dir)){
		mkdir($dir);
	}
	return false;
}

// Удаление папки
function dir_remove($dir){
	$dir = $_SERVER['DOCUMENT_ROOT'].$dir;
	$odir = opendir($dir);
	while (($file = readdir($odir)) !== FALSE){
		if ($file =='.'||$file =='..'){
			continue;
		}else{
			if (is_dir($dir.DIRECTORY_SEPARATOR.$file)){
				dir_remove($dir.DIRECTORY_SEPARATOR.$file);
			}else{
				unlink($dir.DIRECTORY_SEPARATOR.$file);
			}
		}
	}
	closedir($odir);
	rmdir($dir);
	return false;
}

// Переименование файла
function rename_file($old,$new){
	$home = $_SERVER['DOCUMENT_ROOT'];
	rename($home.DIRECTORY_SEPARATOR.$old,$home.DIRECTORY_SEPARATOR.$new);
	return true;	
}

// Удаление файла
function file_remove($dir){
	$file = $_SERVER['DOCUMENT_ROOT'].$dir;
	if (!is_dir($dir.DIRECTORY_SEPARATOR.$file)){
		unlink($file);
	}
	return false;
}

function last_update($current_date){
	$c_date = explode(' ',$current_date);
	$c_date2 = explode('-',$c_date[0]);
	$current_date = $c_date2[2].'-'.$c_date2[1].'-'.$c_date2[0].' '.$c_date[1];
	
	$month[1]  = "январ";
	$month[2]  = "феврал";
	$month[3]  = "март";
	$month[4]  = "апрел";
	$month[5]  = "ма";
	$month[6]  = "июн";
	$month[7]  = "июл";
	$month[8]  = "август";
	$month[9]  = "сентябр";
	$month[10] = "октябр";
	$month[11] = "ноябр";
	$month[12] = "декабр";
	
	if ((int)$c_date2[1] == 3||(int)$c_date2[1] == 8){
		$k="а";
	}else{
		$k="я";
	}
	
	$monthm = $month[(int)$c_date2[1]];
	
	if($current_date != '-- '){
		$result = seek_date($current_date,date('d-m-Y H:i:s'));
	}
	switch ($result){
		case 0:$result = 'сегодня';break;
		case 1:$result = 'вчера';break;
		default:$result = $c_date2[2].' '.$monthm.$k;break;
	}
	return $result;
}

function seek_date($date1,$date2){
//	$date1 = "01-02-2010 12:00";
//	$date2 = "31-12-2009 11:59";
	$arr1 = explode(" ", $date1);
	$arr2 = explode(" ", $date2);  
	$arrdate1 = explode("-", $arr1[0]);
	$arrdate2 = explode("-", $arr2[0]);
	$arrtime1 = explode(":", $arr1[1]);
	$arrtime2 = explode(":", $arr2[1]);
	$timestamp2 = (mktime($arrtime2[0], $arrtime2[1], 0, $arrdate2[1],  $arrdate2[0],  $arrdate2[2]));
	$timestamp1 = (mktime($arrtime1[0], $arrtime1[1], 0, $arrdate1[1],  $arrdate1[0],  $arrdate1[2]));
	$difference = floor(($timestamp2 - $timestamp1)/86400);
//	echo 'Разница между датами: '.$difference.' дня(-ей)';
	return $difference;
}
?>