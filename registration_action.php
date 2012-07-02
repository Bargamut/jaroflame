<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 02.07.12
 * Time: 3:55
 */
include_once('top.php');

$result = '';

if (!empty($_POST)) {
    !empty($_POST['rPass']) && !empty($_POST['rPass2']) ?
        md5($_POST['rPass']) != md5($_POST['rPass2']) ?
            $result .= NOT_CONF_PASS.'<br />'
        :   null
    : $result .= EMPTY_PASS.'<br />';
}

echo $result ? $result : 'Ok';
?>