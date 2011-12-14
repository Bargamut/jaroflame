<?php include('inc/top.php');?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/default.css" />
<link rel="stylesheet" type="text/css" href="style/callback.css" />
<title><?=TITLE_NAME?></title>
</head>

<?php include_once('inc/modules/jsframework.php');?>

<body>
<table border="0" cellpadding="0" cellspacing="0" align="center">
    <?php include('inc/header.php');?>
</table>
<table border="0" cellpadding="0" cellspacing="0" align="center">
    <?=$objPage->getPage('callback')?>
    <tr><td>
        <div class="content">
            <form name="frm_callback" class="frm_callback" method="post" action="">
                <input id="u_fio" name="u_fio"
                       type="text"
                       size="50"
                       onfocus="if (this.value == 'ФИО') {$(this).val('');}"
                       onblur="if (this.value == '') {$(this).val('ФИО');}"
                       value="ФИО" /><br />
                <input id="u_email" name="u_email"
                       type="text"
                       size="21"
                       onfocus="if (this.value == 'E-mail') {$(this).val('');}"
                       onblur="if (this.value == '') {$(this).val('E-mail');}"
                       value="E-mail" />&nbsp;
                <input id="u_phone" name="u_phone"
                       type="text"
                       size="21"
                       onfocus="if (this.value == 'Телефон') {$(this).val('');}"
                       onblur="if (this.value == '') {$(this).val('Телефон');}"
                       value="Телефон" /><br />
                <input id="u_subj" name="u_subj"
                       type="text"
                       size="50"
                       onfocus="if (this.value == 'Тема') {$(this).val('');}"
                       onblur="if (this.value == '') {$(this).val('Тема');}"
                       value="Тема" /><br />
                <textarea id="u_message" name="u_message"
                          cols="39" rows="10"
                          onfocus="if (this.value == 'Текст сообщения') {$(this).html('');}"
                          onblur="if (this.value == '') {$(this).html('Текст сообщения');}">Текст сообщения</textarea><br />
                <button id="u_subm" name="u_subm"
                        type="button"
                        class="u_subm"
                        disabled="disabled">Отправить</button>
            </form>
        </div>
    </td></tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" align="center">
    <?php include('inc/footer.php');?>
</table>
</body>
</html>
<?php include('inc/bottom.php');?>