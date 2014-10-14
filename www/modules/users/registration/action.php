<?php
/**
 * User: Bargamut
 * Date: 02.07.12
 * Time: 3:55
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');

include_once(SITE_ROOT . '/common.php');
include_once(SITE_ROOT . '/header.php');
include_once(SITE_ROOT . '/footer.php');

$post = array(
    'faked_email'   => $_POST['email'],
    'nickname'      => $_POST['reg_nickname'],
    'email'         => $_POST['reg_email'],
    'pass'          => $_POST['reg_pass'],
    'accept'        => $_POST['reg_accept']
);

$result_tpl = 'pages/reports/activationsended.tpl';
$reg_status = false;

if (!$USER->registration($_POST['reg_subm'], $post)) {
    $SMARTY->assign('header', 'Регистрация прервана');
    $SMARTY->assign('desc', 'Во время регистрации произошла ошибка. Скорее всего, мы уже работаем над устранением этой неисправности.');
    $SMARTY->assign('link', array('href' => 'mailto:support@jaroflame.ru', 'title' => 'Сообщить об ошибке'));
} else {
    $reg_status = $USER->activationSend($_POST['reg_subm'], $post);

    if ($reg_status === 'blocked') {
        $SMARTY->assign('error', $ERRORS[404]);

        $result_tpl = 'pages/error.tpl';
    } else if ($reg_status) { // true
        $SMARTY->assign('header', 'Последний шаг');
        $SMARTY->assign('desc', 'Регистрация завершена и на указанный почтовый ящик отправлено письмо с ссылкой для активации активации аккаунта.');
        $SMARTY->assign('link', array('href' => '/', 'title' => 'Главная страница'));
    } else { // false
        $SMARTY->assign('header', 'Регистрация прервана');
        $SMARTY->assign('desc', 'При отправке письма с кодом активации на указанный адрес e-mail произошла ошибка. Пожалуйста, проверьте правильность введённого адреса.');
        $SMARTY->assign('link', array('href' => '/registration.php', 'title' => 'Регистрация'));
    }
}

$SMARTY->display($result_tpl);

include_once(SITE_ROOT . '/bottom.php');