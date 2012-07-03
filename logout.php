<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Bargamut
 * Date: 02.07.12
 * Time: 3:55
 */
include_once('top.php');

setcookie ("UID", '', time() - 50000, '/');
setcookie ("email", '', time() - 50000, '/');
setcookie ("password", '', time() - 50000, '/');

header('Location: http://'.$_SERVER['SERVER_NAME']);
?>