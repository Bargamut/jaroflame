<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 29.06.12
 * Time: 4:17
 */
include_once('eng/site.conf.php');

$db_index = db_connect('idb2.majordomo.ru', 'u134474', 'CP4awWNd6G');
db_select_db('b134474_jf', $db_index);
mysql_set_charset('utf8', $db_index);

if ($USER->already_login()) {
    $userinfo = $_SESSION['USER'];
    $userinfo['logined'] = true;
} else {
    $userinfo = $USER->userinfo('guest@guest.ru');
    $userinfo['logined'] = false;
}
?>