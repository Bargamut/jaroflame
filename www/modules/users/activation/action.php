<?php
/**
 * User: Bargamut
 * Date: 12.09.14
 * Time: 4:47
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');

include_once(SITE_ROOT . '/common.php');
include_once(SITE_ROOT . '/header.php');
include_once(SITE_ROOT . '/footer.php');

$result_tpl = 'pages/reports/activation.tpl';

if ($USER->activation($_GET['hash'])) {
    $SMARTY->assign('header', 'Ваш аккаунт активирован!');
    $SMARTY->assign('desc', 'В течение 3 секунд вы будете перернаправлены на главную страницу.');
    $SMARTY->assign('link', array('href' => '/', 'title' => 'Главная страница'));
} else {
    $SMARTY->assign('error', $ERRORS[404]);

    $result_tpl = 'pages/error.tpl';
}

$SMARTY->display($result_tpl);

include_once(SITE_ROOT . '/bottom.php');