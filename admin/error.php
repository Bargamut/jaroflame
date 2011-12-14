<?php include('inc/top.php');?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/default.css" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<title><?=TITLE_NAME?></title>
</head>

<?php include_once('inc/modules/jsframework.php');?>

<body style="text-align: center;">
    <img src="/img/default/logo3.png" align="top" /><br />
    <?=$errors[$_GET['t']]?>
</body>
</html>
<?php include('inc/bottom.php');?>