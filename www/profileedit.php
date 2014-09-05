<?php
/**
 * User: Bargamut
 * Date: 22.07.12
 * Time: 18:58
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');
include_once(SITE_ROOT . '/common.php');
include_once(SITE_ROOT . '/header.php');
include_once(SITE_ROOT . '/footer.php');

if ($USER->check_rights('P:w', $userinfo['rights'])) {
    $profile = $USER->profile($userinfo['nickname']);
    $SMARTY->assign('lvlname', $profile['lvlname']);
    $SMARTY->assign('email', $profile['email']);
    $SMARTY->assign('lastname', $profile['lastname']);
    $SMARTY->assign('firstname', $profile['firstname']);
    $SMARTY->assign('fathername', $profile['fathername']);
    $SMARTY->assign('birthday', $profile['birthday']);
    $SMARTY->assign('p_seria', $profile['p_seria']);
    $SMARTY->assign('p_number', $profile['p_number']);
    $SMARTY->assign('p_date', $profile['p_date']);
    $SMARTY->assign('p_issuance', $profile['p_issuance']);
    $SMARTY->assign('studies', $profile['studies']);
    $SMARTY->assign('work', $profile['work']);
    $SMARTY->assign('medicine', $profile['medicine']);
    $SMARTY->assign('reg_address', $profile['reg_address']);
    $SMARTY->assign('borndate', $profile['borndate']);
    $SMARTY->assign('rank', $profile['rank']);
    $SMARTY->assign('wards', $profile['wards']);
    $SMARTY->assign('fests', $profile['fests']);
    $SMARTY->assign('awards', $profile['awards']);
} else {
    $error = array('header' => 'Ошибка', 'msg' => 'Нет доступа!');
    $SMARTY->assign('error', $error);
}

include_once(SITE_ROOT . '/bottom.php');