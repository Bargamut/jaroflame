<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 02.07.12
 * Time: 3:55
 */
include_once('top.php');

function registrationCorrect() {
    $result = '';

    if ($_POST['rEmail'] == "") $result = 'email|';                       // не пусто ли поле логина
    if ($_POST['rPass'] == "") $result = 'pass|';                        // не пусто ли поле пароля
    if ($_POST['rPass2'] == "") $result = 'pass2|';                       // не пусто ли поле подтверждения пароля
    if ($_POST['rLic'] != "ok") $result = 'lic|';                       // приняты ли правила
    if (!preg_match('/^([a-z0-9])(\w|[.]|-|_)+([a-z0-9])@([a-z0-9])([a-z0-9.-]*)([a-z0-9])([.]{1})([a-z]{2,4})$/is', $_POST['rEmail'])) $result = 'preg_email|'; // соответствует ли поле e-mail регулярному выражению
//    if (!preg_match('/^([а-яА-a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is'   , $_POST['rLName'])) return false;  // соответствует ли Фамилия регулярному выражению
//    if (!preg_match('/^([а-яА-a-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is'   , $_POST['rName'])) return false;   // соответствует ли Имя регулярному выражению
//    if (!preg_match('/^([а-яА-Яa-zA-Z0-9])(\w|-|_)+([a-z0-9])$/is'  , $_POST['rFName'])) return false;  // соответствует ли Отчество регулярному выражению
    if (strlen($_POST['rPass']) < 5 && empty($_POST['rPass'])) $result = 'pass < 5|';               // не меньше ли 5 символов длина пароля
    if (md5($_POST['rPass']) != md5($_POST['rPass2'])) $result = 'not_confirm_pass|';    // равен ли пароль его подтверждению
    $mail = htmlspecialchars($_POST['rMail']);
    $rez = mysql_query('SELECT * FROM users_site WHERE `email`="'.$mail.'" limit 1');
    if (@mysql_num_rows($rez) != 0) $result = 'already_exist|';                   // проверка на существование в БД такого же логина

    echo $result;
    return ($result == '');                                                    //если выполнение функции дошло до этого места, возвращаем true
}

if (!empty($_POST['rSubm']) && registrationCorrect()) {
    $password = $_POST['rPass'];
    $mail = htmlspecialchars($_POST['rEmail']);
    $salt = mt_rand(100, 999);
    $date_reg = date('Y-m-d H:i:s');
    $password = md5(md5($password).$salt);
    $token = md5(uniqid(rand(), 1));

    $db_query = 'INSERT INTO users_site (`email`, `password`, `salt`, `date_reg`, `date_lastvisit`, `uid`)'.
                'VALUES ("'.$mail.'", "'.$password.'", "'.$salt.'", "'.$date_reg.'", "'.$date_reg.'", "'.$token.'")';

    if (mysql_query($db_query)) {
        setcookie ("UID", $token, time() + 50000, '/');
        setcookie ("email", $mail, time() + 50000, '/');
        setcookie ("password", md5($mail.$password), time() + 50000, '/');

        $rez = mysql_query('SELECT * FROM users_site WHERE `login`="'.$mail.'" limit 1');
        @$row = mysql_fetch_assoc($rez);

        $_SESSION['UID'] = $row['uid'];
    }
} else {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}
?>