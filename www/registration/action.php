<?php
/**
 * User: Bargamut
 * Date: 02.07.12
 * Time: 3:55
 */
include_once('../top.php');

$post = array(
    'rLName' => $_POST['rLName'],
    'rName' => $_POST['rName'],
    'rFName' => $_POST['rFName'],
    'rEmail' => $_POST['rEmail'],
    'rPass' => $_POST['rPass'],
    'rPass2' => $_POST['rPass2'],
    'rLic' => $_POST['rLic']
);

$_SESSION['USER'] = $USER->registration($_POST['rSubm'], $post);