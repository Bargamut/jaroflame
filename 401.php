<?php include('inc/top.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/default.css" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<title><?=TITLE_NAME?></title>
</head>

<?php include_once('inc/modules/jsframework.php');?>

<body>
<table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td>
    <?php
	$script = basename($_SERVER['PHP_SELF']);
	switch($script){
		case '401.php':?>
			<div class="content">
            	<img src="/img/default/logo3.png" align="top" /><br />
                Требуется авторизация.
            </div>
			<?php
            break;
		case '403.php':?>
			<div class="content">
            	<img src="/img/default/logo3.png" align="top" /><br />
				Доступ запрещен, авторизация не была выполнена.
            </div>
			<?php
            break;
		case '404.php':?>
			<div class="content">
            	<img src="/img/default/logo3.png" align="top" /><br />
				Документ не найден.
            </div>
			<?php
			break;
		case '500.php':?>
			<div class="content">
            	<img src="/img/default/logo3.png" align="top" /><br />
				Внутренняя ошибка сервера.
            </div>
			<?php
			break;
		default:break;
	}
	?>
</td></tr></table>
</body>
</html>
<?php include('inc/bottom.php');?>