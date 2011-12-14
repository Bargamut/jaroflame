<?php include('inc/top.php');?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/default.css" />
<link rel="stylesheet" type="text/css" href="style/members.css" />
<title><?=TITLE_NAME?></title>
</head>

<?php
include_once('inc/modules/jsframework.php');
include_once('js/modules/members.js.php');
?>

<body>
<table border="0" cellpadding="0" cellspacing="0" align="center">
    <?php include('inc/header.php');?>
</table>
<table border="0" cellpadding="0" cellspacing="0" align="center">
    <?=$objPage->getPage('members',$_GET['q'])?>
</table>
<table border="0" cellpadding="0" cellspacing="0" align="center">
    <?php include('inc/footer.php');?>
</table>
</body>
</html>
<?php include('inc/bottom.php');?>