<?php
/**
 * User: Bargamut
 * Date: 03.07.12
 * Time: 3:31
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');
include_once(SITE_ROOT . '/common.php');
include_once(SITE_ROOT . '/header.php');
include_once(SITE_ROOT . '/footer.php');

$SMARTY->assign('check_rights', $USER->check_rights('P:r', $userinfo['rights']));
if ($USER->check_rights('P:r', $userinfo['rights'])) {

    $SMARTY->assign('user_profile', isset($_GET['u']));
    if (isset($_GET['u'])) {
        $profile = $USER->profile($_GET['u']);

        $SMARTY->assign('profile', ($profile != ''));
        if ($profile != '') {
            if ($profile['block']) {
                $block = array('header' => 'Блокирован!', 'msg' => $profile['block_reason']);
                $SMARTY->assign('block', $block);
            }

            $SMARTY->assign('lvlname',      $profile['lvlname']);
            $SMARTY->assign('lastname',     $profile['lastname']);
            $SMARTY->assign('firstname',    $profile['firstname']);
            $SMARTY->assign('patronymic',   $profile['patronymic']);
            $SMARTY->assign('borndate',     $profile['borndate']);
            $SMARTY->assign('rank',         $profile['rank']);
            $SMARTY->assign('wards',        $profile['wards']);
            $SMARTY->assign('fests',        $profile['fests']);
            $SMARTY->assign('awards',       $profile['awards']);

            if ($USER->isyoUID($userinfo['uid'], $profile['uid'])) {
                $SMARTY->assign('current_user', true);
                $SMARTY->assign('email',        $profile['email']);
                $SMARTY->assign('birthday',     $profile['birthday']);
                $SMARTY->assign('p_seria',      $profile['p_seria']);
                $SMARTY->assign('p_number',     $profile['p_number']);
                $SMARTY->assign('p_issuance',   $profile['p_issuance']);
                $SMARTY->assign('p_date',       $profile['p_date']);
                $SMARTY->assign('studies',      $profile['studies']);
                $SMARTY->assign('work',         $profile['work']);
                $SMARTY->assign('medicine',     $profile['medicine']);
                $SMARTY->assign('reg_address',  $profile['reg_address']);
            }
        } else {
            $error = array('header' => 'Ошибка', 'msg' => 'Нет такого пользователя!');
            $SMARTY->assign('error', $error);
        }
    } else {
        $SMARTY->assign('profiles', $USER->profiles());
    }
} else {
    $error = array('header' => 'Ошибка', 'msg' => 'Нет доступа!');
    $SMARTY->assign('error', $error);
}

$SMARTY->display('pages/profile.tpl');

include_once(SITE_ROOT . '/bottom.php');