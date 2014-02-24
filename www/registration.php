<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');
include_once(SITE_ROOT . '/eng/modules/common.php');
include_once(SITE_ROOT . '/eng/modules/header.php');
include_once(SITE_ROOT . '/eng/modules/footer.php');

if (!$userinfo['logined']) {
    $SMARTY->assign('reg_caption', REG_CAPTION);
    $SMARTY->assign('reg_email', REG_EMAIL);
    $SMARTY->assign('reg_lastname', REG_LASTNAME);
    $SMARTY->assign('reg_firstname', REG_FIRSTNAME);
    $SMARTY->assign('reg_fathername', REG_FATHERNAME);
    $SMARTY->assign('reg_password', REG_PASSWORD);
    $SMARTY->assign('reg_confirmpass', REG_CONFIRMPASS);
    $SMARTY->assign('reg_license', REG_LICENSE);
    $SMARTY->assign('reg_submit', REG_SUBMIT);
} else {
    $error = array('header' => REG_CAPTION, 'msg' => REG_ALREADY_REGISTERED);
    $SMARTY->assign('error', $error);
}

$SMARTY->display("pages/registration.tpl");
include_once(SITE_ROOT . '/bottom.php');