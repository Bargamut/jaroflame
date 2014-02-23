<?php
include('top.php');

$SMARTY->assign('title', SITE_TITLE);
$SMARTY->assign('logo', SITE_LOGO);
$SMARTY->assign('favicon', $CONF->get('icon', 'project'));

$SMARTY->assign('user_panel', $userinfo['logined'] ? $USER->userTab($userinfo['nickname']) : $USER->mAuthForm());

$SMARTY->assign('debug', DEBUG);
$SMARTY->assign('credits', CREDITS);
$SMARTY->assign('developers', DEVELOPERS);

$SMARTY->display('firstpage.tpl');

include('bottom.php');