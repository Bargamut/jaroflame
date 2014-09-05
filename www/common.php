<?php
/**
 * User: Bargamut
 * Date: 24.02.14
 * Time: 0:40
 */

$SMARTY->assign('app_name', 'Сайт КИР "Яро Пламя"');
$SMARTY->assign('title', SITE_TITLE);
$SMARTY->assign('favicon', $CONF->get('icon', 'project'));
$SMARTY->assign('logined', $userinfo['logined']);