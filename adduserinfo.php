<?php include('inc/top.php');?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/default.css" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<title><?=TITLE_NAME?></title>
</head>
<body style="padding: 15px 10px 15px 30px !important;">
    <h1>Форму заполнять только <b>ОДИН</b> раз.</h1>
    <br />
    <br />
    <form name="uiForm" action="adduserinfoact.php" method="post" enctype="multipart/form-data">
        Имя: <input name="firstname" type="text" value=""><br />
        Фамилия: <input name="lastname" type="text" value=""><br />
        Отчество: <input name="fathername" type="text" value=""><br />
        Дата рождения: <input name="birthday" type="text" value=""> Формата ГГГГ-ММ-ДД<br />
        <hr />
        <b>Паспорт</b><br />
        серия: <input name="p_serial" type="text" value="">4008<br />
        номер: <input name="p_number" type="text" value="">1234567<br />
        место выдачи: <input name="p_issuance" type="text" value=""><br />
        дата выдачи: <input name="p_date" type="text" value=""> Формата ГГГГ-ММ-ДД<br />
        Адрес прописки: <input name="reg_address" type="text" value=""><br />
        Место учёбы: <input name="studies" type="text" value=""> Номер школы / <u>Аббревиатура</u> ВУЗ'а<br />
        Место работы: <input name="work" type="text" value=""><br />
        Мед. ограничения: <input name="medicine" type="text" value=""><br />
        <hr />
        Дата прихода в Клуб: <input name="borndate" type="text" value=""> Формата ГГГГ-ММ-ДД<br />
        Звание: <input name="rank" type="text" value=""><br />
        Фестивали: <input name="fests" type="text" value=""><br />
        Подопечные: <input name="wards" type="text" value=""><br />
        Награды: <input name="awards" type="text" value="">  <br />
        <input type="submit" value="Отправить">
    </form>
</body>
</html>
<?php include('inc/bottom.php');?>