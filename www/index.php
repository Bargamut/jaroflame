<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');
include_once(SITE_ROOT . '/eng/modules/common.php');
include_once(SITE_ROOT . '/eng/modules/header.php');
include_once(SITE_ROOT . '/eng/modules/footer.php');

$SMARTY->assign('debug', DEBUG);

$SMARTY->display('pages/firstpage.tpl');

include_once(SITE_ROOT . '/bottom.php');