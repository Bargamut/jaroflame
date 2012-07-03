<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 03.07.12
 * Time: 3:31
 */
include_once('top.php');

//проверим, быть может пользователь уже авторизирован. Если это так, перенаправим его на главную страницу сайта
if (isset($_SESSION['UID']) || (isset($_COOKIE['email']) && isset($_COOKIE['password']))) {
    echo 'Авторизация прошла успешно!';
} else {
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/auth.php');
}
?>