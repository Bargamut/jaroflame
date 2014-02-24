<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');
include_once(SITE_ROOT . '/eng/modules/common.php');
include_once(SITE_ROOT . '/eng/modules/header.php');
include_once(SITE_ROOT . '/eng/modules/footer.php');

if (!$userinfo['logined']) {
    $SMARTY->assign('auth_caption', AUTH_CAPTION);
    $SMARTY->assign('auth_email', AUTH_EMAIL);
    $SMARTY->assign('auth_password', AUTH_PASSWORD);
    $SMARTY->assign('auth_submit', AUTH_SUBMIT);
    $SMARTY->assign('auth_registration', AUTH_REGISTRATION);
} else {
    $error = array('header' => AUTH_CAPTION, 'msg' => AUTH_ALREADY_AUTHORIZED);
    $SMARTY->assign('error', $error);
}

$SMARTY->display('pages/auth.tpl');

include_once(SITE_ROOT . '/bottom.php');