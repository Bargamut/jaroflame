<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 02.07.12
 * Time: 3:55
 */
include_once('top.php');

function authCorrect() {
    $result = '';

    if ($_POST['aEmail'] == "") $result = 'email|';                       // не пусто ли поле логина
    if ($_POST['aPass'] == "") $result = 'pass|';                        // не пусто ли поле пароля
    if (strlen($_POST['aPass']) < 5 && empty($_POST['aPass'])) $result = 'pass < 5|';               // не меньше ли 5 символов длина пароля
    $mail = $_POST['aEmail'];
    $rez = mysql_query('SELECT `password`, `salt` FROM users_site WHERE `email`="'.$mail.'" limit 1');
    if (@mysql_num_rows($rez) == 0) $result = 'already_exist|';                   // проверка на существование в БД такого же логина
    while ($res = mysql_fetch_array($rez, MYSQL_ASSOC)) {
        if (md5(md5($_POST['aPass']).$res['salt']) != $res['password']) $result = 'not_confirm_pass|';    // равен ли пароль его подтверждению
    }
    return ($result == '');                                                    //если выполнение функции дошло до этого места, возвращаем true
}

if (!empty($_POST['aSubm']) && authCorrect()) {
    $mail = htmlspecialchars($_POST['aEmail']);
    $rez = mysql_query('SELECT `email`, `password`, `uid` FROM users_site WHERE `email`="'.$mail.'" limit 1');
    @$row = mysql_fetch_assoc($rez);
    setcookie ("email", $row['email'], time() + 50000, '/');
    setcookie ("password", md5($row['email'].$row['password']), time() + 50000, '/');

    $_SESSION['UID'] = $row['uid'];
    header('Location: http://'.$_SERVER['SERVER_NAME']);
} else {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}
?>