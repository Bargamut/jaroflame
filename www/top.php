<?php
/**
 * User: Bargamut
 * Date: 29.06.12
 * Time: 4:17
 */

define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']);
include_once(SITE_ROOT . '/eng/site.classes.php');

$DB->select_db('b134474_jf');

if ($USER->already_login()) {
    $userinfo = $_SESSION['USER'];
    $userinfo['logined'] = true;
} else {
    $userinfo = $USER->userinfo('guest@guest.ru');
    $userinfo['logined'] = false;
}