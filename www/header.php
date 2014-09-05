<?php
/**
 * User: Bargamut
 * Date: 23.02.14
 * Time: 22:26
 */
$SMARTY->assign('logo', SITE_LOGO);

if ($userinfo['logined']) {
    $SMARTY->assign('nickname', $userinfo['nickname']);
    $SMARTY->assign('auth_profile', AUTH_PROFILE);
    $SMARTY->assign('auth_exit', AUTH_EXIT);
} else {
    $SMARTY->assign('auth_email', AUTH_EMAIL);
    $SMARTY->assign('auth_password', AUTH_PASSWORD);
    $SMARTY->assign('auth_submit', AUTH_SUBMIT);
    $SMARTY->assign('auth_registration', AUTH_REGISTRATION);
}