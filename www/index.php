<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');
include_once(SITE_ROOT . '/common.php');
include_once(SITE_ROOT . '/header.php');
include_once(SITE_ROOT . '/footer.php');

$SMARTY->assign('debug', DEBUG);

$SMARTY->display('pages/firstpage.tpl');

include_once(SITE_ROOT . '/bottom.php');