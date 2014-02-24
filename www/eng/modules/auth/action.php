<?php
/**
 * User: Bargamut
 * Date: 02.07.12
 * Time: 3:55
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');

$_SESSION['USER'] = $USER->auth($_POST['aSubm'], $_POST['aEmail'], $_POST['aPass']);