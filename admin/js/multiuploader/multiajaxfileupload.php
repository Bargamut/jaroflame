<?php
include('../../functions/imgfunctions.php');
include('../../functions/api.watermark.php');

$tmpfname = tempnam($_SERVER['DOCUMENT_ROOT']."/uploads", "php");

$handle = fopen($tmpfname, "w");
fwrite($handle, $HTTP_RAW_POST_DATA);

fclose($handle);

$error = ""; // Ошибки
$msg = ""; // Сообщение
$f_size = ""; // Размер файла
$fileElementName = 'file';
$upl_dir = $_SERVER['DOCUMENT_ROOT'].$_GET['path'].DIRECTORY_SEPARATOR; // Папка для загрузки
$upl_dir_thumb = $_SERVER['DOCUMENT_ROOT'].$_GET['path'].DIRECTORY_SEPARATOR.'thumb/'; // Папка для загрузки уменьшенной копии
//print_r($HTTP_RAW_POST_DATA);
if (isset($_GET['qqfile'])){
    $upl_file = $_GET['qqfile'];
    $upl_file_tmp = $tmpfname;
	$fileSize = @filesize($upl_file_tmp);
} elseif (isset($_FILES[$fileElementName])){
	$upl_file = $_FILES[$fileElementName]['name']; // Имя файла
	$upl_file_tmp = $_FILES[$fileElementName]['tmp_name']; // Имя временного файла
	$fileSize = @filesize($upl_file_tmp);
} else {
	die ('{error: "server-error file not passed"}');
}

// Если есть ошибки
if(!empty($_FILES[$fileElementName]['error'])){
	switch($_FILES[$fileElementName]['error']){
		case '1':
			$error = 'Размер загружаемого файла больше upload_max_filesize = '.ini_get('upload_max_filesize').' в php.ini';break;
		case '2':$error = 'Размер загружаемого файла превысил MAX_FILE_SIZE, указанных в форме HTML';break;
		case '3':$error = 'Файл был загружен лишь частично';break;
		case '4':$error = 'Файл не был загружен';break;
		case '6':$error = 'Отсутствует временная папка';break;
		case '7':$error = 'Не удалось записать файл на диск';break;
		case '8':$error = 'Загрузка файла остановлена по расширению';break;
		case '999':
		default:$error = 'Нет кода ошибки';
	}
}elseif(empty($upl_file_tmp)||$upl_file_tmp=='none'){$error='Файл не был загружен..';
}else{
	$msg.="Имя файла: ".$upl_file.",".'\n'."Временное имя файла: ".$upl_file_tmp.",".'\n';
	$f_size.="Размер файла: ".$fileSize.'\n';
	
	// Если определено имя файла
	if($_GET['name']){
		$ext = explode('.',$upl_file);
		$name_arr = explode('.',$_GET['name']);
		switch($name_arr[count($name_arr)-1]){
			case 'png':$upl_file = $_GET['name'];break;
			case 'jpg':$upl_file = $_GET['name'];break;
			case 'jpeg':$upl_file = $_GET['name'];break;
			case 'gif':$upl_file = $_GET['name'];break;
			default:$upl_file = $_GET['name'].'.'.$ext[count($ext)-1];break;
		}
	}
	
	$thumb_pref = 'small_';
	// Если определён префикс файла в thumbs
	if($_GET['thumbname'] == 'none'){
		$thumb_pref = '';
	}
	
	// Перенос в папки
	if(rename($upl_file_tmp,$upl_dir.basename($upl_file))){$msg.="Файл верный и успешно загружен.".'\n';
		chmod($upl_dir.basename($upl_file), 0644);
		// Watermark
		if($_GET['watermark']){
			$watermark = new watermark();
			$main_img_src = $upl_dir.basename($upl_file);
			$watermark_img_src = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'images/default/watermark.png';
			$return_img_obj = $watermark->create_watermark( $main_img_src, $watermark_img_src, 100 );
		}
		
		// Ресайз
		if($_GET['resize']){ // если есть размеры ресайза WIDTHxHEIGHT
			$size = explode('x',$_GET['resize']);
			if(img_resize($upl_dir.basename($upl_file),$upl_dir_thumb.$thumb_pref.$name.basename($upl_file),$size[0],$size[1])){
				$msg.="Ресайз OK!".'\n';
			}else{
				$msg.="Ресайз провалился!".'\n';
			}
		}
		// Ресайз главного изображения
		if($_GET['main_resize']){ // если есть размеры ресайза WIDTHxHEIGHT
			$size = explode('x',$_GET['main_resize']);
			if(img_resize($upl_dir.basename($upl_file),$upl_dir.basename($upl_file),$size[0],$size[1])){
				$msg.="Ресайз главного изображения OK!".'\n';
			}else{
				$msg.="Ресайз главного изображения провалился!".'\n';
			}
		}
		$success = 'true';
	}else{
		$msg.="Thumb: Возможная атака!".'\n'.$upl_file_tmp.'\n'.$upl_dir.basename($upl_file).'\n';
		$success = 'false';
	}

	// Из соображений безопасности, мы удаляем все загруженные файлы
	@unlink($_FILES[$fileElementName]);
	@unlink($tmpfname);
}

// Отладочная инфа
echo "{";
echo "error: '".$error."',";
echo "msg: '".$msg."',";
echo "name: '".$upl_file."',";
echo "name_tmp: '".$upl_file_tmp."',";
echo "fsize: '".$f_size."',";
echo "faddr: '".$_GET['path'].DIRECTORY_SEPARATOR.basename($upl_file)."',";
echo "faddr_small: '".$_GET['path'].DIRECTORY_SEPARATOR."thumb/small_".basename($upl_file)."',";
echo "success: '".$success."'";
//echo "GET_data: '".$_GET['path']." - ".$_GET['size'].": size[0]=".$size[0].",size[1]=".$size[1]." - ".$_GET['bg']."',\n";
echo "}";
?>