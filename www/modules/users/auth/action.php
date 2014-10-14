<?php
/**
 * User: Bargamut
 * Date: 02.07.12
 * Time: 3:55
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/top.php');

$post = array(
    'email'         => $_POST['auth_email'],
    'pass'          => $_POST['auth_pass']
);

$_SESSION['USER'] = $USER->auth($_POST['auth_subm'], $post);

// Перенаправляем на главную
if (!empty($_SESSION['USER'])) { header('Location: http://' . $_SERVER['SERVER_NAME']); }