<?php
/**
 * User: Bargamut
 * Date: 12.09.14
 * Time: 4:47
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');

// TODO: добавить проверку на реферера, чтобы домен совпадал с адресом мейла?
$USER->activation($_GET['hash']);