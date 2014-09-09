<?php
/**
 * User: Bargamut
 * Date: 02.07.12
 * Time: 3:55
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');

$_SESSION['USER'] = $USER->auth($_POST['auth_subm'], $_POST['auth_email'], $_POST['auth_pass']);

// Перенаправляем на главную
if (!empty($_SESSION['USER'])) { header('Location: http://' . $_SERVER['SERVER_NAME']); }