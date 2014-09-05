<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');
include_once(SITE_ROOT . '/common.php');
include_once(SITE_ROOT . '/header.php');
include_once(SITE_ROOT . '/footer.php');

$SMARTY->assign('error', $ERRORS[$_GET['t']]);

$SMARTY->display('pages/error.tpl');

include($_SERVER['DOCUMENT_ROOT'] . '/bottom.php');